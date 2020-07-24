const changeWeather = (weather) => {
    const svgWeather = document.getElementById(`weather-${weather}`);
    const allSvgWeathers = Array.from(document.querySelectorAll('.logo-weather'));

    if (!svgWeather) {
        return;
    }

    allSvgWeathers.forEach((el) => {
        el.style.fillOpacity = 0;
    });

    svgWeather.style.fillOpacity = 1;
};

window.addEventListener('weather', (e) => {
    changeWeather(e.detail.weather);
});

window.addEventListener('load', () => {
    const weatherLogoLink = document.querySelector('.js-logo-link');

    if (!weatherLogoLink) {
        return;
    }

    const weather = weatherLogoLink.dataset.weather;

    if (!weather) {
        return;
    }

    changeWeather(weather);
});
