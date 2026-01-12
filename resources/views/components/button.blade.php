<button {{ $attributes->merge(['type' => 'submit', 'class' => 'can-edu-btn-fill disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
