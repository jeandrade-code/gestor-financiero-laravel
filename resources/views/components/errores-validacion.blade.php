@if ($errors->any())
    <div class="mb-6 rounded-lg border border-expense-200/80 bg-expense-50/70 px-4 py-3 dark:border-expense-500/20 dark:bg-expense-500/10" role="alert">
        <p class="text-[0.8125rem] font-medium text-expense-800 dark:text-expense-200">Revisa la información del formulario</p>
        <ul class="mt-1.5 list-inside list-disc space-y-0.5 text-[0.75rem] text-expense-700 dark:text-expense-300">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif