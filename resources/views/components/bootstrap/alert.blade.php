@props(['type', 'message'])

@php
    $icons = [
        'success'   => 'bi-check-circle',
        'danger'    => 'bi-x-circle',
        'warning'   => 'bi-exclamation-triangle',
        'info'      => 'bi-info-circle',
        'primary'   => 'bi-star',
        'secondary' => 'bi-dash-circle',
    ];
    $icon = $icons[$type] ?? 'bi-info-circle';
@endphp

<div class="alert alert-{{ $type }} alert-dismissible d-flex align-items-center" role="alert">
    <i class="bi {{ $icon }} mr-2"></i>
    <span>{{ $message }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
