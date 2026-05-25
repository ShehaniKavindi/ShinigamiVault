<!-- header -->
<header class="header">
    <div class="brand-name">
        <h1>SHINIGAMI VAULT</h1>
    </div>
    <div class="brand-headers">
        <a href="home.php"> Home</a>
        <a href=""> Oversized</a>
        <a href=""> Hoodies</a>
        <a href=""> Collections</a>
        <a href=""> Discover Us</a>
    </div>
    <div class="header-btns">
        <i class="bi bi-search" onclick="gotoSearch();"></i>
        <i class="bi bi-brightness-high"></i>
        <i class="bi bi-bag" onclick="openCart()"></i>
        <i class="bi bi-person"></i>
    </div>
</header>

<!-- Overlay -->
<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cartSidebar">
    
    <!-- Header -->
    <div class="cart-header">
        <h2 class="cart-title">The Vault</h2>
        <button class="cart-close" onclick="closeCart()">✕</button>
    </div>

    
    <!-- Items -->
    <div class="cart-items">
        <div class="cart-item">
            <img src="assets/products/sample.png" alt="Product" class="cart-item-img">
            <div class="cart-item-info">
                <p class="cart-item-name">Jujutsu Kaisen | Gojo Satoru Oversized Tee</p>
                <p class="cart-item-price">LKR. 2200.00</p>
                <p class="cart-item-variant">x 1 | Black</p>
            </div>
            <button class="cart-item-remove" title="Remove">✕</button>
        </div>
    </div>

    <!-- cart footer -->
    <div class="cart-footer">
        <div class="cart-total-row">
            <span class="cart-total-label">Total :</span>
            <span class="cart-total-amount">2200.00 LKR</span>
        </div>
        <button class="primary-btn">Checkout</button>
    </div>

</div>

<style>
    /* Overlay */
    .cart-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.35);
        z-index: 1040;
    }

    .cart-overlay.active {
        display: block;
    }

    /* Sidebar */
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: 0;
        width: 420px;
        max-width: 100vw;
        height: 100vh;
        background: var(--white);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .cart-sidebar.open {
        transform: translateX(0);
    }

    /* Header */
    .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.4rem 1.5rem 1rem;
        border-bottom: 0.5px solid rgba(0, 0, 0, 0.1);
    }

    .cart-title {
        font-family: 'header';
        font-size: 32px;
        color: var(--red);
        letter-spacing: 0.03em;
        margin: 0;
    }

    .cart-close {
        background: none;
        border: none;
        font-size: 20px;
        color: var(--black);
        cursor: pointer;
        padding: 0;
        line-height: 1;
        font-family: 'header'
    }

    .cart-close:hover {
        color: var(--red);
    }

    /* Items */
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cart-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border: 0.5px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background: #fafafa;
    }

    .cart-item-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        background: none;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-name {
        font-size: 12px;
        font-weight: 500;
        color: var(--dark-grey);
        line-height: 1.4;
        margin-bottom: 4px;
    }

    .cart-item-price {
        font-family: 'header';
        font-size: 18px;
        color: var(--black);
        letter-spacing: 1px;
    }

    .cart-item-variant {
        font-size: 12px;
        color: var(--dark-grey);
        letter-spacing: 1px;
    }

    .cart-item-remove {
        background: none;
        border: none;
        color: #bbb;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        align-self: flex-start;
        line-height: 1;
    }

    .cart-item-remove:hover {
        color: var(--red);
    }

    /* Footer */
    .cart-footer {
        padding: 1.25rem 1.5rem;
        border-top: 0.5px solid rgba(0, 0, 0, 0.1);
    }

    .cart-total-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 1rem;
    }

    .cart-total-label {
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 1px;
        color: var(--dark-grey);
    }

    .cart-total-amount {
        font-family: 'header';
        font-size: 25px;
        color: var(--red);
        letter-spacing: 1px;
    }

</style>

<script>
    function openCart() {
        document.getElementById('cartSidebar').classList.add('open');
        document.getElementById('cartOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        document.getElementById('cartSidebar').classList.remove('open');
        document.getElementById('cartOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
</script>