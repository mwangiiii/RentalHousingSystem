@component('mail::message')
# New Maintenance Request

A new maintenance request has been submitted by {{ $maintenanceRequest->tenant->user->name }}.

**Description:**  
{{ $maintenanceRequest->description }}

**Status**
{{ $maintenanceRequest->status}}

This is an automated message.Do not reply.

Thanks,  
{{ config('app.name') }}
@endcomponent
