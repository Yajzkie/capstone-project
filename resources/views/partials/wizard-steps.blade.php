@php
    $steps = ['Sighting', 'COTS Count', 'Observer', 'Media'];
@endphp
<div class="wizard-steps">
    @foreach ($steps as $i => $label)
        <div class="wz-step {{ $loop->iteration == $activeStep ? 'active' : '' }} {{ $loop->iteration < $activeStep ? 'done' : '' }}">
            <div class="wz-dot">{!! $loop->iteration < $activeStep ? '&#10003;' : $loop->iteration !!}</div>
            <span class="wz-label">{{ $label }}</span>
        </div>
        @if (!$loop->last)
            <div class="wz-bar {{ $loop->iteration < $activeStep ? 'done' : '' }}"></div>
        @endif
    @endforeach
</div>