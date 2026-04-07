@if ($errors->any())
<div class="mb-4 rounded-xl px-4 py-3 text-sm font-semibold bg-red-100 text-red-700">
    {{ $errors->first() }}
</div>
@endif
