<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-destructive btn-md']) }}>
    {{ $slot }}
</button>