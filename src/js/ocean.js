const base = document.getElementsByTagName('base')[0];
const appdir = base.href;

const areaMouseOver = (e) => {
    const $element = $(e.target);

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
        '<img src="' + appdir + 'assets/images/icons/flag-' + $element.attr('rel') + '.png"> ' + $element.attr('alt');
    $('#town_info').html(content);
};

const areaMouseOut = () => {
    $('#town_info').css('display', 'none');
};

const areaMouseMove = (e) => {
    var x = e.pageX + 10 + 'px';
    var y = e.pageY + 10 + 'px';

    $('#town_info').css('top', y);
    $('#town_info').css('left', x);
};

const areaClick = () => {
    $('#town_info').css('display', 'none');
};

window.addEventListener('ocean', () => {
    $(document).off('mouseover', 'area').on('mouseover', 'area', areaMouseOver);
    $(document).off('mouseout', 'area').on('mouseout', 'area', areaMouseOut);
    $(document).off('click', 'area').on('click', 'area', areaClick);
    $(document).off('mousemove', 'area').on('mousemove', 'area', areaMouseMove);
});
