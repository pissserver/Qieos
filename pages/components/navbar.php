<style>
    .cart-btn {
        background: #1F2937;
        color: white;
        border-radius: 50px;
        width: 50px;
        height: 50px;
        display: flex;
        font-size: 20px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
    }

    /* badge merah */
    .cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;

        background: #ef4444;
        color: #fff;

        font-size: 10px;
        font-weight: bold;

        padding: 3px 6px;
        border-radius: 50px;

        min-width: 18px;
        text-align: center;

        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
        padding-right: 10px;

        /* Smooth scroll */
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #6366f1;
        border-radius: 10px;
    }

    .cart-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* CARD */
    .cart-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .cart-card:hover {
        transform: translateY(-3px);
    }

    /* LEFT */
    .cart-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .cart-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
    }

    /* TEXT */
    .cart-title {
        font-weight: 600;
        font-size: 15px;
    }

    .cart-meta {
        display: flex;
        gap: 6px;
        margin-top: 5px;
    }

    /* BADGES */
    .badge-price {
        background: #eef2ff;
        color: #4f46e5;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 12px;
    }

    .badge-qty {
        background: #ecfeff;
        color: #0891b2;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 12px;
    }

    /* QTY */
    .cart-qty {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 110px;
        /* penting biar simetris */
        justify-content: center;
    }

    .cart-qty button {
        background: #6366f1;
        border: none;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        font-weight: bold;
    }

    .cart-qty span {
        width: 30px;
        text-align: center;
        font-weight: bold;
    }

    /* RIGHT */
    .cart-right {
        text-align: right;
        min-width: 140px;
        /* biar harga panjang tetap rapi */
    }

    .cart-subtotal {
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .remove-btn {
        color: #ef4444;
        cursor: pointer;
    }

    .cart-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    /* TOTAL BOX */
    .cart-total-box {
        background: linear-gradient(45deg, #6366f1, #8b5cf6);
        color: white;
        padding: 10px 15px;
        border-radius: 12px;
        flex: 1;
    }

    .total-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .total-value {
        font-size: 16px;
        font-weight: bold;
    }

    /* BUTTON */
    .btn-checkout {
        background: #111827;
        color: white;
        border-radius: 12px;
        padding: 10px 20px;
        border: none;
        transition: 0.3s;
        white-space: nowrap;
    }

    .btn-checkout:hover {
        background: #000;
        transform: translateY(-1px);
    }

    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 60px;
        color: #6366f1;
        margin-bottom: 15px;
    }

    .empty-cart h5 {
        font-weight: 600;
        color: #111827;
        margin-bottom: 5px;
    }

    .empty-cart p {
        font-size: 14px;
    }

    .empty-cart {
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .omzet-card {
        display: flex;
        height: 62px;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        background: #1F2937;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        width: fit-content;
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .omzet-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
    }

    .omzet-icon {
        background: linear-gradient(135deg, #f59e0b, #facc15);
        color: #000;
        padding: 10px;
        border-radius: 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .omzet-content .label {
        font-size: 11px;
        color: #94a3b8;
    }

    .omzet-content .amount {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #fff;
    }

    @keyframes pulseGlow {
        0% {
            transform: scale(1);
            text-shadow: 0 0 0px rgba(250, 204, 21, 0);
        }

        50% {
            transform: scale(1.15);
            text-shadow: 0 0 12px rgba(250, 204, 21, 0.9);
        }

        100% {
            transform: scale(1);
            text-shadow: 0 0 0px rgba(250, 204, 21, 0);
        }
    }

    .pulse {
        animation: pulseGlow 0.6s ease;
    }

    /* MOBILE FIX */
    @media (max-width: 576px) {

        .cart-card {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        /* TOP: image + title */
        .cart-left {
            width: 100%;
        }

        /* MIDDLE: qty */
        .cart-qty {
            justify-content: center;
            width: 100%;
        }

        /* BOTTOM: subtotal + delete */
        .cart-right {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .cart-subtotal {
            font-size: 16px;
        }

        .remove-btn {
            font-size: 20px;
        }
    }

    /* ==========================================
    PREMIUM NAVBAR V3
    ========================================== */

    .premium-navbar{
        width:100%;
        min-height:85px;

        display:flex;
        align-items:center;
        justify-content:space-between;

        padding:16px 24px;
        margin-top: 20px;

        position:sticky;
        top:12px;
        z-index:100;

        border-radius:24px;

        background:
            linear-gradient(
                135deg,
                #081120,
                #0f1f3a,
                #081120
            );

        border:1px solid rgba(255,255,255,.06);

        box-shadow:
            0 15px 40px rgba(0,0,0,.25);

        margin-bottom:15px;
    }

    .premium-brand{
        display:flex;
        align-items:center;
        gap:15px;
    }

    .brand-content h4{
        margin:0;
        color:white;
        font-size:22px;
        font-weight:700;
    }

    .brand-content span{
        color:#94a3b8;
        font-size:13px;
    }

    .premium-actions{
        display:flex;
        align-items:center;
        gap:16px;
    }

    .premium-action-btn{
        width:56px;
        height:56px;

        border-radius:18px;

        background:
            rgba(255,255,255,.05);

        border:
            1px solid rgba(255,255,255,.08);

        display:flex;
        align-items:center;
        justify-content:center;

        color:white;
        cursor:pointer;

        position:relative;

        transition:.3s;
    }

    .premium-action-btn:hover{
        transform:translateY(-3px);
    }

    .premium-omzet{
        display:flex;
        align-items:center;
        gap:12px;

        padding:12px 18px;

        border-radius:18px;

        background:
            rgba(255,255,255,.05);

        border:
            1px solid rgba(255,255,255,.08);
    }

    .premium-omzet-icon{
        width:45px;
        height:45px;

        border-radius:14px;

        background:
            linear-gradient(
                135deg,
                #f59e0b,
                #facc15
            );

        display:flex;
        align-items:center;
        justify-content:center;

        color:black;
    }

    .omzet-label{
        display:block;
        color:#94a3b8;
        font-size:11px;
    }

    .omzet-value{
        color:white;
        font-weight:700;
        font-size:18px;
    }

    .premium-profile{
        display:flex;
        align-items:center;
        gap:12px;

        padding:8px 14px;

        border-radius:18px;

        background:
            rgba(255,255,255,.05);

        border:
            1px solid rgba(255,255,255,.08);
    }

    .premium-avatar{
        width:44px;
        height:44px;
        border-radius:50%;
        object-fit:cover;
    }

    .premium-name{
        color:white;
        font-weight:600;
    }

    .premium-role{
        color:#94a3b8;
        font-size:12px;
    }

    .premium-dropdown{
        min-width: 230px;
        margin-top: 14px !important;

        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);

        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 10px;

        box-shadow:
            0 10px 30px rgba(0,0,0,0.35),
            0 0 0 1px rgba(255,255,255,0.03) inset;

        transform-origin: top right;

        /* state awal (hidden) */
        opacity: 0;
        transform: translateY(-10px) scale(0.96);

        transition:
            opacity .25s ease,
            transform .25s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    /* saat bootstrap menambahkan class "show" */
    .premium-dropdown.show{
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* ITEM */
    .premium-dropdown .dropdown-item{
        display: flex;
        align-items: center;
        gap: 10px;

        color: #f8fafc;
        font-weight: 500;

        border-radius: 12px;
        padding: 12px 14px;

        transition: all .2s ease;
    }

    /* ICON */
    .premium-dropdown .dropdown-item i{
        width: 20px;
        text-align: center;
        font-size: 1rem;
        transition: transform .2s ease;
    }

    /* HOVER ITEM */
    .premium-dropdown .dropdown-item:hover{
        background: linear-gradient(
            135deg,
            rgba(59,130,246,0.18),
            rgba(99,102,241,0.18)
        );

        color: #fff;
        transform: translateX(4px);
    }

    .premium-dropdown .dropdown-item:hover i{
        transform: scale(1.15);
    }

    /* DIVIDER */
    .premium-dropdown .dropdown-divider{
        border-color: rgba(255,255,255,0.08);
        margin: 8px 0;
    }

    /* DANGER ITEM */
    .premium-dropdown .text-danger{
        color: #f87171 !important;
    }

    .premium-dropdown .text-danger:hover{
        background: rgba(239,68,68,.12);
        color: #ff9c9c !important;
    }

    .premium-chevron {
        transition: transform 0.3s ease;
    }

    /* saat dropdown terbuka */
    .show .premium-chevron {
        transform: rotate(180deg);
    }

    @media(max-width:991px){

        .premium-navbar{
            flex-direction:column;
            gap:15px;
        }

        .premium-actions{
            width:100%;
            flex-wrap:wrap;
            justify-content:center;
        }

    }

    @media (max-width:576px){

        .premium-navbar{
            flex-direction:row;
            align-items:center;
            justify-content:space-between;

            padding:12px;
            min-height:auto;
        }

        .premium-brand{
            display:none;
        }

        .premium-actions{
            gap:8px;
            flex-wrap:nowrap;
        }

        .premium-action-btn{
            width:42px;
            height:42px;
            border-radius:12px;
            font-size:14px;
        }

        .search-trigger,
        .whatsnew-nav-btn,
        #whatsNewBtn{
            display:none !important;
        }

        .premium-omzet{
            min-width:auto;
            padding:8px 10px;
            gap:8px;
        }

        .premium-omzet-icon{
            width:32px;
            height:32px;
            border-radius:10px;
            font-size:12px;
        }

        .omzet-label{
            display:none;
        }

        .omzet-value{
            font-size:13px;
            white-space:nowrap;
        }

        .premium-user{
            display:none;
        }

        .premium-profile{
            padding:5px;
            border-radius:14px;
        }

        .premium-avatar{
            width:36px;
            height:36px;
        }

    }

    /* Update Overlay Styles */
    .update-overlay{
        position:fixed;
        inset:0;

        display:none;

        justify-content:center;
        align-items:center;

        background:rgba(7,15,30,.45);
        backdrop-filter:blur(10px);

        z-index:999999;
    }

    .update-modal{
        width:650px;
        max-width:92%;

        height:700px;
        max-height:90vh;

        background:#fff;
        border-radius:24px;

        display:flex;
        flex-direction:column;

        overflow:hidden;

        box-shadow:0 30px 80px rgba(0,0,0,.30);

        animation:showUpdate .35s ease;
    }

    .update-header{

        padding:35px;

        text-align:center;

        color:white;

        background:
            linear-gradient(135deg,#4338ca,#7c3aed);

        position:relative;

        flex-shrink:0;
    }

    .update-icon{

        width:72px;
        height:72px;

        margin:auto;

        border-radius:50%;

        display:flex;
        justify-content:center;
        align-items:center;

        font-size:34px;

        background:rgba(255,255,255,.18);

        margin-bottom:15px;

    }

    .update-header h4{

        font-size:28px;

        font-weight:700;

        margin-bottom:15px;

    }

    .update-meta{

        display:flex;

        justify-content:center;

        gap:12px;

        flex-wrap:wrap;

    }

    .update-meta span{

        padding:8px 16px;

        border-radius:999px;

        font-weight:600;

        font-size:13px;

    }

    #updateTitle {
        color: #fff;
    }

    .update-body{
        flex:1;

        padding:30px;
        padding-bottom:40px;

        overflow-y:auto;
        overflow-x:hidden;

        scrollbar-width:none;
        -ms-overflow-style:none;
    }

    .update-body::-webkit-scrollbar{
        display:none;
    }

    .update-item{

        display:flex;

        gap:18px;

        align-items:flex-start;

        padding:15px 18px;

        border-radius:14px;

        background:#f8fafc;

        margin-bottom:12px;

        transition:.25s;

    }

    .update-item:hover{

        transform:translateX(5px);

        background:#eef4ff;

    }

    .update-item:last-child{

        border:none;

    }

    .update-item i{

        color:#10b981;

        font-size:20px;

        margin-top:2px;

    }

    .closeUpdate{

        position:absolute;

        right:20px;
        top:20px;

        width:42px;
        height:42px;

        border:none;

        border-radius:50%;

        background:rgba(255,255,255,.18);

        color:white;

        transition:.25s;

    }

    .closeUpdate:hover{

        background:white;

        color:#4f46e5;

        transform:rotate(90deg);

    }

    @keyframes showUpdate{

        0%{

            opacity:0;

            transform:scale(.85);

        }

        100%{

            opacity:1;

            transform:scale(1);

        }

    }

    @media (max-width:768px){

        .update-modal{
            width:95%;
            height:90vh;
            border-radius:20px;
        }

        .update-body{
            padding:24px;
            padding-bottom:60px;
        }

    }

    .stock-badge{
        padding:8px 14px;
        border-radius:10px;
        font-weight:700;
    }

    .stock-success{
        background:#dcfce7;
        color:#166534;
    }

    .stock-danger{
        background:#fee2e2;
        color:#991b1b;
    }

    .unit-badge{
        padding:8px 14px;
        border-radius:10px;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        font-weight:600;
    }

    /* ===================== GLOBAL SEARCH ===================== */
    .search-trigger{
        width:56px;height:56px;border-radius:18px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;color:white;cursor:pointer;transition:.3s;position:relative
    }
    .search-trigger:hover{transform:translateY(-3px);background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.3)}
    .search-trigger .kbd-hint{
        position:absolute;bottom:-4px;right:-4px;background:rgba(99,102,241,.9);color:white;font-size:8px;font-weight:700;padding:2px 5px;border-radius:6px;letter-spacing:.02em;opacity:.8
    }

    .search-overlay{
        position:fixed;inset:0;z-index:999999;display:flex;align-items:flex-start;justify-content:center;padding:60px 20px 20px;
        background:rgba(7,15,30,.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
        opacity:0;visibility:hidden;transition:opacity .25s ease,visibility .25s ease
    }
    .search-overlay.active{opacity:1;visibility:visible}

    .search-container{
        width:100%;max-width:620px;
        background:linear-gradient(145deg,#0c1322,#111c30);
        border:1px solid rgba(255,255,255,.08);
        border-radius:24px;
        box-shadow:0 30px 80px rgba(0,0,0,.5),0 0 60px rgba(99,102,241,.1);
        overflow:hidden;
        transform:translateY(-30px) scale(.95);transition:transform .3s cubic-bezier(.16,1,.3,1),opacity .25s ease;opacity:0
    }
    .search-overlay.active .search-container{transform:translateY(0) scale(1);opacity:1}

    .search-input-wrap{
        display:flex;align-items:center;gap:14px;padding:18px 22px;border-bottom:1px solid rgba(255,255,255,.06)
    }
    .search-input-wrap i{font-size:20px;color:#818cf8;flex-shrink:0}
    .search-input{
        flex:1;background:transparent;border:none;outline:none;color:#f1f5f9;font-size:16px;font-weight:500;font-family:inherit
    }
    .search-input::placeholder{color:#64748b}
    .search-close-btn{
        background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);color:#94a3b8;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:600;cursor:pointer;transition:.2s;flex-shrink:0;font-family:inherit
    }
    .search-close-btn:hover{background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);color:#f87171}

    .search-body{max-height:400px;overflow-y:auto;padding:10px 12px;scrollbar-width:thin;scrollbar-color:rgba(99,102,241,.3) transparent}
    .search-body::-webkit-scrollbar{width:5px}
    .search-body::-webkit-scrollbar-track{background:transparent}
    .search-body::-webkit-scrollbar-thumb{background:rgba(99,102,241,.3);border-radius:10px}

    .search-section-label{
        font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;padding:8px 12px 4px;display:flex;align-items:center;gap:6px
    }
    .search-section-label i{font-size:10px}

    .search-item{
        display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:14px;cursor:pointer;transition:all .2s ease
    }
    .search-item:hover,.search-item.focused{background:linear-gradient(135deg,rgba(99,102,241,.12),rgba(139,92,246,.1))}
    .search-item:hover .search-item-icon,.search-item.focused .search-item-icon{transform:scale(1.1)}

    .search-item-icon{
        width:38px;height:38px;border-radius:12px;background:rgba(99,102,241,.1);color:#818cf8;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;transition:transform .2s
    }
    .search-item-icon.product-icon{background:rgba(16,185,129,.1);color:#34d399}
    .search-item-icon.tenant-icon{background:rgba(245,158,11,.1);color:#fbbf24}

    .search-item-info{flex:1;min-width:0}
    .search-item-name{color:#f1f5f9;font-size:13.5px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .search-item-meta{color:#64748b;font-size:11px;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

    .search-item-badge{
        font-size:10px;font-weight:600;padding:3px 8px;border-radius:6px;flex-shrink:0
    }
    .search-item-badge.badge-page{background:rgba(99,102,241,.1);color:#818cf8}
    .search-item-badge.badge-product{background:rgba(16,185,129,.1);color:#34d399}
    .search-item-badge.badge-tenant{background:rgba(245,158,11,.1);color:#fbbf24}

    .search-empty{
        text-align:center;padding:40px 20px;color:#64748b
    }
    .search-empty i{font-size:36px;color:#334155;margin-bottom:10px;display:block}
    .search-empty p{font-size:13px;margin:0}

    .search-footer{
        display:flex;align-items:center;justify-content:space-between;padding:10px 18px;border-top:1px solid rgba(255,255,255,.06);background:rgba(0,0,0,.15)
    }
    .search-hint{display:flex;gap:10px;align-items:center}
    .search-hint span{font-size:10px;color:#475569;display:flex;align-items:center;gap:4px}
    .search-hint kbd{
        background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);padding:1px 5px;border-radius:4px;font-size:9px;color:#94a3b8;font-family:inherit
    }
    .search-result-count{font-size:10px;color:#475569}

    .search-loading{
        display:flex;align-items:center;justify-content:center;padding:30px;gap:8px
    }
    .search-loading .dot{
        width:6px;height:6px;border-radius:50%;background:#818cf8;animation:searchDotBounce .6s ease-in-out infinite alternate
    }
    .search-loading .dot:nth-child(2){animation-delay:.15s}
    .search-loading .dot:nth-child(3){animation-delay:.3s}
    @keyframes searchDotBounce{from{opacity:.3;transform:scale(.7)}to{opacity:1;transform:scale(1)}}

    .search-recent{padding:6px 12px}
    .search-recent-item{
        display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:10px;cursor:pointer;transition:.2s
    }
    .search-recent-item:hover{background:rgba(255,255,255,.04)}
    .search-recent-item i{color:#475569;font-size:12px}
    .search-recent-item span{color:#94a3b8;font-size:12.5px;flex:1}
    .search-recent-item .clear-recent{color:#475569;font-size:10px;cursor:pointer;padding:2px 6px;border-radius:6px;transition:.2s}
    .search-recent-item .clear-recent:hover{background:rgba(239,68,68,.15);color:#f87171}

    @media(max-width:768px){
        .search-overlay{padding:12px}
        .search-container{border-radius:20px;max-height:85vh}
        .search-body{max-height:calc(85vh - 140px)}
        .search-input{font-size:15px}
        .search-footer{flex-wrap:wrap;gap:6px}
    }
    @media(max-width:576px){
        .search-trigger{display:none !important}
        .search-overlay{padding:0;align-items:flex-start}
        .search-container{border-radius:0;max-height:100vh;height:100vh;max-width:100%;display:flex;flex-direction:column}
        .search-body{flex:1;max-height:none}
        .search-input-wrap{padding:14px 16px}
    }
</style>

<nav class="premium-navbar">

    <div class="premium-brand">
        <div class="brand-content">
            <h4>Dashboard</h4>
            <span>Point Of Sales Management</span>
        </div>
    </div>

    <div class="premium-actions">
        <!-- SEARCH -->
        <div class="search-trigger" id="searchTrigger" onclick="openSearch()">
            <i class="fas fa-search"></i>
            <span class="kbd-hint">⌘K</span>
        </div>

        <!-- WHAT'S NEW -->
        <div
            class="premium-action-btn"
            id="whatsNewBtn">

            <i class="fas fa-bullhorn"></i>

            <span class="cart-badge" style="font-size:8px;">
                NEW
            </span>

        </div>
        
        <?php if ($user['role'] == 'developer' || $user['role'] == 'staff kasir') { ?>
        
        <!-- CART -->
        <div
            class="premium-action-btn"
            onclick="openCart()">

            <i class="fas fa-shopping-cart"></i>

            <span id="cart-count"
                class="cart-badge d-none">
                0
            </span>
        </div>

        <!-- OMZET -->
        <?php
        $today = date('Y-m-d');

        $omzetQuery = $conn->prepare("
            SELECT SUM(total) as omzet
            FROM orders
            WHERE DATE(tanggal)=?
            AND status_payment!='cancelled'
        ");

        $omzetQuery->bind_param("s", $today);
        $omzetQuery->execute();

        $omzetResult = $omzetQuery->get_result();

        $omzet = 0;

        if ($omzetResult && $omzetResult->num_rows > 0) {
            $omzet = $omzetResult->fetch_assoc()['omzet'];

            if ($omzet === null) {
                $omzet = 0;
            }
        }
        ?>


        <div class="premium-omzet">

            <div class="premium-omzet-icon">
                <i class="fas fa-coins"></i>
            </div>

            <div>

                <span class="omzet-label">
                    Omzet Hari Ini
                </span>

                <div class="omzet-value">
                    Rp <span id="omzet-today">0</span>
                </div>

            </div>

        </div>

<?php } ?>

<!-- Global Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-container">
        <div class="search-input-wrap">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari halaman, produk, tenant..." autocomplete="off" spellcheck="false">
            <button class="search-close-btn" onclick="closeSearch()">ESC</button>
        </div>
        <div class="search-body" id="searchBody">
            <div class="search-recent" id="searchRecent"></div>
            <div id="searchResults"></div>
        </div>
        <div class="search-footer">
            <div class="search-hint">
                <span><kbd>&uarr;</kbd><kbd>&darr;</kbd> Navigasi</span>
                <span><kbd>&crarr;</kbd> Buka</span>
                <span><kbd>ESC</kbd> Tutup</span>
            </div>
            <div class="search-result-count" id="searchCount"></div>
        </div>
    </div>
</div>

<script>
(function(){
    var overlay = document.getElementById('searchOverlay');
    var input = document.getElementById('searchInput');
    var results = document.getElementById('searchResults');
    var recentEl = document.getElementById('searchRecent');
    var countEl = document.getElementById('searchCount');
    var focusIndex = -1;
    var allItems = [];
    var debounceTimer = null;
    var isSearchOpen = false;
    var recentSearches = JSON.parse(localStorage.getItem('qieos_recent_search') || '[]');

    function renderRecent(){
        if(!recentSearches.length){ recentEl.innerHTML = ''; return; }
        var html = '<div class="search-section-label"><i class="fas fa-clock-rotate-left"></i> Pencarian Terakhir</div>';
        recentSearches.slice(0,5).forEach(function(s,i){
            html += '<div class="search-recent-item" onclick="window._searchSelect(\''+s.replace(/'/g,"\\'")+'\')"><i class="fas fa-clock"></i><span>'+escapeHtml(s)+'</span><span class="clear-recent" onclick="event.stopPropagation();window._removeRecent('+i+')"><i class="fas fa-times"></i></span></div>';
        });
        recentEl.innerHTML = html;
    }

    function addRecent(q){
        recentSearches = recentSearches.filter(function(s){ return s.toLowerCase() !== q.toLowerCase(); });
        recentSearches.unshift(q);
        if(recentSearches.length > 8) recentSearches.pop();
        localStorage.setItem('qieos_recent_search', JSON.stringify(recentSearches));
    }

    window._removeRecent = function(i){
        recentSearches.splice(i,1);
        localStorage.setItem('qieos_recent_search', JSON.stringify(recentSearches));
        renderRecent();
    };

    window._searchSelect = function(q){
        input.value = q;
        doSearch(q);
        input.focus();
    };

    function escapeHtml(t){
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(t));
        return d.innerHTML;
    }

    function doSearch(q){
        if(!q || q.length < 1){
            results.innerHTML = '';
            countEl.textContent = '';
            focusIndex = -1;
            allItems = [];
            renderRecent();
            return;
        }

        results.innerHTML = '<div class="search-loading"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>';
        recentEl.innerHTML = '';
        countEl.textContent = '';

        var role = '<?php echo $user["role"]; ?>';
        fetch('/qieos/pages/components/data/search-api.php?q='+encodeURIComponent(q)+'&role='+encodeURIComponent(role))
        .then(function(r){ return r.json(); })
        .then(function(data){
            if(data.status !== 'success') return;
            var r = data.results;
            var html = '';
            var total = 0;
            allItems = [];
            focusIndex = -1;

            if(r.pages && r.pages.length){
                html += '<div class="search-section-label"><i class="fas fa-compass"></i> Halaman</div>';
                r.pages.forEach(function(p){
                    var idx = allItems.length;
                    allItems.push(p.url);
                    html += '<div class="search-item" data-idx="'+idx+'" onclick="window._goSearchItem('+idx+')">';
                    html += '<div class="search-item-icon"><i class="'+p.icon+'"></i></div>';
                    html += '<div class="search-item-info"><div class="search-item-name">'+escapeHtml(p.name)+'</div><div class="search-item-meta">'+escapeHtml(p.category)+'</div></div>';
                    html += '<span class="search-item-badge badge-page">Halaman</span>';
                    html += '</div>';
                    total++;
                });
            }

            if(r.products && r.products.length){
                html += '<div class="search-section-label"><i class="fas fa-cube"></i> Produk</div>';
                r.products.forEach(function(p){
                    var idx = allItems.length;
                    allItems.push(p.url);
                    html += '<div class="search-item" data-idx="'+idx+'" onclick="window._goSearchItem('+idx+')">';
                    html += '<div class="search-item-icon product-icon"><i class="'+p.icon+'"></i></div>';
                    html += '<div class="search-item-info"><div class="search-item-name">'+escapeHtml(p.name)+'</div><div class="search-item-meta">'+escapeHtml(p.code)+' &middot; '+escapeHtml(p.category)+' &middot; '+p.price+'</div></div>';
                    html += '<span class="search-item-badge badge-product">Produk</span>';
                    html += '</div>';
                    total++;
                });
            }

            if(r.orders && r.orders.length){
                html += '<div class="search-section-label"><i class="fas fa-receipt"></i> Pesanan</div>';
                r.orders.forEach(function(o){
                    var idx = allItems.length;
                    allItems.push(o.url);
                    html += '<div class="search-item" data-idx="'+idx+'" onclick="window._goSearchItem('+idx+')">';
                    html += '<div class="search-item-icon" style="background:rgba(239,68,68,.1);color:#f87171"><i class="'+o.icon+'"></i></div>';
                    html += '<div class="search-item-info"><div class="search-item-name">'+escapeHtml(o.code)+'</div><div class="search-item-meta">'+o.date+' &middot; '+o.total+' &middot; '+escapeHtml(o.status)+'</div></div>';
                    html += '<span class="search-item-badge" style="background:rgba(239,68,68,.1);color:#f87171">Pesanan</span>';
                    html += '</div>';
                    total++;
                });
            }

            if(r.tenants && r.tenants.length){
                html += '<div class="search-section-label"><i class="fas fa-store"></i> Tenant</div>';
                r.tenants.forEach(function(t){
                    var idx = allItems.length;
                    allItems.push(t.url);
                    html += '<div class="search-item" data-idx="'+idx+'" onclick="window._goSearchItem('+idx+')">';
                    html += '<div class="search-item-icon tenant-icon"><i class="'+t.icon+'"></i></div>';
                    html += '<div class="search-item-info"><div class="search-item-name">'+escapeHtml(t.name)+'</div><div class="search-item-meta">'+escapeHtml(t.owner)+'</div></div>';
                    html += '<span class="search-item-badge badge-tenant">Tenant</span>';
                    html += '</div>';
                    total++;
                });
            }

            if(total === 0){
                html = '<div class="search-empty"><i class="fas fa-search"></i><p>Tidak ditemukan hasil untuk "<strong>'+escapeHtml(q)+'</strong>"</p></div>';
            }

            results.innerHTML = html;
            countEl.textContent = total + ' hasil ditemukan';
        })
        .catch(function(){
            results.innerHTML = '<div class="search-empty"><i class="fas fa-exclamation-triangle"></i><p>Gagal memuat pencarian</p></div>';
        });
    }

    window._goSearchItem = function(idx){
        if(allItems[idx]) window.location.href = allItems[idx];
    };

    window.openSearch = function(){
        overlay.classList.add('active');
        isSearchOpen = true;
        input.value = '';
        results.innerHTML = '';
        countEl.textContent = '';
        allItems = [];
        focusIndex = -1;
        renderRecent();
        history.pushState({search:true}, '');
        setTimeout(function(){ input.focus(); },100);
    };

    window.closeSearch = function(){
        overlay.classList.remove('active');
        isSearchOpen = false;
        input.value = '';
        results.innerHTML = '';
        countEl.textContent = '';
        allItems = [];
        focusIndex = -1;
    };

    overlay.addEventListener('click', function(e){
        if(e.target === overlay){
            closeSearch();
            history.back();
        }
    });

    input.addEventListener('input', function(){
        clearTimeout(debounceTimer);
        var v = this.value.trim();
        debounceTimer = setTimeout(function(){ doSearch(v); }, 180);
    });

    input.addEventListener('keydown', function(e){
        var items = results.querySelectorAll('.search-item');
        if(!items.length) return;

        if(e.key === 'ArrowDown'){
            e.preventDefault();
            focusIndex = Math.min(focusIndex + 1, items.length - 1);
            updateFocus(items);
        } else if(e.key === 'ArrowUp'){
            e.preventDefault();
            focusIndex = Math.max(focusIndex - 1, 0);
            updateFocus(items);
        } else if(e.key === 'Enter'){
            e.preventDefault();
            if(focusIndex >= 0 && allItems[focusIndex]){
                var q = input.value.trim();
                if(q) addRecent(q);
                window.location.href = allItems[focusIndex];
            }
        }
    });

    function updateFocus(items){
        items.forEach(function(it){ it.classList.remove('focused'); });
        if(focusIndex >= 0 && items[focusIndex]){
            items[focusIndex].classList.add('focused');
            items[focusIndex].scrollIntoView({block:'nearest'});
        }
    }

    document.addEventListener('keydown', function(e){
        if((e.ctrlKey || e.metaKey) && e.key === 'k'){
            e.preventDefault();
            if(overlay.classList.contains('active')) closeSearch();
            else openSearch();
        }
        if(e.key === 'Escape' && overlay.classList.contains('active')){
            closeSearch();
            history.back();
        }
    });

    window.addEventListener('popstate', function(e){
        if(isSearchOpen){
            overlay.classList.remove('active');
            isSearchOpen = false;
            input.value = '';
            results.innerHTML = '';
            countEl.textContent = '';
            allItems = [];
            focusIndex = -1;
        }
    });

    renderRecent();
})();
</script>

        <!-- PROFILE -->
        <div class="dropdown">

            <a href="#"
                class="text-decoration-none"
                data-bs-toggle="dropdown">

                <div class="premium-profile">

                    <img
                        src="<?php echo $user['photo'] ? '/qieos/assets/img/uploads/' . $user['photo'] : '/qieos/assets/img/default-avatar.jpg'; ?>"
                        class="premium-avatar">

                    <div class="premium-user">

                        <div class="premium-name">
                            <?php echo $user['fullname'] != '' ? $user['fullname'] : $_SESSION['username']; ?>
                        </div>

                        <div class="premium-role">
                            <?= ucwords(strtolower($user['role'])) ?>
                        </div>

                    </div>

                    <i class="fas fa-chevron-down text-white premium-chevron"></i>

                </div>

            </a>

            <div class="dropdown-menu dropdown-menu-end premium-dropdown">

                <a class="dropdown-item"
                href="/qieos/pages/profile/profile.php">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger"
                href="/qieos/sessions/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </a>

            </div>

        </div>

    </div>

</nav>

<!-- Modal Cart -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(45deg,#6366f1,#8b5cf6); color:white;">
                <h5 class="mb-0 text-white"><i class="fas fa-shopping-cart"></i>&nbsp; Keranjang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="cart-items" class="cart-container"></div>
            </div>

            <div class="modal-footer cart-footer">
                <!-- TOTAL -->
                <div class="cart-total-box">
                    <div class="total-label">
                        <i class="fas fa-receipt me-1"></i> Total keseluruhan:
                    </div>

                    <div class="total-value">
                        <i class="fas fa-money-bill-wave"></i>&nbsp;
                        Rp <span id="cart-total">0</span>
                    </div>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-checkout" onclick="checkout()">
                    Pesan <i class="fas fa-shopping-bag ms-1"></i>
                </button>

            </div>
        </div>
    </div>
</div>

<!-- Update Overlay -->
<div class="update-overlay" id="updateOverlay">
    <div class="update-modal">
        <div class="update-header">
            <div>
                <div class="update-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h4 id="updateTitle"></h4>
                <div class="update-meta">
                    <span id="updateVersion"></span>
                    <span id="updateType" style="color: #000;"></span>
                    <span id="updateDate"></span>
                </div>
            </div>
            <button class="closeUpdate">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="update-body">
            <h6 class="mb-3">
                <i class="fas fa-sparkles me-2"></i>
                What's New
            </h6>
            <div id="updateDetailList" class="mb-5"></div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".closeUpdate", function () {
        $("#updateOverlay").fadeOut(150);
    });

    $(document).on("click", "#updateOverlay", function (e) {
        if (e.target === this) {
            $(this).fadeOut(150);
        }
    });

    // Show Latest Update Details
    function showLatestUpdate() {
        $.get("/qieos/pages/other/update-detail.php", function(res) {
            if (res.status != "success") {
                Swal.fire("Error", "Tidak dapat memuat update terbaru", "error");
                return;
            }

            $("#updateTitle").text(res.update_name);
            $("#updateVersion").html(`<span class="stock-badge">${res.update_version}</span>`);
            $("#updateType").html(res.badge);
            $("#updateDate").text(res.update_date);

            let html = "";
            res.details.forEach(function(item) {
                html += `
                    <div class="update-item">
                        <i class="fas fa-check-circle"></i>
                        <div>${item.description}</div>
                    </div>
                `;
            });

            $("#updateDetailList").html(html);
            $("#updateOverlay").css("display","flex").hide().fadeIn(200);
        }, "json");
    }

    // Attach event to Whats New button
    document.getElementById("whatsNewBtn").addEventListener("click", showLatestUpdate);
    var mobileWnb = document.getElementById("whatsNewBtnMobile");
    if(mobileWnb) mobileWnb.addEventListener("click", showLatestUpdate);
</script>

<?php if ($user['role'] == 'developer' || $user['role'] == 'staff kasir') { ?>
<script>
    // Load cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let cartModalInstance = null;

    function openCart() {
        if (!cartModalInstance) {
            cartModalInstance = new bootstrap.Modal(document.getElementById('cartModal'));
        }
        cartModalInstance.show();
    }

    function addToCart(btn, id, name, price, category){

        let qty = 1;
        let input = null;

        if (category !== 'additional') {
            input = document.getElementById('qty-' + id);
            qty = parseInt(input.value || 0);

            if(qty <= 0){
                Swal.fire('Tambahkan qty produk terlebih dahulu!', '', 'warning');
                return;
            }
        }

        let img = btn.closest('.product-item')
                    .querySelector('.product-img').src;

        let existing = cart.find(item => item.id == id);

        if(existing){
            if (category !== 'additional') {
                existing.qty += qty;
            } else {
                Swal.fire(name + ' sudah ditambahkan!', '', 'warning');
                return;
            }
        } else {
            cart.push({
                id,
                name,
                price,
                qty,
                photo: img,
                category
            });
        }

        updateCart();

        if (input) {
            input.value = 0;
        }

        Swal.fire({
            icon:'success',
            title:'Ditambahkan',
            text:name+' masuk keranjang',
            timer:1000,
            showConfirmButton:false
        });
    }

    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));

        let count = cart.length;
        let total = 0;
        let html = '';

        const cartBadge = document.getElementById('cart-count');

        // 👉 JIKA KOSONG
        if (cart.length === 0) {
            html = `
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>

                <h5>Keranjang kosong</h5>
                <p>Yuk tambahkan produk ke keranjang kamu</p>
                <a href="../sales/catalog.php" class="btn btn-primary mt-2">
                    Mulai Belanja
                </a>
            </div>
            `;

            document.getElementById('cart-items').innerHTML = html;

            // 🔴 badge disembunyikan
            cartBadge.innerText = 0;
            cartBadge.classList.add('d-none');

            // ❌ sembunyikan footer
            document.querySelector('.cart-footer').style.display = 'none';

            return;
        }

        // ✅ tampilkan footer
        document.querySelector('.cart-footer').style.display = 'flex';

        cart.forEach((item, index) => {
            let subtotal = item.qty * item.price;

            total += subtotal;

            html += `
                <div class="cart-card">

                    <!-- LEFT -->
                    <div class="cart-left">
                        <img src="${item.photo}" class="cart-img">

                        <div>
                            <div class="cart-title text-capitalize">${item.name}</div>

                            <div class="cart-meta">
                                <span class="badge-price">
                                    Rp ${Number(item.price).toLocaleString('id-ID', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    })}
                                </span>

                                ${
                                    item.category !== 'additional'
                                    ? `
                                        <span class="badge-qty">
                                            Qty: ${item.qty}
                                        </span>
                                    `
                                    : ''
                                }
                            </div>
                        </div>
                    </div>

                    <!-- CENTER -->
                    <div class="cart-qty">
                        ${
                            item.category !== 'additional'
                            ? `
                                <button onclick="changeQty(${index}, -1)">-</button>
                                <span>${item.qty}</span>
                                <button onclick="changeQty(${index}, 1)">+</button>
                            `
                            : ''
                        }
                    </div>

                    <!-- RIGHT -->
                    <div class="cart-right">
                        <div class="cart-subtotal">
                            Rp ${subtotal.toLocaleString()}
                        </div>

                        <div class="remove-btn" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>

                </div>
            `;
        });

        // 🔥 UPDATE BADGE (TOTAL QTY)
        cartBadge.innerText = count > 99 ? '99+' : count;

        // tampilkan badge kalau ada isi
        if (count > 0) {
            cartBadge.classList.remove('d-none');
        } else {
            cartBadge.classList.add('d-none');
        }

        // render cart
        document.getElementById('cart-items').innerHTML = html;
        document.getElementById('cart-total').innerText = total.toLocaleString();
    }

    function changeQty(index, change) {
        cart[index].qty += change;

        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }

        updateCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    // Load cart on page load
    window.onload = function() {
        updateCart();
    };

    // Checkout
    function checkout() {
        if (cart.length === 0) {
            return Swal.fire('Keranjang kosong', '', 'warning');
        }

        fetch('../checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cart: cart })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {

                    Swal.fire('Berhasil!', 'Pesanan berhasil dibuat', 'success');

                    const receiptUrl = `../receipt.php?id=${res.order_id}`;
                    window.open(receiptUrl, '_blank');

                    if (navigator.share) {
                        navigator.share({
                            title: 'Struk Pembelian',
                            text: 'Berikut struk pembelian',
                            url: receiptUrl
                        });
                    }

                    // reset cart
                    cart = [];
                    localStorage.removeItem('cart');
                    updateCart();

                    let modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
                    modal.hide();
                }
            })
    }

    // Update Omzet
    function updateOmzet() {
        fetch('/qieos/pages/components/data/get-omzet.php')
            .then(res => res.json())
            .then(data => {
                const el = document.getElementById('omzet-today');

                el.style.transform = "scale(1.2)";
                el.style.transition = "0.2s";

                setTimeout(() => {
                    el.innerText = data.omzet.toLocaleString('id-ID');
                    el.style.transform = "scale(1)";
                }, 150);
            });
    }

    // jalan tiap 1 detik
    setInterval(updateOmzet, 3000);

    // pertama kali load
    updateOmzet();
</script>

<script>
    function animateValue(id, end, duration = 800) {
        const obj = document.getElementById(id);
        let startTimestamp = null;

        function step(timestamp) {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);

            const value = Math.floor(progress * end);
            obj.innerHTML = value.toLocaleString('id-ID');

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                obj.innerHTML = end.toLocaleString('id-ID');

                // trigger pulse
                obj.classList.add("pulse");
                setTimeout(() => obj.classList.remove("pulse"), 600);
            }
        }

        window.requestAnimationFrame(step);
    }

    // dari PHP
    let omzet = <?php echo $omzet; ?>;
    animateValue("omzet-today", omzet, 800); // cepat & smooth
</script>

<?php } ?>