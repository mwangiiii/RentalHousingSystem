<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\Payment;
use App\Mail\RentReminder;
use Illuminate\Support\Facades\Mail;


class SendRentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-rent-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send rent reminders to tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = Tenant::with('user', 'property', 'room')->get();
        $nextMonth = Carbon::now()->addMonth();
        $dueDate = Carbon::create($nextMonth->year, $nextMonth->month, 5);

        foreach ($tenants as $tenant) {
            $payment = Payment::create([
                'tenant_id' => $tenant->id,
                'amount' => $tenant->room->rent,
                'payment_date' => null,
                'due_date' => $dueDate,
                'status' => 'pending',
                'user_id' => $tenant->user_id
            ]);

            // Send reminder email
            Mail::to($tenant->user->email)->send(new RentReminder($tenant, $payment));
        }

        $this->info('Rent reminders have been sent successfully.');
    }
}
