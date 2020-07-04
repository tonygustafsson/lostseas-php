import axios from 'axios';

const updateEveryMs = 60000;

let updateInterval;

const ping = () => {
    const loggOutBtnEl = document.getElementById('nav_logout');
    const url = window.appPath + 'ping';

    axios({
        method: 'post',
        responseType: 'json',
        url: url
    }).then((result) => {
        const weather = result.data.weather;
        const weatherEvent = new CustomEvent('weather', { detail: { weather: weather } });
        window.dispatchEvent(weatherEvent);
    });

    updateInterval = setTimeout(ping, updateEveryMs);
};

const startChecks = (e) => {
    updateInterval = setTimeout(ping, updateEveryMs);
};

const stopChecks = (e) => {
    clearInterval(updateInterval);
};

window.addEventListener('focus', startChecks);
window.addEventListener('blur', stopChecks);

window.addEventListener('load', () => {
    const logOutBtnEl = document.getElementById('nav_logout');

    if (logOutBtnEl) {
        // Only run if logged in
        startChecks();
    }
});
