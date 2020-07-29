import axios from 'axios';
import dialog from './components/dialog.js';
import snackbar from './components/snackbar';

const selectAvatar = (e) => {
    e.preventDefault();

    const item = e.target.closest('a');
    const currentAvatarImgEl = document.getElementById('current_avatar_img');
    const characterAvatarEl = document.getElementById('character_avatar');

    const imageBasePath = item.dataset.imagebasepath;
    const selectedAvatar = item.dataset.character;

    const imagePath = imageBasePath + 'avatar_' + selectedAvatar + '.png';

    currentAvatarImgEl.src = imagePath;
    characterAvatarEl.value = selectedAvatar;
};

const loadAvatars = () => {
    const avatarSelectorDialog = document.getElementById('js-start-avatar-selector-dialog');
    const genderEls = Array.from(document.getElementsByName('character_gender'));
    const genderValue = genderEls.find((x) => x.checked).value;
    const gender = genderValue === 'M' ? 'male' : 'female';
    const url = `${avatarSelectorDialog.dataset.baseUrl}/${gender}`;

    axios({
        method: 'get',
        url: url
    })
        .then((response) => {
            const selectorWrapperEl = document.querySelector('.avatar-selector-wrapper');
            selectorWrapperEl.innerHTML = response.data.content;

            const avatarItemsEls = Array.from(document.querySelectorAll('.avatar-selector-item'));

            avatarItemsEls.forEach((item) => {
                item.addEventListener('click', selectAvatar);
            });
        })
        .catch((err) => {
            snackbar({ text: `Could not fetch avatars. ${err.toString()}`, level: 'error' });
        });
};

const initAvatarDialog = () => {
    dialog({
        dialogElementId: 'js-start-avatar-selector-dialog',
        dialogTriggerElementId: 'js-start-avatar-selector-trigger',
        onLoad: loadAvatars
    });

    const genderSelectorEls = Array.from(document.getElementsByName('character_gender'));

    genderSelectorEls.forEach((selector) => {
        selector.addEventListener('change', (e) => {
            const avatarSelectorDialog = document.getElementById('js-start-avatar-selector-dialog');
            const currentImage = document.getElementById('current_avatar_img');
            const hiddenInput = document.getElementById('character_avatar');

            const imgBaseUrl = avatarSelectorDialog.dataset.imgBaseUrl;
            const gender = e.target.value === 'M' ? 'male' : 'female';
            const randomNumber = Math.floor(Math.random() * 40) + 1;
            const randomImage = `${imgBaseUrl}/${gender}/avatar_${randomNumber}.png`;

            hiddenInput.value = randomNumber;
            currentImage.src = randomImage;
        });
    });
};

window.addEventListener('about-presentation', initAvatarDialog);
window.addEventListener('settings-character', initAvatarDialog);
