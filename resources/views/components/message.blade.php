@if (Session::has('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 bg-green-500 text-white px-6 py-2 rounded shadow-lg z-50"
    >
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50"
    >
        {{ Session::get('error') }}
    </div>
@endif
