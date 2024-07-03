@component('mail::message')
# Hello {{ $tenant->user->name }},

{{ $messageContent }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent