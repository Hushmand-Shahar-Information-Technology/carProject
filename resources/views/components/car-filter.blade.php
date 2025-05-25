@props(['name', 'label', 'options'])

<li class="list-group-item">
    <a href="#">{{ $name }}</a>
    <ul>
        <li>
            <div class="form-check">
                <input class="form-check-input filter-option" type="checkbox" value="*" id="all-{{ Str::slug($name) }}">
                <label class="form-check-label" for="all-{{ Str::slug($name) }}">
                    {{ $label }}
                </label>
            </div>
        </li>

        @foreach ($options as $option)
            <li>
                <div class="form-check">
                    <input class="form-check-input filter-option" type="checkbox"
                        name="{{ $name }}[]" value="{{ $option }}" id="{{ Str::slug($name) . $loop->index }}">
                    <label class="form-check-label" for="{{ Str::slug($name) . $loop->index }}">
                        {{ $option }}
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</li>
