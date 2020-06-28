import axios from 'axios';
import manipulateDom from './manipulateDom';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;
const updateEveryMs = 60000;

let updateInterval;

const ping = () => {
    const loggOutBtnEl = document.getElementById('nav_logout');
    const url = appdir + 'ping';

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
