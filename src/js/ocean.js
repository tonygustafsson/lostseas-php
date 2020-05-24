'use strict';

const runOcean = () => {
    var appdir = $('base').attr('href');

    $(document).on('mouseover', 'area', function () {
        if ($('#town_info').length === 0) {
            var townInfo = $('<div>');
            townInfo.attr('id', 'town_info');

            var styles = {
                background: 'rgba(164,161,162,0.7)',
                border: '1px black dotted',
                padding: '4px',
                position: 'absolute',
                display: 'none'
            };
            townInfo.css(styles);

            $('body').append(townInfo);
        }

        $('#town_info').css('display', 'block');
        var content =
            '<img src="' + appdir + 'assets/images/icons/flag-' + $(this).attr('rel') + '.png"> ' + $(this).attr('alt');
        $('#town_info').html(content);
    });

    $(document).on('mouseout', 'area', function () {
        $('#town_info').css('display', 'none');
    });

    $(document).on('click', 'area', function () {
        $('#town_info').css('display', 'none');
    });

    $(document).on('mousemove', 'area', function (e) {
        var x = e.pageX + 10 + 'px';
        var y = e.pageY + 10 + 'px';

        $('#town_info').css('top', y);
        $('#town_info').css('left', x);
    });

    setTimeout(createSliders, 100);
};

window.runOcean = runOcean;
