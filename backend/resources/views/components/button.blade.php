<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest disabled:opacity-25 transition duration-150 hover:bg-blue-700 w-full mt-6 justify-center focus:outline-none']) }}>
    {{ $slot }}
</button>
