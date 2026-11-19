@if ($errors->any())
    <div class="mb-6 rounded-md border border-red-300 bg-red-50 px-4 py-3" role="alert">
        <p class="font-semibold text-sm text-red-800">Corrige los siguientes errores:</p>
        <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif