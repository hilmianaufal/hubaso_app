<style>
    body {
        background: #f5f7fb;
        font-family: 'Poppins', sans-serif;
        padding-bottom: 110px;
    }

    .hero-box,
    .cart-box {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .table-badge {
        background: #111827;
        color: white;
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .menu-card {
        border-radius: 22px;
        overflow: hidden;
        background: white;
        transition: 0.25s;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .menu-card:hover {
        transform: translateY(-4px);
    }

    .menu-img {
        height: 170px;
        object-fit: cover;
    }

    .checkout-btn {
        border-radius: 16px;
        padding: 13px;
        font-weight: 600;
    }

    .form-control {
        border-radius: 14px;
        padding: 12px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #111827;
        color: white;
        font-weight: bold;
    }

    .remove-btn {
        border: none;
        background: #fee2e2;
        color: #dc2626;
        border-radius: 10px;
        padding: 6px 10px;
        font-size: 13px;
    }

    .menu-disabled {
        opacity: 0.55;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    #categoryFilter::-webkit-scrollbar {
        display: none;
    }

    .category-btn {
        white-space: nowrap;
        border-radius: 999px;
        transition: 0.2s;
    }

    .category-btn.active {
        background: #111827 !important;
        color: white !important;
    }

    .floating-cart {
        position: fixed;
        bottom: 18px;
        left: 16px;
        right: 16px;
        background: #111827;
        color: white;
        border-radius: 22px;
        padding: 14px 16px;
        box-shadow: 0 14px 35px rgba(0,0,0,0.25);
        z-index: 999;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .floating-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .floating-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.12);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .floating-title {
        font-size: 13px;
        color: rgba(255,255,255,0.75);
    }

    .floating-total {
        font-size: 16px;
        font-weight: 700;
    }

    .floating-btn {
        background: white;
        color: #111827;
        padding: 10px 18px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
    }

    .desktop-cart-sticky {
        position: sticky;
        top: 20px;
    }

    .order-type-wrapper {
        display: grid;
        gap: 12px;
    }

    .order-type-card {
        display: flex;
        align-items: center;
        gap: 14px;
        border: 2px solid #e5e7eb;
        border-radius: 18px;
        padding: 14px;
        cursor: pointer;
        transition: 0.2s;
        background: white;
    }

    .order-type-card input {
        display: none;
    }

    .order-type-card.active {
        border-color: #111827;
        background: #f9fafb;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }

    .order-type-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        background: #111827;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .toast-custom {
        position: fixed;
        bottom: 110px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #111827;
        color: white;
        padding: 14px 18px;
        border-radius: 999px;
        z-index: 9999;
        box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        opacity: 0;
        animation: toastIn 0.25s ease forwards;
    }

    .toast-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #22c55e;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .toast-custom.hide {
        animation: toastOut 0.25s ease forwards;
    }

    .btn-loading,
    .menu-loading {
        opacity: 0.45;
        pointer-events: none;
        transition: 0.2s;
    }

    .search-loading {
        border: 2px solid #111827 !important;
    }

    .cart-bounce {
        animation: cartBounce 0.35s ease;
    }

    .card-pulse {
        animation: cardPulse 0.35s ease;
    }

    .qty-bounce {
        animation: qtyBounce 0.25s ease;
    }

    @keyframes toastIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    @keyframes toastOut {
        from {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        to {
            opacity: 0;
            transform: translateX(-50%) translateY(20px);
        }
    }

    @keyframes cartBounce {
        0% { transform: scale(1); }
        40% { transform: scale(1.04); }
        100% { transform: scale(1); }
    }

    @keyframes cardPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }

    @keyframes qtyBounce {
        0% { transform: scale(1); }
        50% { transform: scale(1.35); }
        100% { transform: scale(1); }
    }

    @media (max-width: 576px) {
        body {
            background: #f5f7fb;
        }

        .container {
            padding-left: 14px;
            padding-right: 14px;
        }

        .hero-box {
            border-radius: 28px;
            padding: 22px !important;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            box-shadow: 0 16px 35px rgba(37,99,235,0.22);
        }

        .hero-box .text-muted {
            color: rgba(255,255,255,0.8) !important;
        }

        .table-badge {
            background: rgba(255,255,255,0.18);
            color: white;
            font-size: 12px;
            padding: 8px 12px;
        }

        #searchMenu {
            border: none;
            border-radius: 20px;
            padding: 15px 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        #categoryFilter {
            margin-left: -14px;
            margin-right: -14px;
            padding-left: 14px;
            padding-right: 14px;
        }

        .category-btn {
            padding: 10px 18px !important;
            font-size: 13px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }

        .menu-item {
            padding-left: 6px;
            padding-right: 6px;
            margin-bottom: 14px !important;
        }

        .menu-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(0,0,0,0.07);
            min-height: 100%;
        }

        .menu-img {
            height: 125px;
            object-fit: cover;
        }

        .menu-card .card-body {
            padding: 13px;
        }

        .menu-card .badge {
            font-size: 10px;
            padding: 6px 9px;
        }

        .menu-card h6 {
            font-size: 13px;
            line-height: 1.35;
            min-height: 36px;
            margin-bottom: 6px !important;
        }

        .menu-card small {
            font-size: 11px;
        }

        .menu-card .text-dark {
            font-size: 14px;
            color: #2563eb !important;
        }

        .cart-box {
            border-radius: 26px;
            margin-top: 12px;
        }

        .floating-cart {
            bottom: 14px;
            left: 14px;
            right: 14px;
            border-radius: 24px;
        }

        .desktop-cart-sticky {
            position: static;
        }
    }
</style>