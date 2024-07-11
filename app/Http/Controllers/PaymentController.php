<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenant;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('tenant')->orderBy('updated_at', 'desc')->paginate(10);
        $properties = Property::all();
        // Collect unique statuses from payments
        $statuses = Payment::select('status')->distinct()->get()->map(function ($item) {
            return ['id' => $item->status, 'name' => ucfirst($item->status)];
        })->prepend(['id' => '', 'name' => __('All')]);
        // dd($statuses);
        return view('landlord.payments', compact('payments', 'properties', 'statuses'));
    }

    public function filter(Request $request)
    {
        $query = Payment::with('tenant');

        if ($request->filled('date')) {
            $query->whereDate('payment_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('property_id')) {
            $query->whereHas('tenant', function ($q) use ($request) {
                $q->where('property_id', $request->property_id);
            });
        }

        $payments = $query->paginate(10);

        return view('landlord.payments', [
            'payments' => $payments,
            'properties' => Property::all(),
            'statuses' => Payment::select('status')->distinct()->get()->map(function ($item) {
                return ['id' => $item->status, 'name' => ucfirst($item->status)];
            })->prepend(['id' => '', 'name' => __('All')]),
        ]);
    }
}