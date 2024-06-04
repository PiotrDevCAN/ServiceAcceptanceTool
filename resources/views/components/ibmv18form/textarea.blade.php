<p>
    {{-- {{ Form::label($fieldName, $label, $labelOptions) }} --}}
    <label for='{{ $fieldName }}'>{{ $label }} @if ($required === 'required') <span class="ibm-required">*</span> @endif</label>
    <span>
        {{ Form::textarea($fieldName, $value, $options) }}
    </span>
</p>
