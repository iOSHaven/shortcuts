<div>
    <select wire:model.live="locale" class="border rounded px-2 py-1 dark:bg-slate-800">
        <option value="en" {{ $locale === 'en' ? 'selected' : '' }}>English</option>
        <option value="es" {{ $locale === 'es' ? 'selected' : '' }}>Español</option>
        <option value="pt" {{ $locale === 'pt' ? 'selected' : '' }}>Português</option>
        <!-- add more locales here -->
    </select>
</div>
