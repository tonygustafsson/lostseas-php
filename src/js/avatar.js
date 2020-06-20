import axios from 'axios';
import dialog from './components/dialog.js';
import snackbar from './components/snackbar';

const selectAvatar = (e) => {
    e.preventDefault();

    const item = e.target.closest('a');
    const currentAvatarImgEl = document.getElementById('current_avatar_img');
    const characterAvatarEl = document.getElementById('character_avatar');
    const characterGenderEl = document.getElementById('character_gender');

    const gender = item.dataset.gender;
    const shortGender = gender == 'male' ? 'M' : 'F';

    const imageBasePath = item.dataset.imagebasepath;
    const selectedAvatar = item.dataset.character;

    const imagePath = imageBasePath + 'avatar_' + selectedAvatar + '.png';

    currentAvatarImgEl.src = imagePath;
    characterAvatarEl.value = gender + '###' + selectedAvatar;
    characterGenderEl.value = shortGender;
};

const loadAvatars = (url) => {
    const avatarSelectorDialog = document.getElementById('js-start-avatar-selector-dialog');
    url = url ? url : avatarSelectorDialog.dataset.url;

    axios({
        method: 'get',
        url: url
    })
        .then((response) => {
            const selectorWrapperEl = document.querySelector('.avatar-selector-wrapper');
            selectorWrapperEl.innerHTML = response.data.content;

            const selectGendersEls = Array.from(document.querySelectorAll('.avatar-selector-change-gender'));

            selectGendersEls.forEach((item) => {
                let changeAvatarUrl = item.dataset.url;
                item.addEventListener('click', () => loadAvatars(changeAvatarUrl));
            });

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
};

window.addEventListener('about-presentation', initAvatarDialog);
window.addEventListener('about-news', initAvatarDialog);
window.addEventListener('about-guide', initAvatarDialog);
window.addEventListener('account-password_forgotten', initAvatarDialog);
window.addEventListener('account-settings_character', initAvatarDialog);
