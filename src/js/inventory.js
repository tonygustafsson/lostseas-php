'use strict';

function checkAll(name) {
    if ($("input[name='check_all']").is(':checked')) {
        $("input[name='" + name + "[]']").prop('checked', true);
        $("input[name='" + name + "[]']")
            .parent()
            .parent()
            .css('background', '#e5f0f6');
    } else {
        $("input[name='" + name + "[]']").prop('checked', false);
        $("input[name='" + name + "[]']")
            .parent()
            .parent()
            .css('background', 'transparent');
    }
}

window.checkAll = checkAll;

$(document).on('click', '#crew_form tr td:not(:first-child)', function () {
    var thisCheckbox = $(this).parent().find('td:first-child').find('input[type="checkbox"]');

    if (thisCheckbox.length !== 0) {
        if (thisCheckbox.is(':checked')) {
            thisCheckbox.prop('checked', false);
            $(this).parent().css('background', 'transparent');
        } else {
            thisCheckbox.prop('checked', true);
            $(this).parent().css('background', '#e5f0f6');
        }
    }
});

$(document).on('change', '#crew_form input[type=checkbox]', function () {
    if ($(this).is(':checked')) {
        $(this).parent().parent().css('background', '#e5f0f6');
    } else {
        $(this).parent().parent().css('background', 'transparent');
    }
});

$(document).on('change', '#history_weeks', function () {
    var url = $('#base_url').val() + '/' + $('#history_data').val() + '/' + $('#history_weeks').val();
    $('#history_update_link').attr('href', url);
});

$(document).on('change', '#history_data', function () {
    var url = $('#base_url').val() + '/' + $('#history_data').val() + '/' + $('#history_weeks').val();
    $('#history_update_link').attr('href', url);
});
