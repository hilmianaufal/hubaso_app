<script>
    const csrfToken = '{{ csrf_token() }}';

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            this.classList.add('btn-loading');
            this.classList.add('menu-loading');

            function animateMenuCard(element)
                {
                    const card = element.classList.contains('menu-card')
                        ? element
                        : element.closest('.menu-card');

                    if (!card) return;

                    card.classList.remove('card-pulse');

                    void card.offsetWidth;

                    card.classList.add('card-pulse');
                }

            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderCart(data.cart, data.total);
                animateFloatingCart();
                showToast('Menu berhasil ditambahkan', 'success');
            })
            .finally(() => {
                this.classList.remove('menu-loading');
            });
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('increase-cart')) {
            updateCart(e.target.dataset.id, 'increase');
        }

        if (e.target.classList.contains('decrease-cart')) {
            updateCart(e.target.dataset.id, 'decrease');
        }

        if (e.target.classList.contains('remove-cart')) {
            updateCart(e.target.dataset.id, 'remove');
        }
    });

    function updateCart(id, action) {
        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: action
            })
        })
    .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                showToast(data.message || 'Stok tidak mencukupi', 'remove');
                throw new Error(data.message);
            }

            return data;
        })
        .then(data => {
            renderCart(data.cart, data.total);
            animateFloatingCart();

            if (action !== 'remove') {
                setTimeout(() => {
                    animateQty(id);
                }, 50);
            }

            if (action === 'remove') {
                showToast('Menu dihapus dari keranjang', 'remove');
            } else {
                showToast('Jumlah pesanan diperbarui', 'update');
            }
        });
    }

    function renderCart(cart, total) {
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const stickyTotal = document.getElementById('sticky-total');
        const checkoutButton = document.getElementById('checkout-button');
        const floatingCart = document.getElementById('floating-cart');
        const floatingCount = document.getElementById('floating-count');

        cartItems.innerHTML = '';

        const cartKeys = Object.keys(cart);

        if (cartKeys.length === 0) {
            cartItems.innerHTML = `
                <p class="text-muted mb-0" id="empty-cart">
                    Keranjang masih kosong
                </p>
            `;

            checkoutButton.disabled = true;
            floatingCart.classList.add('d-none');
        } else {
            checkoutButton.disabled = false;
            floatingCart.classList.remove('d-none');
            floatingCount.innerHTML = `${countCartItems(cart)} item`;

            cartKeys.forEach(id => {
                const item = cart[id];
                const subtotal = item.harga * item.qty;

                cartItems.innerHTML += `
                    <div class="cart-item" data-id="${id}">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <div>
                                <strong>${item.nama}</strong>
                                <br>
                                <small class="text-muted">
                                    Rp ${formatRupiah(item.harga)}
                                </small>
                            </div>

                            <div class="text-end">

                                <div class="d-flex align-items-center gap-2 mb-2">

                                    <button type="button"
                                            class="qty-btn decrease-cart"
                                            data-id="${id}">
                                        -
                                    </button>

                                    <strong class="cart-qty">
                                        ${item.qty}
                                    </strong>

                                    <button type="button"
                                            class="qty-btn increase-cart"
                                            data-id="${id}">
                                        +
                                    </button>

                                </div>

                                <div class="fw-bold cart-subtotal">
                                    Rp ${formatRupiah(subtotal)}
                                </div>

                            </div>

                        </div>

                        <button type="button"
                                class="remove-btn remove-cart"
                                data-id="${id}">
                            Hapus
                        </button>

                        <hr>

                    </div>
                `;
            });
        }

        cartTotal.innerHTML = `Total: Rp ${formatRupiah(total)}`;
        stickyTotal.innerHTML = `Rp ${formatRupiah(total)}`;
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    function countCartItems(cart) {
    let count = 0;

    Object.keys(cart).forEach(id => {
        count += parseInt(cart[id].qty);
    });

    return count;
}

function showToast(message, type = 'success') {
    const oldToast = document.querySelector('.toast-custom');

    if (oldToast) {
        oldToast.remove();
    }

    const toast = document.createElement('div');

    toast.className = 'toast-custom';

    let icon = '✓';

    if (type === 'remove') {
        icon = '×';
    }

    if (type === 'update') {
        icon = '↻';
    }

    toast.innerHTML = `
        <div class="toast-icon">
            ${icon}
        </div>

        <span>
            ${message}
        </span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');

        setTimeout(() => {
            toast.remove();
        }, 250);

    }, 1600);
}

    const searchMenu = document.getElementById('searchMenu');

searchMenu.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();

    document.querySelectorAll('.menu-item').forEach(item => {
        const name = item.dataset.name;
        const category = item.dataset.category;

        if (
            name.includes(keyword) ||
            category.includes(keyword)
        ) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

const categoryButtons =
    document.querySelectorAll('.category-btn');

categoryButtons.forEach(button => {

    button.addEventListener('click', function () {
        playSound('sound-add');
        // hapus active semua
        categoryButtons.forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('btn-dark');
            btn.classList.add('btn-light');
        });

        // active button sekarang
        this.classList.add('active');
        this.classList.add('btn-dark');

        const category =
            this.dataset.category;

        document.querySelectorAll('.menu-item')
        .forEach(item => {

            const itemCategory =
                item.dataset.category;

            if (
                category === 'all' ||
                itemCategory === category
            ) {

                item.style.display = '';

            } else {

                item.style.display = 'none';
            }

        });

    });

});

function animateFloatingCart() {
    const floatingCart = document.getElementById('floating-cart');

    if (!floatingCart) return;

    floatingCart.classList.remove('cart-bounce');

    void floatingCart.offsetWidth;

    floatingCart.classList.add('cart-bounce');
}

function animateMenuCard(button) {
    const card = button.closest('.menu-card');

    if (!card) return;

    card.classList.remove('card-pulse');

    void card.offsetWidth;

    card.classList.add('card-pulse');
}

function animateQty(id) {
    const item = document.querySelector(`.cart-item[data-id="${id}"]`);

    if (!item) return;

    const qty = item.querySelector('.cart-qty');

    if (!qty) return;

    qty.classList.remove('qty-bounce');

    void qty.offsetWidth;

    qty.classList.add('qty-bounce');
}

document.querySelectorAll('.order-type-card').forEach(card => {
    card.addEventListener('click', function () {
        document.querySelectorAll('.order-type-card').forEach(item => {
            item.classList.remove('active');
        });

        this.classList.add('active');

        const radio = this.querySelector('input[type="radio"]');

        if (radio) {
            radio.checked = true;
        }
    });
});

function playSound(id)
{
    const audio = document.getElementById(id);

    if (!audio) return;

    audio.currentTime = 0;
    audio.play().catch(() => {});
}

document.addEventListener('click', function (e) {

    if (e.target.closest('.add-to-cart')) {
        playSound('sound-add');
    }

    if (e.target.closest('#checkout-button')) {
        playSound('sound-checkout');
    }

    if (e.target.closest('.order-type-card')) {
        playSound('sound-click');
    }

    if (e.target.closest('.increase-cart')) {
        playSound('sound-click');
    }

    if (e.target.closest('.decrease-cart')) {
        playSound('sound-click');
    }

    if (e.target.closest('.remove-cart')) {
        playSound('sound-click');
    }

});
</script>