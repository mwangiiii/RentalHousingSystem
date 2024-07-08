@props(['name', 'options', 'selected' => null])

<div>
    @foreach ($options as $value => $label)
        <label class="inline-flex items-center">
            <input type="radio" name="{{ $name }}" value="{{ $value }}" {{ $selected == $value ? 'checked' : '' }} class="form-radio">
            <span class="ml-2">{{ $label }}</span>
        </label>
    @endforeach
</div>