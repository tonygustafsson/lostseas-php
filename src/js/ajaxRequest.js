import axios from 'axios';
import snackbar from './components/snackbar';
import manipulateDom from './manipulateDom';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const triggerEventFromUrl = () => {
    // Take path name, remove first /
    const pathName = window.location.pathname.substr(1);

    // Take the first two segments of the URL as segments
    const segments = pathName.split('/').slice(0, 2);

    // Make it a string, so /about/me/random1/random2 becomes about-me
    let eventName = segments.join('-');

    if (!eventName) {
        eventName = 'about-presentation';
    }

    console.log('Event: ' + eventName);

    window.dispatchEvent(new Event(eventName));
    window.dispatchEvent(new Event('updated-dom'));
};

const ajaxJsonRequest = (e) => {
    e.preventDefault();

    var element = e.target;
    var elementType = element.tagName.toLowerCase();
    var url;
    var myData = null;

    if (elementType === 'img' || elementType === 'svg' || elementType === 'use') {
        // Find closest link for the image
        element = element.closest('a');
        elementType = element.tagName.toLowerCase();
    }

    if (elementType === 'form') {
        url = element.action;
        myData = new FormData(element);
    } else if (elementType === 'a') {
        url = element.href;
        var question = element.rel;

        if (question && !window.confirm(question)) {
            //I put confirm questions in a rel="", if it exists and is not verified - do nothing
            return false;
        }
    }

    const body = document.getElementById('body');
    body.classList.add('loading');

    axios({
        method: 'post',
        url: url,
        data: myData,
        responseType: 'json'
    })
        .then((response) => {
            manipulateDom(response.data);

            // Send JS event
            if (response.data.event) {
                console.log('Event: ' + response.data.event);
                window.dispatchEvent(new Event(response.data.event));
            }

            //Google analytics, virtual pageview
            const gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', gaURL.pathname);
            }
        })
        .catch((err) => {
            snackbar({ text: `Failed to send data. ${err.toString()}`, level: 'error' });
        })
        .then((_) => {
            body.classList.remove('loading');
        });
};

const fetchHtmlAndUpdateDom = (url, updateLocation) => {
    const body = document.getElementById('body');
    body.classList.add('loading');

    axios({
        url: url,
        method: 'get',
        responseType: 'json'
    })
        .then((response) => {
            const main = document.getElementById('main');
            main.innerHTML = response.data.content;

            if (response.data.manipulateDom) {
                manipulateDom(JSON.parse(response.data.manipulateDom));
            }

            var title = response.data.title;

            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            if (updateLocation) {
                if (url != window.location) {
                    window.history.pushState({ path: url }, '', url);
                }
            }

            triggerEventFromUrl();
        })
        .catch((err) => {
            if (err.response && err.response.status === 404) {
                snackbar({ text: `Page not found: ${err.toString()}`, level: 'error' });
            } else {
                snackbar({ text: `Could not revieve HTML: ${err.toString()}`, level: 'error' });
            }
        })
        .then((_) => {
            body.classList.remove('loading');

            if (window.location.hash) {
                //Handle internal links (hash)
                var scrollToEl = document.getElementById(window.location.hash.substring(1));

                if (scrollToEl) {
                    scrollToEl.scrollIntoView({ alignToTop: true, behavior: 'smooth' });
                }
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
};

const ajaxHtmlRequest = (e) => {
    e.preventDefault();

    let element = e.target;
    const elementType = element.tagName.toLowerCase();

    if (elementType !== 'a') {
        element = element.closest('a');
    }

    let url = element.href;

    if (url.baseVal) {
        url = element.href.baseVal;
    }

    fetchHtmlAndUpdateDom(url, true);
};

const onPopState = (e) => {
    const url = location.pathname;

    fetchHtmlAndUpdateDom(url);
};

const addEventListeners = () => {
    const ajaxJsonFormEls = Array.from(document.querySelectorAll('form.ajaxJSON'));
    const ajaxJsonLinkEls = Array.from(document.querySelectorAll('a.ajaxJSON'));
    const ajaxHtmlLinkEls = Array.from(document.querySelectorAll('.ajaxHTML'));

    ajaxJsonFormEls.forEach((el) => {
        el.addEventListener('submit', ajaxJsonRequest);
    });

    ajaxJsonLinkEls.forEach((el) => {
        el.addEventListener('click', ajaxJsonRequest);
    });

    ajaxHtmlLinkEls.forEach((el) => {
        el.addEventListener('click', ajaxHtmlRequest);
    });
};

window.addEventListener('updated-dom', () => {
    addEventListeners();
});

window.addEventListener('popstate', onPopState);

document.addEventListener('DOMContentLoaded', () => {
    triggerEventFromUrl();
    addEventListeners();
});
