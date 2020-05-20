'use strict';

//------------------
// Global variables
//------------------

var appdir = $('base').attr('href');
var windowFocus = true;
var firstFocus = true;
var updateTimeout;

//------------------
// Functions
//------------------

function toggleVisibility(id) {
    var element = $('#' + id);

    if (element.css('display') == 'none') {
        $('#inventory_panel').css('display', 'none');
        $('#action_panel').css('display', 'none');
        $('#nav_top').css('display', 'none');

        element.css('display', 'block');
    } else {
        element.css('display', 'none');
    }
}

function updateLastActivity() {
    if (windowFocus && $('#nav_logout').length != 0) {
        $.ajax({
            url: appdir + 'account/update_activity',
            cache: false,
            dataType: 'json',
            success: function (data) {
                gameManipulateDOM(data);
            },
        });
    }

    updateTimeout = window.setTimeout(updateLastActivity, 30000);
}

//------------------
// Event handelers
//------------------

$(document).ready(function () {
    window.setTimeout(updateLastActivity, 60000);

    if ($('#initial_page_load').length != 0) {
        $('#initial_page_load').fadeOut(3000);
    }
});

$(window).on('focus blur', function (e) {
    //Detects if game has focus or not, discontinues automatic updates
    var prevType = $(this).data('prevType');

    if (prevType != e.type) {
        //reduce double fire issues

        switch (e.type) {
            case 'blur':
                windowFocus = false;
                firstFocus = false;

                break;
            case 'focus':
                windowFocus = true;

                if (firstFocus == false) {
                    clearTimeout(updateTimeout);
                    updateLastActivity();
                }

                break;
        }
    }

    $(this).data('prevType', e.type);
});

$(document).on('click', 'a.disabled', function () {
    return false;
});

$(document).on('click', '#nav_top_button', function () {
    toggleVisibility('nav_top');
    return false;
});

$(document).on('click', 'nav#nav_top a', function () {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('nav#nav_top').css('display', 'none');
    }
});

$(document).on('click', '#action_panel_button', function () {
    toggleVisibility('action_panel');
    return false;
});

$(document).on('click', '#action_panel a', function () {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('#action_panel').css('display', 'none');
    }
});

$(document).on('click', '#inventory_panel_button', function () {
    toggleVisibility('inventory_panel');
    return false;
});

$(document).on('click', '#inventory_panel a', function () {
    if (window.innerWidth < 959) {
        //Collapse this panel if mobile view is used
        $('#inventory_panel').css('display', 'none');
    }
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
