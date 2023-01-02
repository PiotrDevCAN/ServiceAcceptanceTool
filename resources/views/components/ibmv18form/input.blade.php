<p class="ibm-form-elem-grp">
    {{-- {{ Form::label($fieldName, $label) }} --}}
    <label for='{{ $fieldName }}'>{{ $label }} @if ($required !== 'false') <span class="ibm-required">*</span> @endif</label>
    <span>
    	{{ Form::text($fieldName, $selectedValue, $options) }}
    </span>
</p>
