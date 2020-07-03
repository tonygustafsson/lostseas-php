self.addEventListener('zinstall', function (event) {
    event.waitUntil(
        caches.open('sw-cache').then(function (cache) {
            return cache.addAll([
                '/assets/js/main.js',
                '/assets/js/styles.js',
                '/assets/images/design/background-ship.svg',
                '/assets/images/design/back_sky.jpg',
                '/assets/images/favicon.svg'
            ]);
        })
    );
});

self.addEventListener('zfetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request);
        })
    );
});
