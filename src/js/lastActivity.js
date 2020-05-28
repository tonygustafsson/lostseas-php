import manipulateDom from './manipulateDom';

const appdir = $('base').attr('href');
const timerTimeout = 60000;

let windowFocus = true;
let firstFocus = true;
let updateTimeout;

const updateLastActivity = () => {
    if (windowFocus && $('#nav_logout').length != 0) {
        $.ajax({
            url: appdir + 'account/update_activity',
            cache: false,
            dataType: 'json',
            success: function (data) {
                manipulateDom(data);
            }
        });
    }

    updateTimeout = window.setTimeout(updateLastActivity, timerTimeout);
};

const toggleLastActivityCheck = (e) => {
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
};

$(window).on('focus blur', toggleLastActivityCheck);

$(document).ready(function () {
    window.setTimeout(updateLastActivity, timerTimeout);
});
