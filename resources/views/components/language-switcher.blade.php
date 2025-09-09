<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" 
            type="button" 
            id="languageDropdown" 
            style="border-radius: 20px; padding: 8px 15px; background: rgba(255, 255, 255, 0.1); color: white; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);"
            onclick="document.getElementById('languageDropdownMenu').classList.toggle('show')">
        <i class="fa fa-language me-2"></i> 
        <span class="d-none d-md-inline fw-medium">
            {{ __('common.languages.' . app()->getLocale()) }}
        </span>
    </button>
    <ul class="dropdown-menu shadow-lg border-0 mt-1" 
        id="languageDropdownMenu"
        aria-labelledby="languageDropdown"
        style="border-radius: 10px; min-width: 200px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);"
        onclick="this.classList.toggle('show')">
        <li style="list-style: none;">
            <a class="dropdown-item d-flex align-items-center py-2 {{ app()->getLocale() == 'en' ? 'active bg-primary text-white' : '' }}" 
               href="{{ route('lang.switch', 'en') }}" style="color: white; background: transparent;">
                <span class="ms-2">{{ __('common.languages.en') }}</span>
            </a>
        </li>
        <li style="list-style: none;">
            <a class="dropdown-item d-flex align-items-center py-2 {{ app()->getLocale() == 'ps' ? 'active bg-primary text-white' : '' }}" 
               href="{{ route('lang.switch', 'ps') }}" style="color: white; background: transparent;">
                <span class="ms-2">{{ __('common.languages.ps') }}</span>
            </a>
        </li>
        <li style="list-style: none;">
            <a class="dropdown-item d-flex align-items-center py-2 {{ app()->getLocale() == 'fa' ? 'active bg-primary text-white' : '' }}" 
               href="{{ route('lang.switch', 'fa') }}" style="color: white; background: transparent;">
                <span class="ms-2">{{ __('common.languages.fa') }}</span>
            </a>
        </li>
    </ul>
</div>
