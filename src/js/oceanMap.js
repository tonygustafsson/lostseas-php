const base = document.getElementsByTagName('base')[0];
const appdir = base.href;

const createTownInfo = (element) => {
    const lang = element.rel;
    const areaText = element.alt;

    const townInfo = document.createElement('div');
    townInfo.id = 'town_info';
    townInfo.classList.add('town-info');

    const flag = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    flag.style.width = '24px';
    flag.style.height = '12px';
    const flagUse = document.createElementNS('http://www.w3.org/2000/svg', 'use');
    flagUse.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', `#flag-${lang}`);
    flag.appendChild(flagUse);

    const info = document.createElement('span');
    info.innerText = areaText;

    townInfo.appendChild(flag);
    townInfo.appendChild(info);

    return townInfo;
};

const areaMouseOver = (e) => {
    const element = e.target;
    const body = document.getElementById('body');
    const townInfo = createTownInfo(element);

    body.appendChild(townInfo);
};

const areaMouseOut = () => {
    const townInfo = document.getElementById('town_info');

    townInfo.remove();
};

const areaMouseMove = (e) => {
    const townInfo = document.getElementById('town_info');

    const x = e.pageX + 10 + 'px';
    const y = e.pageY + 10 + 'px';

    townInfo.style.top = y;
    townInfo.style.left = x;
};

const areaClick = () => {
    const townInfo = document.getElementById('town_info');

    townInfo.remove();
};

const createAreaTriggers = () => {
    const areas = Array.from(document.querySelectorAll('area'));

    areas.forEach((area) => {
        area.addEventListener('mousemove', areaMouseMove);
        area.addEventListener('mouseover', areaMouseOver);
        area.addEventListener('mouseout', areaMouseOut);
        area.addEventListener('click', areaClick);
    });
};

window.addEventListener('ocean-battle-transfer-done', createAreaTriggers);
window.addEventListener('ocean', createAreaTriggers);
window.addEventListener('ocean-ignore', createAreaTriggers);
