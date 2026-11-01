document.addEventListener('DOMContentLoaded', () => {
    // --- CART LOGIC ---
    const cartDrawer = document.getElementById('cartDrawer');
    const cartOverlay = document.getElementById('cartOverlay');
    const openCartBtn = document.getElementById('openCart');
    const closeCartBtn = document.getElementById('closeCart');

    const toggleCart = () => {
        const isClosed = cartDrawer.classList.contains('translate-x-full');
        if (isClosed) {
            cartDrawer.classList.remove('translate-x-full');
            cartOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // prevent scrolling
        } else {
            cartDrawer.classList.add('translate-x-full');
            cartOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    };

    if(openCartBtn) openCartBtn.addEventListener('click', toggleCart);
    if(closeCartBtn) closeCartBtn.addEventListener('click', toggleCart);
    if(cartOverlay) cartOverlay.addEventListener('click', toggleCart);


    // --- SEARCH LOGIC ---
    const searchModal = document.getElementById('searchModal');
    const openSearchBtn = document.getElementById('openSearch');
    const closeSearchBtn = document.getElementById('closeSearch');

    const toggleSearch = () => {
        if (searchModal.classList.contains('hidden')) {
            searchModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // auto-focus the input
            setTimeout(() => searchModal.querySelector('input').focus(), 100);
        } else {
            searchModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    };

    if(openSearchBtn) openSearchBtn.addEventListener('click', toggleSearch);
    if(closeSearchBtn) closeSearchBtn.addEventListener('click', toggleSearch);
});