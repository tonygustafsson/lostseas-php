const toggleVisibility = (id) => {
    var $element = $('#' + id);

    if ($element.css('display') == 'none') {
        $('#inventory_panel').css('display', 'none');
        $('#action_panel').css('display', 'none');
        $('#nav_top').css('display', 'none');

        $element.css('display', 'block');
    } else {
        $element.css('display', 'none');
    }
};

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
