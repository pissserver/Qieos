const CACHE_VERSION = "qieos-v1";
const APP_SHELL_CACHE = `${CACHE_VERSION}-shell`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;

const BASE = "/qieos";

// Aset statis inti yang aman di-precache (tidak butuh sesi login)
const APP_SHELL = [
    `${BASE}/manifest.json`,
    `${BASE}/css/volt.css`,
    `${BASE}/assets/js/volt.js`,
    `${BASE}/assets/img/brand/qieos.png`,
    `${BASE}/assets/img/brand/qieos2.png`,
    `${BASE}/assets/img/brand/icon-192.png`,
    `${BASE}/assets/img/brand/icon-512.png`,
    `${BASE}/offline.html`
];

// INSTALL — precache app shell
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(APP_SHELL_CACHE).then(cache =>
            // addAll gagal-total kalau salah satu 404, jadi pakai per-item agar tahan error
            Promise.allSettled(
                APP_SHELL.map(url =>
                    cache.add(new Request(url, { cache: "reload" }))
                )
            )
        )
    );
    self.skipWaiting();
});

// ACTIVATE — bersihkan cache versi lama
self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => !key.startsWith(CACHE_VERSION))
                    .map(key => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

function isHtmlRequest(request) {
    return (
        request.mode === "navigate" ||
        (request.headers.get("accept") || "").includes("text/html")
    );
}

function isStaticAsset(url) {
    return /\.(css|js|png|jpg|jpeg|gif|svg|webp|ico|woff2?|ttf|eot)$/i.test(url.pathname);
}

// FETCH — strategi berbeda per jenis request
self.addEventListener("fetch", event => {
    const { request } = event;

    // Hanya tangani GET; biarkan POST/PUT/DELETE (login, aksi CRUD) lewat langsung
    if (request.method !== "GET") return;

    const url = new URL(request.url);

    // Abaikan request lintas-origin (CDN, dll) — biarkan browser menanganinya
    if (url.origin !== self.location.origin) return;

    // Navigasi halaman (HTML PHP) → network-first, fallback cache lalu offline page
    if (isHtmlRequest(request)) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const copy = response.clone();
                    caches.open(RUNTIME_CACHE).then(cache => cache.put(request, copy));
                    return response;
                })
                .catch(() =>
                    caches.match(request).then(
                        cached => cached || caches.match(`${BASE}/offline.html`)
                    )
                )
        );
        return;
    }

    // Aset statis → cache-first, isi cache saat pertama kali diambil
    if (isStaticAsset(url)) {
        event.respondWith(
            caches.match(request).then(cached => {
                if (cached) return cached;
                return fetch(request).then(response => {
                    if (response && response.status === 200 && response.type === "basic") {
                        const copy = response.clone();
                        caches.open(RUNTIME_CACHE).then(cache => cache.put(request, copy));
                    }
                    return response;
                });
            })
        );
        return;
    }

    // Default → network dengan fallback cache
    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});
