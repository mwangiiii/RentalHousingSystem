@component('mail::message')
# Rent Reminder

Dear {{ $tenantName }},

This is a reminder that your rent for the property at {{ $propertyAddress }} (Room: {{ $roomNumber }}) is due on {{ $dueDate }}. The amount due is ${{ number_format($rentAmount, 2) }}.

Please ensure that the payment is made on time to avoid any late fees.

Click here to go to the payment platform.

@component('mail::button', ['url' => route('tenant.payments', $payment->id)])
Pay Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
