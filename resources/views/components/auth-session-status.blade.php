@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'login-box-msg']) }}>
        {{ $status }}
    </div>
@endif
