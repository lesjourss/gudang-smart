@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => true,
])

@php
    // Memetakan tipe alert ke class Bootstrap dan ikon Bootstrap
    $alertTypes = [
        'success' => ['class' => 'alert-success border-success-subtle text-success-emphasis', 'icon' => 'bi-check-circle-fill'],
        'danger'  => ['class' => 'alert-danger border-danger-subtle text-danger-emphasis', 'icon' => 'bi-exclamation-triangle-fill'],
        'warning' => ['class' => 'alert-warning border-warning-subtle text-warning-emphasis', 'icon' => 'bi-exclamation-circle-fill'],
        'info'    => ['class' => 'alert-info border-info-subtle text-info-emphasis', 'icon' => 'bi-info-circle-fill'],
    ];

    $currentType = $alertTypes[$type] ?? $alertTypes['info'];
@endphp

<div {{ $attributes->merge(['class' => 'alert ' . $currentType['class'] . ' d-flex align-items-center shadow-sm rounded-3 py-3 px-4 mb-4 ' . ($dismissible ? 'alert-dismissible fade show' : '')]) }} role="alert">
    <i class="bi {{ $currentType['icon'] }} fs-5 me-3 flex-shrink-0"></i>
    <div class="flex-grow-1">
        {{ $message ?? $slot }}
    </div>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

