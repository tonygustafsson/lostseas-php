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

    $.ajax({
        type: 'POST',
        url: url,
        data: myData,
        dataType: 'json',
        beforeSend: function () {
            $('body').addClass('loading');
        },
        success: function (data) {
            gameManipulateDOM(data);

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', gaURL.pathname);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = '<div class="error"><p>Failed to send data: ' + thrownError + '</p></div>';
            $('div#msg').prepend(errorMsg);
        },
        complete: function () {
            $('body').removeClass('loading');
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

    var url = $element.attr('href');

    $.ajax({
        url: url,
        cache: false,
        beforeSend: function () {
            $('body').addClass('loading');
        },
        success: function (data) {
            $('article#main').html(data);

            if (window.location.hash) {
                //Handle internal links (hash)
                var hash = $('#' + window.location.hash.substring(1));
                if ($(hash).offset()) {
                    $(document).scrollTop($(hash).offset().top);
                }
            }

            //Change document title from <header title=""> on source, trim is needed for pages starting with tab
            var title = $(data.trim()).filter('header').attr('title') + ' - Lost Seas';
            var place = $(data.trim()).filter('header').attr('place');

            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = url;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            if (url != window.location) {
                window.history.pushState({ path: url }, '', url);
            }

            if (place) {
                window.dispatchEvent(new Event(`page_${place}`));
            }

            $('body').removeClass('loading');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorDiv = $(
                '<div class="url_error">Something went wrong when recieving HTML: ' + thrownError + '</div>'
            ).hide();
            $('body').append(errorDiv);
            errorDiv.fadeIn(300).delay(4000).fadeOut(300);
            $('body').removeClass('loading');
        }
    });

    return false;
};

const onPopState = (e) => {
    if (!e.originalEvent.state) {
        return;
    }

    $.ajax({
        url: location.pathname,
        cache: false,
        beforeSend: function () {
            $('body').addClass('loading');
        },
        success: function (data) {
            $('article#main').html(data);

            //Change document title from <header title=""> on source, trim is needed for pages starting with tab
            var title = $(data.trim()).filter('header').attr('title') + ' - Lost Seas';
            var place = $(data.trim()).filter('header').attr('place');

            if (title) {
                document.title = title;
            }

            //Google analytics, virtual pageview
            var gaURL = document.createElement('a');
            gaURL.href = location.pathname;

            if (typeof ga == typeof Function) {
                ga('send', 'pageview', { page: gaURL.pathname, title: title });
            }

            if (place) {
                window.dispatchEvent(new Event(`page_${place}`));
            }

            $('body').removeClass('loading');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorDiv = $(
                '<div class="url_error">Something went wrong when recieving HTML: ' + thrownError + '</div>'
            ).hide();
            $('body').append(errorDiv);
            errorDiv.fadeIn(300).delay(4000).fadeOut(300);
            $('body').removeClass('loading');
        }
    });
};

$(document).on('submit', '.ajaxJSON', ajaxJsonRequest);

$(document).on('click', 'a.ajaxJSON', ajaxJsonRequest);

$(document).on('click', '.ajaxHTML', ajaxHtmlRequest);

$(window).on('popstate', onPopState);

document.addEventListener('DOMContentLoaded', () => {
    var place = $('#main > header').attr('place');
    window.dispatchEvent(new Event(`page_${place}`));
});
