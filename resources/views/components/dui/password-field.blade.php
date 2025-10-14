@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'error' => '',
])
<fieldset class="fieldset relative" x-data="{ show: false }">
    <legend class="fieldset-legend text-base">{{ $label }}</legend>
    <input :type="show ? 'text' : 'password'" name="{{ $name }}" class="input input-lg w-full font-body"
        placeholder="{{ $placeholder }}" value="{{ $value }}" />
    <button type="button" @click="show = !show"
        class="absolute top-1/2 right-0 mr-3 transform -translate-y-1/2 inline-block hover:scale-110 transition duration-100">
        <template x-if="show">
            @svg('phosphor-eye-duotone', 'size-6')
        </template>
        <template x-if="!show">
            @svg('phosphor-eye-closed', 'size-6')
        </template>
    </button>
    @if ($error)
        <p class="label text-error">{{ $error }}</p>
    @endif
</fieldset>
