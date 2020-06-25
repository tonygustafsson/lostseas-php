const base = document.getElementsByTagName('base')[0];
const appdir = base.href;

const createTownInfo = (element) => {
    const lang = element.attributes.rel.value;
    const townText = element.attributes.alt.value;

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
    info.innerText = townText;

    townInfo.appendChild(flag);
    townInfo.appendChild(info);

    return townInfo;
};

const linkMouseOver = (e) => {
    const element = e.target;
    const body = document.getElementById('body');
    const townInfo = createTownInfo(element);

    body.appendChild(townInfo);
};

const linkMouseOut = () => {
    const townInfo = document.getElementById('town_info');

    if (townInfo) {
        townInfo.remove();
    }
};

const linkMouseMove = (e) => {
    const townInfo = document.getElementById('town_info');

    if (!townInfo) {
        return;
    }

    const x = e.pageX + 10 + 'px';
    const y = e.pageY + 10 + 'px';

    townInfo.style.top = y;
    townInfo.style.left = x;
};

const linkClick = () => {
    const townInfo = document.getElementById('town_info');

    townInfo.remove();
};

const townImageZoomIn = (image) => {
    const width = image.width.baseVal.value;
    const height = image.height.baseVal.value;
    const x = image.x.baseVal.value;
    const y = image.y.baseVal.value;

    image.style.width = width * 1.2;
    image.style.height = height * 1.2;
    image.style.x = x - width * 0.1;
    image.style.y = y - height * 0.1;
};

const townImageZoomOut = (image) => {
    const width = image.width.baseVal.value;
    const height = image.height.baseVal.value;
    const x = image.x.baseVal.value;
    const y = image.y.baseVal.value;

    image.style.width = width;
    image.style.height = height;
    image.style.x = x;
    image.style.y = y;
};

const townLinkMouseOver = (e) => {
    const image = e.target;
    townImageZoomIn(image);
};

const townLinkMouseOut = (e) => {
    const image = e.target;
    townImageZoomOut(image);
};

const townLinkFocusIn = (e) => {
    const link = e.target;
    const town = link.dataset.focusTown;
    const correspondingImage = document.getElementById(town);
    townImageZoomIn(correspondingImage);
};

const townLinkFocusOut = (e) => {
    const link = e.target;
    const town = link.dataset.focusTown;
    const correspondingImage = document.getElementById(town);
    townImageZoomOut(correspondingImage);
};

const createLinkTriggers = () => {
    const targets = Array.from(document.querySelectorAll('.js-town'));

    console.log('triggers', targets);

    targets.forEach((target) => {
        target.addEventListener('mousemove', linkMouseMove);
        target.addEventListener('mouseover', linkMouseOver);
        target.addEventListener('touchstart', linkMouseOver);
        target.addEventListener('mouseout', linkMouseOut);
        target.addEventListener('click', linkClick);
    });

    const townLinks = Array.from(document.querySelectorAll('.ocean-map__town-link'));

    townLinks.forEach((town) => {
        town.addEventListener('mouseover', townLinkMouseOver);
        town.addEventListener('mouseout', townLinkMouseOut);
    });

    const townLinksFocusesEls = Array.from(document.querySelectorAll('.js-town-focus'));

    townLinksFocusesEls.forEach((link) => {
        link.addEventListener('mouseover', townLinkFocusIn);
        link.addEventListener('mouseout', townLinkFocusOut);
    });
};

window.addEventListener('ocean-battle-transfer-done', createLinkTriggers);
window.addEventListener('ocean-ignore', createLinkTriggers);
window.addEventListener('ocean-flee', createLinkTriggers);
window.addEventListener('ocean-trade', createLinkTriggers);
window.addEventListener('ocean-trade-done', createLinkTriggers);
window.addEventListener('ocean', createLinkTriggers);
