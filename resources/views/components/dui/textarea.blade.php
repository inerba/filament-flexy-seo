@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'error' => '',
])
<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <textarea name="{{ $name }}" class="textarea h-24" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
    @if ($error)
        <p class="label text-error">{{ $error }}</p>
    @endif
</fieldset>
