import axios from 'axios';
import snackbar from './components/snackbar';
import manipulateDom from './manipulateDom';
import dialog from './components/dialog.js';

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
    window.dispatchEvent(new Event('trigger-ajax-request-listeners'));
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

        const promptHeading = element.dataset.promptHeading;
        const promptText = element.dataset.promptText;

        if (promptHeading) {
            dialog({
                dialogHeading: promptHeading,
                dialogContent: promptText ? `<p>${promptText}</p>` : '',
                dialogActions: [{ title: 'Yes', url: url, primary: true }, { title: 'No' }]
            });

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

            if (typeof window.gtag == typeof Function) {
                // Google analytics, virtual pageview
                var gaURL = document.createElement('a');
                gaURL.href = url;

                window.gtag('event', gaURL.pathname, { event_category: 'Ajax' });
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

            if (typeof window.gtag == typeof Function) {
                // Google analytics, virtual pageview
                var gaURL = document.createElement('a');
                gaURL.href = url;

                window.gtag('config', window.googleAnalyticsId, { page_title: title, page_path: gaURL.pathname });
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

window.addEventListener('trigger-ajax-request-listeners', () => {
    console.log('Updated DOM. Create event listneres for AJAX.');
    addEventListeners();
});

window.addEventListener('popstate', onPopState);

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content loaded. Create event listeners for AJAX.');
    triggerEventFromUrl();
    //addEventListeners();
});
