<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentReason;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\MaintenanceRequestSubmitted;
use App\Notifications\MaintenanceRequestNotification;

class TenantsController extends Controller
{
    public function dashboard()
    {
        return view('tenant.dashboard');
    }

    //To display property details for the tenant
    public function property()
    {

        $tenant = Auth::user();
        $tenantDetails = Tenant::where('user_id', $tenant->id)
            ->with('property.landlord', 'property.rooms', 'room', 'payments')
            ->first();

        if (!$tenantDetails) {
            abort(404, 'Tenant details not found');
        }

        $property = $tenantDetails->property;
        $room = $tenantDetails->room;
        $landlord = $property->landlord;
        $maintenanceWorker = $this->getUserByRoleAndProperty('Maintenance Worker', $property->id);
        $propertyManager = $this->getUserByRoleAndProperty('Property Manager', $property->id);

        // Fetch the payments details
        $payments = $tenant->payments()->orderBy('due_date', 'asc')->get();

        // Fetch the rental agreement PDF path
        $pdfPath = 'rental-agreements/' . $tenant->id . '.pdf';
        return view('tenant.property', compact('landlord', 'property', 'payments', 'tenantDetails', 'room', 'maintenanceWorker', 'propertyManager', 'pdfPath'));
    }

    private function getUserByRoleAndProperty($roleName, $propertyId)
    {
        return User::whereHas('role', function ($query) use ($roleName, $propertyId) {
            $query->where('role_name', $roleName)
                ->where('property_id', $propertyId);
        })->first();
    }

    //Payments Form
    public function payments()
    {
        $paymentReasons = PaymentReason::all();

        return view('tenant.payments', compact('paymentReasons'));
    }

    // Payments Logic
    public function storePayment(Request $request)
    {
        // Validate data
        $request->validate([
            'phone_number' => 'required|string',
            'payment_reason_id' => 'required|exists:payment_reasons,id',
        ]);

        // Get the tenant details
        $tenant = Auth::user()->tenant()->first();
        $paymentReason = PaymentReason::find($request->payment_reason_id);

        // Ensure the tenant has a room
        if (!$tenant->room) {
            return back()->withErrors(['error' => 'Tenant is not associated with any room.']);
        }

        // Format phone number
        $phoneNumber = preg_replace('/\D/', '', $request->phone_number); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 3) !== '254') {
            $phoneNumber = '254' . $phoneNumber;
        }

        // Ensure phone number starts with '2547'
        if (substr($phoneNumber, 0, 4) !== '2547') {
            return redirect()->back()->with('error', 'Invalid phone number. It must start with 2547.');
        }

        $final_phone_number = intval($phoneNumber);

        // Calculate the due date (5th of the next month)
        $due_date = Carbon::now()->startOfMonth()->addMonths(1)->addDays(4);

        // Initiate an STK Push
        $response = $this->initiateSTKPush($final_phone_number, $paymentReason);

        if ($response['ResponseCode'] == "0") {
            // Create a new payment
            $payment = Payment::create([
                'tenant_id' => $tenant->id,
                'amount' => 0, // Set to zero initially, update after successful payment
                'payment_date' => now(),
                'due_date' => $due_date,
                'status' => 'pending',
                'user_id' => Auth::id(),
                'payment_reason_id' => $request->payment_reason_id,
                'transaction_id' => $response['CheckoutRequestID']
            ]);
            return back()->with('success', 'STK Push initiated successfully. Check the phone number added');
        } else {
            return back()->withErrors(['error' => 'Failed to initiate STK Push.']);
        }
    }

    // Getting the saf token 
    public function token()
    {
        $consumerKey = getenv('SAFARICOM_CONSUMER_KEY');
        $consumerSecret = getenv('SAFARICOM_CONSUMER_SECRET');
        $url = getenv('SAFARICOM_TOKEN_URL');

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url);

        return $response['access_token'];
    }

    // STK Push Logic
    public function initiateSTKPush($phoneNumber, $paymentReason)
    {
        //Get all these requirements from developer.safaricom

        // Calling the token
        $accessToken = $this->token();
        // URL to deal with mpesa express
        $url = getenv('SAFARICOM_EXPRESS_URL');
        // Variable to deal with mpesa passkey
        $passkey = getenv('SAFARICOM_PASSKEY');
        $businessShortCode = 174379;
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($businessShortCode . $passkey . $timestamp);
        $transactionType = 'CustomerPayBillOnline';
        $amount = 1;
        $PartyA = $phoneNumber;
        $PartyB = 174379;
        $phone_number = $phoneNumber;
        // $callbackUrl = 'https://api.countyos.hasibu.ke/test/ipn';
        $callbackUrl = 'https://shining-rabbit-uniquely.ngrok-free.app/tenant/payments/response';
        $accountReference = getenv('APP_NAME');
        $TransactionDesc = $paymentReason->name;

        $response = Http::withToken($accessToken)->post($url, [
            'BusinessShortCode' => $businessShortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => $transactionType,
            'Amount' => $amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' => $phone_number,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => $accountReference,
            'TransactionDesc' => $TransactionDesc
        ]);

        return $response;
    }

    // STK Callback
    public function callback(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $callbackData = $data['Body']['stkCallback'];
        $transactionId = $callbackData['CheckoutRequestID'];


        // Save the data to a file for testing
        Storage::disk('local')->put('stk.txt', json_encode($callbackData));

        // Retrieve payment entry
        $payment = Payment::where('transaction_id', $transactionId)->first();

        // Process the callback data as needed
        if ($callbackData['ResultCode'] == 0) {
            // Successful transaction logic
            $amount = $callbackData['CallbackMetadata']['Item'][0]['Value'];
            // $mpesaReceiptNumber = $callbackData['CallbackMetadata']['Item'][1]['Value'];
            // $transactionDate = $callbackData['CallbackMetadata']['Item'][3]['Value'];
            // $phoneNumber = $callbackData['CallbackMetadata']['Item'][4]['Value'];

            $payment->update([
                'amount' => $amount,
                'status' => 'completed',
                'payment_date' => now(),
            ]);

            // e.g., update payment status in the database
        } else {
            // Failed transaction logic
            $failureReason = $callbackData['ResultDesc'];
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $failureReason
            ]);
            Log::error('Transaction failed', ['reason' => $failureReason]);
        }
        return response()->json(['status' => 'success']);
    }

    // Maintenance Ticket Form
    public function maintenance()
    {
        $tenant = auth()->user()->tenant()->with(['property.maintenanceWorkers', 'property'])->first();
        $property = $tenant->property;

        // Fetch the first maintenance worker for simplicity (you can adapt this logic)
        $maintenanceWorker = $property->maintenanceWorkers->first();
        return view('tenant.maintenance', compact('tenant', 'maintenanceWorker'));
    }

    // Maintenance Ticket Logic
    public function submitMaintenanceRequest(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $tenant = auth()->user()->tenant()->with('property.maintenanceWorkers')->firstOrFail();

        //Store the maintenance request 
        $maintenanceRequest = MaintenanceRequest::create([
            'tenant_id' => $tenant->id,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        // Get the maintenance worker's contact details
        $maintenanceWorker = $tenant->property->maintenanceWorkers->first();

        // Get the Tenants contact details
        $tenantPhoneNumber = auth()->user()->phone_number;

        // dd($tenantPhoneNumber);
        // Notify the maintennace worker
        $maintenanceWorker->notify(new MaintenanceRequestNotification($maintenanceRequest->description, $tenantPhoneNumber));

        // Send email to the maintenance worker
        Mail::to($maintenanceWorker->email)->send(new MaintenanceRequestSubmitted($maintenanceRequest));

        return redirect()->route('tenant.maintenance')->with('success', 'Maintenance request submitted successfully.');
    }

    // Display Messages Logic
    public function messages()
    {
        return view('tenant.messages');
    }
}
