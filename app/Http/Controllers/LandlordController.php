<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Carbon;

class LandlordController extends Controller
{
    public function dashboard()
    {
        $landlordId = Auth::user()->id;

        $properties = Property::where('user_id', $landlordId)->with('rooms.tenants')->get();
        $occupiedRooms = 0;
        $availableRooms = 0;

        foreach ($properties as $property) {
            $totalUnits = $property->units;
            $occupiedUnits = $property->rooms->filter(function ($room) {
                return $room->isOccupied();
            })->count();

            $occupiedRooms += $occupiedUnits;
            $availableRooms += $totalUnits - $occupiedUnits;
        }

        $tenants = Tenant::whereHas('room.property', function ($query) use ($landlordId) {
            $query->where('user_id', $landlordId);
        })->get();

        $payments = Payment::whereHas('tenant.room.property', function ($query) use ($landlordId) {
            $query->where('user_id', $landlordId);
        })->get();

        $openRequests = MaintenanceRequest::where('status', 'pending')->count();
        $completedRequests = MaintenanceRequest::where('status', 'completed')->count();

        // Calculate churn rate for the last 12 months
        $churnData = [];
        $totalTenantsAtStart = Tenant::whereHas('room.property', function ($query) use ($landlordId) {
            $query->where('user_id', $landlordId);
        })->whereNull('move_out_date')->count();

        for ($i = 11; $i >= 0; $i--) {
            $startDate = Carbon::now()->subMonths($i + 1)->startOfMonth();
            $endDate = Carbon::now()->subMonths($i + 1)->endOfMonth();

            $tenantsLeft = Tenant::whereHas('room.property', function ($query) use ($landlordId) {
                $query->where('user_id', $landlordId);
            })->whereBetween('move_out_date', [$startDate, $endDate])->count();

            $churnRate = $totalTenantsAtStart > 0 ? ($tenantsLeft / $totalTenantsAtStart) * 100 : 0;
            $churnData[Carbon::now()->subMonths($i + 1)->format('M Y')] = $churnRate;

            // Adjust the total tenants at start for the next month
            $totalTenantsAtStart -= $tenantsLeft;
        }

        $rentCollected = Payment::whereHas('tenant.room.property', function ($query) use ($landlordId) {
            $query->where('user_id', $landlordId);
        })
            ->selectRaw('sum(amount) as total, DATE_FORMAT(ANY_VALUE(created_at), "%b") as month')
            ->groupBy('month')
            ->orderByRaw('ANY_VALUE(created_at) asc')
            ->pluck('total', 'month');

        $outstandingPayments = Tenant::with('payments')
            ->whereHas('room.property', function ($query) use ($landlordId) {
                $query->where('user_id', $landlordId);
            })
            ->get()
            ->map(function ($tenant) {
                $totalPaid = $tenant->payments->sum('amount');
                $outstanding = $tenant->room->rent - $totalPaid;
                return [
                    'tenant' => $tenant->user->name,
                    'outstanding' => $outstanding > 0 ? $outstanding : 0
                ];
            });

        $paymentHistory = Payment::whereHas('tenant.room.property', function ($query) use ($landlordId) {
            $query->where('user_id', $landlordId);
        })
            ->selectRaw('sum(amount) as total, DATE_FORMAT(created_at, "%b") as month')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) asc')
            ->pluck('total', 'month');

        return view('landlord.dashboard', compact('properties', 'occupiedRooms', 'availableRooms', 'tenants', 'payments', 'openRequests', 'completedRequests', 'churnData', 'rentCollected', 'outstandingPayments','paymentHistory'));
    }
}
