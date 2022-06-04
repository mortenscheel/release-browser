@if(session()->has('error'))
    <div {{ $attributes->class("p-4 bg-red-600 text-gray-100 font-semibold rounded") }}>
        {{ session()->get('error') }}
    </div>
@endif
