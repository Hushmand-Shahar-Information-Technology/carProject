@props(['name', 'label', 'options'])

<li class="list-group-item">
    <a href="javascript:void(0)" class="filter-header d-flex justify-content-between align-items-center">
        <span>{{ $name }}</span>
        <i class="fa fa-chevron-down filter-arrow"></i>
    </a>
    <ul class="filter-options" style="display: none;">
        <li>
            <div class="form-check">
                <input class="form-check-input filter-option" type="checkbox" value="*" id="all-{{ Str::slug($name) }}" checked>
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