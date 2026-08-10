<?php include '../sessions/session.php'; ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Dashboard - Qieos</title>
    <?php include '../script/headscript.php'; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}
        body{font-family:'Inter',system-ui,-apple-system,sans-serif}

        @keyframes hdrGlow{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
        @keyframes hdrPulse{0%,100%{box-shadow:0 20px 60px rgba(99,102,241,.15),0 0 120px rgba(99,102,241,.08)}50%{box-shadow:0 24px 80px rgba(99,102,241,.3),0 0 160px rgba(99,102,241,.15)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes spin{to{transform:rotate(360deg)}}
        @keyframes fadeSlideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes barSlide{from{width:0}to{width:var(--bw)}}
        @keyframes glowPulse{0%,100%{opacity:.08}50%{opacity:.18}}
        @keyframes iconBounce{0%{transform:scale(1)}50%{transform:scale(1.12) rotate(-5deg)}100%{transform:scale(1)}}
        @keyframes borderGlow{0%,100%{border-color:rgba(255,255,255,.08)}50%{border-color:rgba(255,255,255,.18)}}
        @keyframes dotPulse{0%,100%{opacity:.4;transform:scale(1)}50%{opacity:1;transform:scale(1.3)}}
        @keyframes valReveal{from{opacity:0;transform:translateY(10px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}

        /* ===== HEADER ===== */
        .dash-hdr{
            position:relative;border-radius:28px;padding:38px 44px;margin-bottom:26px;overflow:hidden;color:#fff;
            background:linear-gradient(135deg,#1e1b4b,#312e81,#4338ca,#6366f1,#4338ca,#312e81,#1e1b4b);
            background-size:400% 400%;animation:hdrGlow 10s ease infinite,hdrPulse 4s ease infinite;
            transition:all .4s;
        }
        .dash-hdr::before{content:'';position:absolute;width:350px;height:350px;border-radius:50%;background:radial-gradient(circle,rgba(129,140,248,.2),transparent 65%);top:-160px;right:-100px;pointer-events:none;animation:float 5s ease-in-out infinite}
        .dash-hdr::after{content:'';position:absolute;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(192,132,252,.18),transparent 65%);bottom:-110px;left:8%;pointer-events:none;animation:float 6s ease-in-out infinite 1s}
        .dash-hdr .hdr-row{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1}
        .dash-hdr h1{font-size:1.85rem;font-weight:900;margin:0 0 8px;letter-spacing:-.04em;background:linear-gradient(90deg,#fff,#c7d2fe);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .dash-hdr .hdr-sub{font-size:.95rem;opacity:.7;margin:0;font-weight:500}
        .dash-hdr .hdr-dots{display:flex;gap:6px;margin-top:12px}
        .dash-hdr .hdr-dots span{width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.5);animation:dotPulse 2s ease infinite}
        .dash-hdr .hdr-dots span:nth-child(2){animation-delay:.3s}
        .dash-hdr .hdr-dots span:nth-child(3){animation-delay:.6s}
        .dash-hdr .hdr-icon{width:88px;height:88px;border-radius:26px;background:linear-gradient(135deg,rgba(255,255,255,.12),rgba(255,255,255,.04));backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:36px;flex-shrink:0;animation:float 4s ease-in-out infinite;transition:transform .3s,box-shadow .3s}
        .dash-hdr .hdr-icon:hover{transform:scale(1.1) rotate(-8deg);box-shadow:0 0 40px rgba(255,255,255,.15)}

        /* ===== FILTER ===== */
        .flt{display:flex;align-items:center;gap:14px;flex-wrap:wrap;background:var(--q-bg-card);border:1.5px solid var(--q-border);border-radius:22px;padding:18px 26px;margin-bottom:26px;box-shadow:0 4px 24px rgba(0,0,0,.05);transition:all .35s}
        .flt:hover{box-shadow:0 8px 40px rgba(0,0,0,.1);border-color:var(--q-border-hover)}
        .flt-icon{width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,rgba(99,102,241,.15),rgba(139,92,246,.1));color:var(--q-accent);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;transition:transform .3s}
        .flt:hover .flt-icon{transform:rotate(-5deg) scale(1.05)}
        .flt .fg{display:flex;align-items:center;gap:8px}
        .flt .fl{font-size:.72rem;font-weight:700;color:var(--q-text-muted);text-transform:uppercase;letter-spacing:.05em}
        .flt .fi{background:var(--q-bg-input);border:1.5px solid var(--q-border);color:var(--q-text);padding:10px 16px;border-radius:12px;font-size:.85rem;transition:all .3s;font-family:inherit;min-width:145px}
        .flt .fi:focus{border-color:var(--q-accent);outline:none;box-shadow:0 0 0 4px rgba(99,102,241,.12)}
        .flt .fs{color:var(--q-text-muted);font-size:.95rem;font-weight:300}
        .fb{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;padding:11px 30px;border-radius:14px;font-weight:700;font-size:.85rem;cursor:pointer;transition:all .3s;display:flex;align-items:center;gap:8px;box-shadow:0 4px 18px rgba(99,102,241,.3);font-family:inherit}
        .fb:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(99,102,241,.45)}
        .fb:active{transform:translateY(1px);box-shadow:0 2px 8px rgba(99,102,241,.3)}
        .fb i{font-size:13px}
        .fb-rst{background:var(--q-bg-raised);border:1.5px solid var(--q-border);color:var(--q-text-secondary);padding:11px 20px;border-radius:14px;font-weight:600;font-size:.85rem;cursor:pointer;transition:all .3s;font-family:inherit}
        .fb-rst:hover{border-color:var(--q-border-hover);color:var(--q-text);transform:translateY(-1px)}
        .fb-load{display:none;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
        .flt-tag{font-size:.72rem;color:var(--q-accent);font-weight:700;background:linear-gradient(135deg,rgba(99,102,241,.12),rgba(139,92,246,.08));padding:5px 16px;border-radius:20px;white-space:nowrap;border:1px solid rgba(99,102,241,.15)}

        /* ===== STAT CARDS 4 ===== */
        .st4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px}
        .sc{border-radius:24px;padding:28px 30px;position:relative;overflow:hidden;transition:all .4s cubic-bezier(.4,0,.2,1);border:1.5px solid transparent}
        .sc:hover{transform:translateY(-6px) scale(1.01)}

        .sc.sc-dk{background:linear-gradient(135deg,rgba(99,102,241,.12) 0%,rgba(99,102,241,.04) 50%,var(--q-bg-card) 100%);border-color:rgba(99,102,241,.2);box-shadow:0 8px 32px rgba(99,102,241,.1)}
        .sc.sc-dk:hover{box-shadow:0 20px 60px rgba(99,102,241,.22),0 0 0 1px rgba(99,102,241,.3);border-color:rgba(99,102,241,.35)}

        .sc.sc-rd{background:linear-gradient(135deg,rgba(244,63,94,.1) 0%,rgba(244,63,94,.03) 50%,var(--q-bg-card) 100%);border-color:rgba(244,63,94,.15);box-shadow:0 8px 32px rgba(244,63,94,.08)}
        .sc.sc-rd:hover{box-shadow:0 20px 60px rgba(244,63,94,.18),0 0 0 1px rgba(244,63,94,.25);border-color:rgba(244,63,94,.3)}

        .sc.sc-em{background:linear-gradient(135deg,rgba(16,185,129,.1) 0%,rgba(16,185,129,.03) 50%,var(--q-bg-card) 100%);border-color:rgba(16,185,129,.15);box-shadow:0 8px 32px rgba(16,185,129,.08)}
        .sc.sc-em:hover{box-shadow:0 20px 60px rgba(16,185,129,.18),0 0 0 1px rgba(16,185,129,.25);border-color:rgba(16,185,129,.3)}

        .sc.sc-am{background:linear-gradient(135deg,rgba(245,158,11,.1) 0%,rgba(245,158,11,.03) 50%,var(--q-bg-card) 100%);border-color:rgba(245,158,11,.15);box-shadow:0 8px 32px rgba(245,158,11,.08)}
        .sc.sc-am:hover{box-shadow:0 20px 60px rgba(245,158,11,.18),0 0 0 1px rgba(245,158,11,.25);border-color:rgba(245,158,11,.3)}

        .sc .sc-glow{position:absolute;width:150px;height:150px;border-radius:50%;filter:blur(65px);opacity:.1;transition:all .5s;pointer-events:none;animation:glowPulse 3s ease infinite}
        .sc:hover .sc-glow{opacity:.25;width:180px;height:180px}

        .sc .sc-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px}
        .sc .sc-ic{width:56px;height:56px;border-radius:18px;display:flex;align-items:center;justify-content:center;transition:all .35s;position:relative}
        .sc:hover .sc-ic{animation:iconBounce .5s ease}
        .sc .sc-ic i{font-size:24px;position:relative;z-index:1}
        .sc .sc-ic::after{content:'';position:absolute;inset:-4px;border-radius:22px;opacity:0;transition:opacity .35s}
        .sc:hover .sc-ic::after{opacity:.15}

        .sc .sc-lbl{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em}
        .sc.sc-dk .sc-lbl{color:#818cf8 !important}.sc.sc-rd .sc-lbl{color:#fb7185 !important}.sc.sc-em .sc-lbl{color:#34d399 !important}.sc.sc-am .sc-lbl{color:#fbbf24 !important}
        .sc .sc-val{font-size:1.7rem;font-weight:900;letter-spacing:-.04em;line-height:1.15;margin-top:5px;animation:valReveal .7s ease both}
        .sc.sc-dk .sc-val{color:#a5b4fc !important}.sc.sc-rd .sc-val{color:#fda4af !important}.sc.sc-em .sc-val{color:#6ee7b7 !important}.sc.sc-am .sc-val{color:#fcd34d !important}
        .sc .sc-sub{font-size:.7rem;margin-top:10px;display:flex;align-items:center;gap:5px}
        .sc .sc-sub i{font-size:9px;opacity:.7}

        .sc .sc-bar{height:5px;background:rgba(255,255,255,.05);border-radius:5px;margin-top:18px;overflow:hidden}
        .sc.sc-dk .sc-bar{background:rgba(99,102,241,.1)}
        .sc.sc-rd .sc-bar{background:rgba(244,63,94,.1)}
        .sc.sc-em .sc-bar{background:rgba(16,185,129,.1)}
        .sc.sc-am .sc-bar{background:rgba(245,158,11,.1)}
        .sc .sc-bar-fill{height:100%;border-radius:5px;width:0;transition:width 1.6s cubic-bezier(.22,1,.36,1) .4s}
        .sc-dk .sc-bar-fill{background:linear-gradient(90deg,#6366f1,#a5b4fc)}
        .sc-rd .sc-bar-fill{background:linear-gradient(90deg,#f43f5e,#fda4af)}
        .sc-em .sc-bar-fill{background:linear-gradient(90deg,#10b981,#6ee7b7)}
        .sc-am .sc-bar-fill{background:linear-gradient(90deg,#f59e0b,#fcd34d)}

        .sc .sc-deco{position:absolute;bottom:-25px;right:-12px;font-size:90px;opacity:.025;pointer-events:none;transform:rotate(-15deg);transition:all .4s}
        .sc:hover .sc-deco{opacity:.06;transform:rotate(-10deg) scale(1.1)}

        /* ===== SECONDARY STATS 3 ===== */
        .st3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:26px}
        .scs{background:var(--q-bg-card);border:1.5px solid var(--q-border);border-radius:22px;padding:24px 26px;transition:all .4s;box-shadow:0 4px 18px rgba(0,0,0,.05);position:relative;overflow:hidden}
        .scs:hover{transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.12);border-color:var(--q-border-hover)}
        .scs .scs-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
        .scs .scs-ic{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:19px;transition:all .35s}
        .scs:hover .scs-ic{animation:iconBounce .5s ease}
        .scs .scs-lbl{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--q-text-muted)}
        .scs .scs-val{font-size:1.3rem;font-weight:800;color:var(--q-text);letter-spacing:-.03em;animation:valReveal .6s ease both}
        .scs .scs-bar{height:4px;background:var(--q-bg-raised);border-radius:4px;margin-top:14px;overflow:hidden}
        .scs .scs-bar-fill{height:100%;border-radius:4px;width:0;transition:width 1.4s cubic-bezier(.22,1,.36,1) .5s}

        .ic-violet{background:rgba(139,92,246,.12);color:#a78bfa}
        .ic-cyan{background:rgba(6,182,212,.12);color:#22d3ee}
        .ic-indigo{background:rgba(99,102,241,.12);color:#818cf8}
        .bar-violet{background:linear-gradient(90deg,#8b5cf6,#c4b5fd)}
        .bar-cyan{background:linear-gradient(90deg,#06b6d4,#67e8f9)}
        .bar-indigo{background:linear-gradient(90deg,#6366f1,#a5b4fc)}

        /* ===== CHART / CONTENT CARDS ===== */
        .g21{display:grid;grid-template-columns:5fr 3fr;gap:18px;margin-bottom:24px}
        .g11{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:24px}
        .dc{background:var(--q-bg-card);border:1.5px solid var(--q-border);border-radius:24px;padding:26px;transition:all .4s;box-shadow:0 4px 18px rgba(0,0,0,.05)}
        .dc:hover{box-shadow:0 14px 48px rgba(0,0,0,.12);border-color:var(--q-border-hover)}
        .dc-h{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
        .dc-t{font-size:1.05rem;font-weight:700;color:var(--q-text)}
        .dc-s{font-size:.72rem;color:var(--q-text-muted);margin-top:3px}
        .dc-i{width:42px;height:42px;border-radius:13px;display:flex;align-items:center;justify-content:center;background:var(--q-bg-raised);border:1.5px solid var(--q-border);font-size:17px;color:var(--q-text-secondary);transition:all .35s}
        .dc:hover .dc-i{background:var(--q-accent-glow);color:var(--q-accent);border-color:var(--q-accent);transform:rotate(-5deg) scale(1.05)}

        /* ===== ROW ITEMS ===== */
        .ri{display:flex;align-items:center;padding:12px 14px;border-radius:14px;margin-bottom:3px;gap:12px;transition:all .25s}
        .ri:hover{background:var(--q-bg-raised);transform:translateX(4px)}
        .ri:last-child{margin-bottom:0}
        .ri-c{font-weight:700;font-size:.82rem;color:var(--q-text);min-width:118px;font-family:'Inter',monospace}
        .ri-n{flex:1;font-size:.84rem;color:var(--q-text-secondary)}
        .ri-a{font-weight:700;font-size:.84rem;color:#fbbf24;min-width:95px;text-align:right}
        .ri-b{font-size:.66rem;font-weight:700;padding:4px 14px;border-radius:20px;min-width:66px;text-align:center;letter-spacing:.03em;transition:all .2s}
        .ri-b:hover{transform:scale(1.05)}
        .b-p{background:rgba(16,185,129,.12);color:#34d399}
        .b-w{background:rgba(245,158,11,.12);color:#fbbf24}
        .b-c{background:rgba(244,63,94,.12);color:#fb7185}
        .rk{width:32px;height:32px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;background:linear-gradient(135deg,rgba(99,102,241,.15),rgba(139,92,246,.1));color:#818cf8;flex-shrink:0;transition:all .25s}
        .ri:hover .rk{transform:scale(1.1) rotate(-5deg)}
        .ct{font-size:.65rem;color:var(--q-text-muted);background:var(--q-bg-raised);padding:3px 12px;border-radius:8px;border:1px solid var(--q-border);text-transform:capitalize;transition:all .2s}
        .ri:hover .ct{background:var(--q-accent-glow);color:var(--q-accent);border-color:var(--q-accent)}
        .de{text-align:center;padding:44px;color:var(--q-text-muted);font-size:.85rem}
        .de i{font-size:36px;opacity:.15;display:block;margin-bottom:14px;transition:all .3s}
        .de:hover i{opacity:.3;transform:scale(1.1)}

        .lg{display:flex;gap:20px;justify-content:center;margin-top:16px}
        .lg span{display:flex;align-items:center;gap:7px;font-size:.72rem;color:var(--q-text-secondary)}
        .lg i{width:12px;height:12px;border-radius:4px;display:inline-block;transition:transform .2s}
        .lg span:hover i{transform:scale(1.3)}

        /* Chartist bar chart colors matching legend */
        #c1 .ct-series-a .ct-bar{stroke:#818cf8 !important}
        #c1 .ct-series-a .ct-area{fill:#818cf8 !important}
        #c1 .ct-series-b .ct-bar{stroke:#fb7185 !important}
        #c1 .ct-series-b .ct-area{fill:#fb7185 !important}

        /* Donut chart slice colors */
        #c2 .ct-series-a path{fill:#34d399 !important}
        #c2 .ct-series-b path{fill:#fbbf24 !important}
        #c2 .ct-series-c path{fill:#fb7185 !important}

        .sk{background:linear-gradient(90deg,var(--q-bg-raised) 25%,var(--q-bg-hover) 50%,var(--q-bg-raised) 75%);background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:10px}
        .fi{opacity:0;transform:translateY(18px);transition:opacity .55s ease,transform .55s ease}
        .fi.vis{opacity:1;transform:translateY(0)}

        /* Chartist donut labels */
        #c2 .ct-label{fill:var(--q-text) !important;color:var(--q-text) !important;font-size:12px !important;font-weight:700 !important}
        .ct-series .ct-slice path{stroke:var(--q-bg-card) !important;stroke-width:3px !important}

        /* Mini stat inside status pesanan */
        .mini-box{transition:all .3s;cursor:default;border-radius:16px;padding:16px 8px}
        .mini-box:hover{transform:translateY(-3px) scale(1.03)}
        .mini-box .mini-val{font-size:1.7rem;font-weight:800;letter-spacing:-.03em}
        .mini-box .mini-lbl{font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin-top:5px}

        @media(max-width:1199px){.st4{grid-template-columns:repeat(2,1fr)}.st3{grid-template-columns:repeat(2,1fr)}.g21,.g11{grid-template-columns:1fr}}
        @media(max-width:768px){
            .dash-hdr{padding:24px 20px;border-radius:20px}
            .dash-hdr h1{font-size:1.4rem}
            .dash-hdr .hdr-sub{font-size:.85rem}
            .dash-hdr .hdr-icon{width:60px;height:60px;border-radius:18px;font-size:24px}
            .flt{padding:14px 16px;gap:10px}
            .sc{padding:20px 18px}
            .sc .sc-val{font-size:1.35rem}
            .scs{padding:18px 20px}
            .scs .scs-val{font-size:1.15rem}
            .dc{padding:16px}
            .ri{padding:10px;gap:8px;flex-wrap:wrap}
            .ri-c{min-width:auto;font-size:.75rem}
            .ri-n{font-size:.78rem;width:100%;order:3}
            .ri-a{min-width:auto;font-size:.78rem}
        }
        @media(max-width:575px){
            .st4,.st3{grid-template-columns:1fr}
            .flt{flex-direction:column;align-items:stretch}
            .flt .fg{flex-direction:column;align-items:stretch}
            .flt .fi{min-width:auto;width:100%}
            .fb,.fb-rst{width:100%;justify-content:center}
            .flt-tag{text-align:center;white-space:normal}
        }
    </style>
</head>
<body>
    <?php include 'components/sidebar.php'; ?>
    <main class="content">
        <?php include 'components/navbar.php'; ?>

        <div class="dash-hdr fi">
            <div class="hdr-row">
                <div>
                    <h1>Dashboard</h1>
                    <p class="hdr-sub">Ringkasan data bisnis Anda secara real-time</p>
                    <div class="hdr-dots"><span></span><span></span><span></span></div>
                </div>
                <div class="hdr-icon"><i class="fas fa-chart-pie"></i></div>
            </div>
        </div>

        <div class="flt fi" id="fltBar">
            <div class="flt-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="fg"><span class="fl">Dari</span><input type="date" class="fi" id="fS" value="<?php echo date('Y-01-01'); ?>"></div>
            <span class="fs">—</span>
            <div class="fg"><span class="fl">Sampai</span><input type="date" class="fi" id="fE" value="<?php echo date('Y-m-d'); ?>"></div>
            <button class="fb" id="fBtn" onclick="go()"><i class="fas fa-filter"></i>Terapkan<div class="fb-load" id="fLd"></div></button>
            <button class="fb-rst" onclick="rst()"><i class="fas fa-redo"></i> Reset</button>
            <span class="flt-tag" id="fTag"></span>
        </div>

        <div id="dc"><div class="st4" id="sk1"></div><div class="g21" id="sk2"></div></div>
    </main>

    <?php include "../script/footscript.php"; ?>
    <script>
    var CI={},CD=null;
    function fmt(v){return Math.round(v||0).toLocaleString('id-ID')}
    function rp(v){return'Rp '+fmt(v)}

    function sk(){
        var h='<div class="st4">';
        var cls=['sc-dk','sc-rd','sc-em','sc-am'];
        for(var i=0;i<4;i++) h+='<div class="sc '+cls[i]+' fi"><div class="sk" style="width:100px;height:12px"></div><div class="sk" style="width:160px;height:28px;margin-top:16px"></div><div class="sk" style="width:80px;height:10px;margin-top:10px"></div></div>';
        h+='</div><div class="g21"><div class="dc"><div class="sk" style="width:200px;height:16px;margin-bottom:18px"></div><div class="sk" style="width:100%;height:260px;border-radius:14px"></div></div><div class="dc"><div class="sk" style="width:160px;height:16px;margin-bottom:18px"></div><div class="sk" style="width:100%;height:260px;border-radius:14px"></div></div></div>';
        document.getElementById('dc').innerHTML=h;
    }

    function go(){
        var s=document.getElementById('fS').value,e=document.getElementById('fE').value;
        document.getElementById('fLd').style.display='inline-block';document.getElementById('fBtn').disabled=true;
        fetch('/qieos/pages/components/data/dashboard-data.php?start='+encodeURIComponent(s)+'&end='+encodeURIComponent(e)+'&_='+Date.now())
        .then(function(r){if(!r.ok)throw new Error(r.status);return r.text()})
        .then(function(t){
            var d;try{d=JSON.parse(t)}catch(x){
                document.getElementById('dc').innerHTML='<div style="color:var(--q-danger);padding:24px;background:var(--q-danger-bg);border-radius:16px;border:1px solid rgba(248,113,113,.2)"><b><i class="fas fa-exclamation-triangle"></i> Error</b><pre style="margin-top:10px;font-size:.8rem;white-space:pre-wrap;max-height:120px;overflow:auto">'+t.substring(0,600)+'</pre></div>';
                done();return;
            }
            done();
            document.getElementById('fTag').textContent=new Date(s).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'})+' — '+new Date(e).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});
            render(d);
        }).catch(function(err){
            document.getElementById('dc').innerHTML='<div style="color:var(--q-danger);padding:24px;background:var(--q-danger-bg);border-radius:16px"><b>'+err.message+'</b></div>';done();
        });
        function done(){document.getElementById('fLd').style.display='none';document.getElementById('fBtn').disabled=false}
    }
    function rst(){
        document.getElementById('fS').value='<?php echo date("Y-01-01"); ?>';document.getElementById('fE').value='<?php echo date("Y-m-d"); ?>';
        document.getElementById('fTag').textContent='';go();
    }

    function render(d){
        CD=d;var s=d.status,st=d.stats;var h='';

        // 4 MAIN CARDS
        h+='<div class="st4">';
        h+=mcard('sc-dk','#6366f1','fa-wallet','Total Pendapatan',rp(st.pendapatan),'Hari ini: '+rp(st.today_pendapatan),'pendapatan');
        h+=mcard('sc-rd','#f43f5e','fa-shopping-cart','Total Pengeluaran',rp(st.total_pengeluaran),'Dari list pembelian barang','pengeluaran');
        h+=mcard('sc-em','#10b981','fa-chart-pie','Laba Bersih',rp(st.laba),st.laba>=0?'Untung':'Rugi — perlu review','laba');
        h+=mcard('sc-am','#f59e0b','fa-clipboard-list','Total Pesanan',fmt(st.pesanan),st.today_orders+' hari ini','pesanan');
        h+='</div>';

        // 3 SECONDARY CARDS
        h+='<div class="st3">';
        h+=scard('ic-violet','fa-store','Pembayaran Sewa',rp(st.bayar_tenant),'bayar_tenant');
        h+=scard('ic-cyan','fa-bolt','Air & Listrik',rp(st.bayar_utility),'bayar_utility');
        h+=scard('ic-indigo','fa-boxes','Total Produk',fmt(st.produk),'produk');
        h+='</div>';

        // CHARTS ROW 1
        h+='<div class="g21">';
        h+=dcc('Pendapatan vs Pengeluaran','Perbandingan 6 bulan terakhir','fa-chart-bar','c1',270,'<div class="lg"><span><i style="background:#818cf8"></i>Pendapatan</span><span><i style="background:#fb7185"></i>Pengeluaran</span></div>');
        h+='<div class="dc fi"><div class="dc-h"><div><div class="dc-t">Status Pesanan</div><div class="dc-s">Periode filter aktif</div></div><div class="dc-i"><i class="fas fa-chart-pie"></i></div></div><div id="c2" style="height:140px"></div>';
        h+='<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(100px,1fr));gap:10px;margin-top:14px">';
        h+=msInd('Dibayar',s.paid,'#34d399','#10b981');
        h+=msInd('Pending',s.waiting,'#fbbf24','#f59e0b');
        h+=msInd('Dibatal',s.cancelled,'#fb7185','#f43f5e');
        h+='</div></div></div>';

        // CHARTS ROW 2 + TABLE
        h+='<div class="g11">';
        h+=dcc('Omzet 7 Hari','Pendapatan harian minggu ini','fa-chart-line','c3',220);
        h+='<div class="dc fi"><div class="dc-h"><div><div class="dc-t">Pesanan Terbaru</div><div class="dc-s">Transaksi terakhir masuk</div></div><div class="dc-i"><i class="fas fa-receipt"></i></div></div>';
        if(!d.recent_orders.length) h+='<div class="de"><i class="fas fa-receipt"></i>Belum ada pesanan</div>';
        else d.recent_orders.forEach(function(o){
            var bc=o.status_payment==='paid'?'b-p':o.status_payment==='waiting'?'b-w':'b-c';
            h+='<div class="ri"><div class="ri-c">'+o.code+'</div><div class="ri-n" style="color:var(--q-text);font-weight:600">'+(o.operator||'—')+'</div><div class="ri-a">'+rp(o.total)+'</div><div class="ri-b '+bc+'">'+o.status_payment+'</div></div>';
        });
        h+='</div></div>';

        // BOTTOM TABLES
        h+='<div class="g11">';
        h+='<div class="dc fi"><div class="dc-h"><div><div class="dc-t">Produk Terlaris</div><div class="dc-s">Top 5 berdasarkan revenue</div></div><div class="dc-i"><i class="fas fa-trophy"></i></div></div>';
        if(!d.top_products.length) h+='<div class="de"><i class="fas fa-box"></i>Belum ada data</div>';
        else{var r=1;d.top_products.forEach(function(p){
            h+='<div class="ri"><div class="rk">'+(r++)+'</div><div class="ri-n" style="font-weight:600;color:var(--q-text)">'+p.name+'</div><div class="ct">'+p.category+'</div><div class="ri-a">'+rp(p.rev)+'</div></div>';
        });}
        h+='</div>';

        h+='<div class="dc fi"><div class="dc-h"><div><div class="dc-t">List Pembelian Terakhir</div><div class="dc-s">Riwayat pengadaan barang</div></div><div class="dc-i"><i class="fas fa-clipboard-list"></i></div></div>';
        if(!d.recent_list_purchases.length) h+='<div class="de"><i class="fas fa-truck"></i>Belum ada pembelian</div>';
        else d.recent_list_purchases.forEach(function(p){
            var dt=new Date(p.date_list).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});
            h+='<div class="ri"><div class="ri-c">'+dt+'</div><div class="ri-n">'+p.items+' item</div><div class="ri-a">'+rp(p.total)+'</div></div>';
        });
        h+='</div></div>';

        document.getElementById('dc').innerHTML=h;
        setTimeout(function(){
            document.querySelectorAll('.fi').forEach(function(el,i){setTimeout(function(){el.classList.add('vis')},40+i*50)});
            document.querySelectorAll('[data-w]').forEach(function(el){el.style.width=el.getAttribute('data-w')});
        },20);
        renderCharts(d);
    }

    function mcard(cls,color,icon,label,val,sub,key){
        var pct=0;if(CD&&CD.stats.pendapatan>0){
            if(key==='pendapatan')pct=100;
            else if(key==='pengeluaran')pct=Math.min(Math.round(CD.stats.total_pengeluaran/CD.stats.pendapatan*100),100);
            else if(key==='pesanan')pct=100;
            else if(key==='laba')pct=CD.stats.laba>=0?100:0;
        }
        var isNeg=key==='laba'&&CD&&CD.stats.laba<0;
        var arrow=isNeg?'fa-arrow-down':'fa-arrow-up';
        var ac=isNeg?'color:var(--q-danger)':'color:var(--q-success)';
        return'<div class="sc '+cls+' fi"><div class="sc-glow" style="background:'+color+'"></div><div class="sc-top"><div><div class="sc-lbl">'+label+'</div><div class="sc-val">'+val+'</div><div class="sc-sub"><i class="fas '+arrow+'" style="'+ac+'"></i> '+sub+'</div></div><div class="sc-ic '+cls.replace('sc-','ic-')+'"><i class="fas '+icon+'"></i></div></div><div class="sc-bar"><div class="sc-bar-fill '+cls.replace('sc-','bar-')+'" data-w="'+pct+'%"></div></div><i class="fas '+icon+' sc-deco"></i></div>';
    }

    function scard(ic,icon,label,val,key){
        var pct=0;if(CD&&CD.stats.pendapatan>0){
            if(key==='bayar_tenant')pct=Math.min(Math.round(CD.stats.bayar_tenant/CD.stats.pendapatan*100),100);
            else if(key==='bayar_utility')pct=Math.min(Math.round(CD.stats.bayar_utility/CD.stats.pendapatan*100),100);
            else if(key==='produk')pct=100;
        }
        return'<div class="scs fi"><div class="scs-top"><div><div class="scs-lbl">'+label+'</div><div class="scs-val">'+val+'</div></div><div class="scs-ic '+ic+'"><i class="fas '+icon+'"></i></div></div><div class="scs-bar"><div class="scs-bar-fill '+(ic==='ic-indigo'?'bar-indigo':ic==='ic-cyan'?'bar-cyan':'bar-violet')+'" data-w="'+pct+'%"></div></div></div>';
    }

    function dcc(title,sub,icon,id,h,extra){
        return'<div class="dc fi"><div class="dc-h"><div><div class="dc-t">'+title+'</div><div class="dc-s">'+sub+'</div></div><div class="dc-i"><i class="fas '+icon+'"></i></div></div><div id="'+id+'" style="height:'+h+'px"></div>'+(extra||'')+'</div>';
    }

    function msInd(label,val,bgColor,dotColor){
        return'<div style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;background:var(--q-bg-raised);transition:all .25s;cursor:default" onmouseover="this.style.transform=\'translateX(4px)\'" onmouseout="this.style.transform=\'none\'"><div style="width:32px;height:32px;border-radius:10px;background:'+bgColor+';flex-shrink:0;display:flex;align-items:center;justify-content:center"><div style="width:10px;height:10px;border-radius:50%;background:'+dotColor+';box-shadow:0 0 8px '+dotColor+'"></div></div><div style="flex:1;min-width:0"><div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--q-text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+label+'</div><div style="font-size:1.1rem;font-weight:800;color:var(--q-text);letter-spacing:-.03em;margin-top:1px">'+val+'</div></div></div>';
    }

    function renderCharts(d){
        if(typeof Chartist==='undefined')return;
        Object.values(CI).forEach(function(c){try{c.detach()}catch(e){}});CI={};
        var o={plugins:[Chartist.plugins.tooltip()],axisY:{offset:55,labelInterpolationFnc:function(v){return v>=1e6?(v/1e6).toFixed(1)+'jt':v>=1e3?(v/1e3).toFixed(0)+'rb':v}},axisX:{showGrid:false},chartPadding:{top:20,right:12,bottom:8,left:12}};

        setTimeout(function(){
            if(d.chart_months&&d.chart_months.length&&document.getElementById('c1')){
                CI.bar=new Chartist.Bar('#c1',{labels:d.chart_months,series:[{name:'Pendapatan',data:d.chart_pendapatan,className:'ct-series-a'},{name:'Pengeluaran',data:d.chart_pengeluaran,className:'ct-series-b'}]},Object.assign({},o,{seriesBarDistance:8}));
            }
            var pd=[d.status.paid,d.status.waiting,d.status.cancelled];
            if(pd.some(function(v){return v>0})&&document.getElementById('c2')){
                CI.pie=new Chartist.Pie('#c2',{labels:['Dibayar','Pending','Dibatal'],series:pd},{donut:true,donutWidth:40,donutSolid:true,showLabel:false,plugins:[Chartist.plugins.tooltip()]});
            }
            if(d.chart_week&&d.chart_week.length&&document.getElementById('c3')){
                CI.line=new Chartist.Line('#c3',{labels:d.chart_week.map(function(w){return w.l}),series:[{data:d.chart_week.map(function(w){return w.v})}]},Object.assign({},o,{lineSmooth:Chartist.Interpolation.cardinal({tension:.3}),fullWidth:true}));
            }
        },120);
    }

    document.addEventListener('DOMContentLoaded',function(){sk();go()});
    </script>
</body>
</html>
