@props(['options' => [], 'fieldName', 'idField', 'selected' => null])

<select {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    <option value="">{{ __('Select an option') }}</option>
    @foreach($options as $option)
        @if(is_object($option))
            <option value="{{ $option->$idField }}" {{ $selected == $option->$idField ? 'selected' : '' }}>
                {{ data_get($option, $fieldName) }}
            </option>
        @elseif(is_array($option))
            <option value="{{ $option[$idField] }}" {{ $selected == $option[$idField] ? 'selected' : '' }}>
                {{ $option[$fieldName] }}
            </option>
        @endif
    @endforeach
</select>