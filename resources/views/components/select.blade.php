@props(['options' => [], 'fieldName','idField'])

<select {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    @foreach($options as $option)
        <option value="{{ $option ->$idField }}">
        {{ data_get($option, $fieldName) }}
        </option>
    @endforeach
</select>