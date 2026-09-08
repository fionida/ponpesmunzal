document.addEventListener('alpine:init', () => {
    Alpine.data('site', () => ({
        menuOpen: false,
        searchOpen: false,
        openFaq: null,
        filter: 'semua',
        query: '',
    }));
});
