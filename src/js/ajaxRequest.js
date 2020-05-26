import axios from 'axios';

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

const ajaxJsonRequest = (event) => {
    event.preventDefault();

    var $element = $(event.target);
    var elementType = $element.prop('tagName');
    var url;
    var myData;

    if (elementType === 'IMG') {
        // Find closest link for the image
        $element = $element.closest('a');
        var elementType = $element.prop('tagName');
    }

    if (elementType == 'FORM') {
        url = $element.attr('action');
        myData = $element.serialize();
    } else if (elementType == 'A') {
        url = $element.attr('href');
        var question = $element.attr('rel');
        myData = false;

        if (question && !window.confirm(question)) {
            //I put confirm questions in a rel="", if it exists and is not verified - do nothing
            return false;
        }
    }

    $('body').addClass('loading');

    axios({
        method: 'post',
        url: url,
        data: myData,
        responseType: 'json'
    })
        .then((response) => {
            gameManipulateDOM(response.data);

            // Send JS event
            if (response.data.event) {
                console.log('Event: ' + response.data.event);
                window.dispatchEvent(new Event(response.data.event));
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', gaURL.pathname);
            }
        })
        .catch((err) => {
            var errorMsg = '<div class="error"><p>Failed to send data: ' + err.toString() + '</p></div>';
            $('div#msg').prepend(errorMsg);
        })
        .then((_) => {
            $('body').removeClass('loading');
            $('html, body').animate({ scrollTop: 0 }, 'normal');
        });
};

const fetchHtmlAndUpdateDom = (url) => {
    $('body').addClass('loading');

    axios({
        url: url,
        method: 'get',
        responseType: 'text'
    })
        .then((response) => {
            $('article#main').html(response.data);

            //Change document title from <header title=""> on source, trim is needed for pages starting with tab
            var title = $(response.data.trim()).filter('header').attr('title') + ' - Lost Seas';

            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            triggerEventFromUrl();
        })
        .catch((err) => {
            var errorDiv = $(
                '<div class="url_error">Something went wrong when recieving HTML: ' + err.toString() + '</div>'
            ).hide();
            $('body').append(errorDiv);
            errorDiv.fadeIn(300).delay(4000).fadeOut(300);
            $('body').removeClass('loading');
        })
        .then((_) => {
            $('body').removeClass('loading');

            if (window.location.hash) {
                //Handle internal links (hash)
                var $hash = $('#' + window.location.hash.substring(1));

                if ($hash.length) {
                    $(document).scrollTop($hash.offset().top);
                }
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'normal');
            }
        });
};

const ajaxHtmlRequest = (e) => {
    e.preventDefault();

    var $element = $(e.target);

    if ($element.prop('tagName') !== 'A' && $element.prop('tagName') !== 'AREA') {
        $element = $element.closest('a');
    }

    const url = $element.attr('href');

    fetchHtmlAndUpdateDom(url);

    if (url != window.location) {
        window.history.pushState({ path: url }, '', url);
    }
};

const onPopState = (e) => {
    const url = location.pathname;

    fetchHtmlAndUpdateDom(url);
};

const addEventListeners = () => {
    const ajaxJsonFormEls = Array.from(document.querySelectorAll('form.ajaxJSON'));
    const ajaxJsonLinkEls = Array.from(document.querySelectorAll('a.ajaxJSON'));
    const ajaxHtmlLinkEls = Array.from(document.querySelectorAll('a.ajaxHTML'));

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
