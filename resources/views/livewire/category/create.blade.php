<div class="card-body">
    <form method="POST">
        <x-alert />
        {{-- Title --}}
        <div class="mb-3">
            <x-jet-label value="{{ __('Sygjeroni Kategori Të Reja') }}" />

            <x-jet-input class="{{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" wire:model='category'
                name="category" required />
            <x-jet-input-error for="category"></x-jet-input-error>
        </div>

        <div class="mb-0">
            <div class="d-flex justify-content-end align-items-baseline">
                <x-jet-button wire:click.prevent='store()'>
                    {{ __('Sygjeroni') }}
                </x-jet-button>
            </div>
        </div>
    </form>
</div>
