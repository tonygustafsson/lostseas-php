const offlinePage = './offline.html';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('sw-cache').then((cache) => {
            return cache.addAll([offlinePage, './assets/images/logo.svg']);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            if (response) {
                // Cached content
                return response;
            } else {
                // Fetch from network
                return fetch(event.request).catch((error) => {
                    // Send offline page on error
                    return caches.match(offlinePage);
                });
            }
        })
    );
});
