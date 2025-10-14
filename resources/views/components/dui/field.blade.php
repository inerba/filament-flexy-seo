@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'error' => '',
])
<fieldset class="fieldset ">
    <legend class="fieldset-legend text-base">{{ $label }}</legend>
    <input type="{{ $type }}" name="{{ $name }}" class="input input-lg w-full font-body"
        placeholder="{{ $placeholder }}" value="{{ $value }}" />
    @if ($error)
        <p class="label text-error">{{ $error }}</p>
    @endif
</fieldset>
