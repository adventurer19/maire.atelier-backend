{{-- resources/views/livewire/language-switcher.blade.php --}}

<div class="flex items-center gap-1 mr-4">
    <a
        href="{{ route('admin.locale.switch', 'bg') }}"
        @class([
            'flex items-center gap-1 px-2 py-1 rounded-lg text-sm font-medium transition',
            'bg-primary-600 text-white' => app()->getLocale() === 'bg',
            'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' => app()->getLocale() !== 'bg',
        ])
        title="Български"
    >
        <span>🇧🇬</span>
        <span class="hidden sm:inline">БГ</span>
    </a>

    <a
        href="{{ route('admin.locale.switch', 'en') }}"
        @class([
            'flex items-center gap-1 px-2 py-1 rounded-lg text-sm font-medium transition',
            'bg-primary-600 text-white' => app()->getLocale() === 'en',
            'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' => app()->getLocale() !== 'en',
        ])
        title="English"
    >
        <span>🇬🇧</span>
        <span class="hidden sm:inline">EN</span>
    </a>
</div>
