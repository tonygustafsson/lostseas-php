'use strict';

$(document).ready(function () {
    if ($('#initial_page_load').length != 0) {
        $('#initial_page_load').fadeOut(3000);
    }
});

$(document).on('click', 'a.disabled', function () {
    return false;
});

$(document).on('click', 'a.newWindow', function (e) {
    e.preventDefault();

    var url = $(this).attr('href');
    var title = $(this).attr('title') + ' - Lost Seas';

    var popUp = window.open(url, title, 'width=850, height=500, left=10, top=10, scrollbars, resizable');

    if (popUp === null || typeof popUp === 'undefined') {
        window.alert('The chat could not launch because popups are disabled in your browser!');
    } else {
        popUp.focus();
    }
});
