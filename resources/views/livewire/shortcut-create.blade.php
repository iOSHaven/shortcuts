<x-page>
    <div class="space-y-6">
    <x-back-button />
    <div class="space-y-3">
        <div class="flex items-center space-x-3">
            <h1 class="text-5xl">{{ __('Create Shortcut') }}</h1>
        </div>
    </div>

    <x-shortcut-form :step="$this->step" :shortcut="['name' => $this->name, 'icon' => $this->icon, 'description' => $this->description]"/>
</div>
</x-page>
