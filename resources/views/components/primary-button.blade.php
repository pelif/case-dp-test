<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary w-100 fw-bolder']) }}>
    {{ $slot }}
</button>
