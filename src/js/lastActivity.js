import axios from 'axios';
import manipulateDom from './manipulateDom';

const base = document.getElementsByTagName('base')[0];
const appdir = base.href;
const updateActivityEveryMs = 60000;

let updateInterval;

const updateLastActivity = () => {
    const loggOutBtnEl = document.getElementById('nav_logout');
    const url = appdir + 'account/update_activity';

    axios({
        method: 'post',
        url: url
    }).then((result) => {
        manipulateDom(result.data.manipulateDom);
    });

    updateInterval = setTimeout(updateLastActivity, updateActivityEveryMs);
};

const startChecks = (e) => {
    updateInterval = setTimeout(updateLastActivity, updateActivityEveryMs);
};

const stopChecks = (e) => {
    clearInterval(updateInterval);
};

window.addEventListener('focus', startChecks);
window.addEventListener('blur', stopChecks);

const logOutBtnEl = document.getElementById('nav_logout');

if (logOutBtnEl) {
    // Only run if logged in
    startChecks();
}
