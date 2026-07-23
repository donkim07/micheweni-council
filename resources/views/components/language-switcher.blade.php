<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            @if (App::getLocale() == 'en')
                <img src="{{ asset('images/flags/en.png') }}" alt="English" width="20"> {{ __('English') }}
            @elseif (App::getLocale() == 'sw')
                <img src="{{ asset('images/flags/sw.png') }}" alt="Kiswahili" width="20"> {{ __('Kiswahili') }}
            @endif
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li>
                <button class="dropdown-item {{ App::getLocale() == 'en' ? 'active' : '' }}" onclick="changeLanguage('en')">
                    <img src="{{ asset('images/flags/en.png') }}" alt="English" width="20"> {{ __('English') }}
                </button>
            </li>
            <li>
                <button class="dropdown-item {{ App::getLocale() == 'sw' ? 'active' : '' }}" onclick="changeLanguage('sw')">
                    <img src="{{ asset('images/flags/sw.png') }}" alt="Kiswahili" width="20"> {{ __('Kiswahili') }}
                </button>
            </li>
        </ul>
    </div>
</div>

<script>
// This is added to ensure the global changeLanguage function is available
// The actual implementation is expected to be in the main layout
if (typeof changeLanguage !== 'function') {
    function changeLanguage(lang) {
        console.warn('changeLanguage function not properly initialized, using fallback');
        localStorage.setItem('selectedLanguage', lang);

        if (lang === 'en') {
            ['','.' + window.location.hostname].forEach(domain => {
                document.cookie = 'googtrans=; Max-Age=0; path=/;';
                document.cookie = `googtrans=; Max-Age=0; path=/; domain=${domain};`;
            });
        } else if (lang === 'sw') {
            document.cookie = 'googtrans=/en/sw; path=/;';
            document.cookie = `googtrans=/en/sw; path=/; domain=${window.location.hostname}`;
        }
        location.reload();
    }
}
</script> 