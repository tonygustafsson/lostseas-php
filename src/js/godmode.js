const godmodeChangeAll = (pattern) => {
    var input = window.prompt('Enter input for ' + pattern);
    $("input[id$='_" + pattern + "']").val(input);
};

$(document).on('change', '#godmode_change_user', function () {
    var chosenUser = $('select[name=godmode_change_user]').val();
    var baseURL = $('#godmode_change_user_url').data('baseurl');
    $('#godmode_change_user_url').attr('href', baseURL + '/' + chosenUser);
});

window.godmodeChangeAll = godmodeChangeAll;
