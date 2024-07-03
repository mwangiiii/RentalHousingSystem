@component('mail::message')
# Welcome, {{ $name }}

You have been added as a {{ $role }}. Here are your login credentials:

**Email:** {{ $email }}  
**Password:** {{ $password }}

Please use the following link to log in:

@component('mail::button', ['url' => $loginUrl])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent