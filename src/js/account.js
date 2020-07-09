import axios from 'axios';
import snackbar from './components/snackbar';
import manipulateDom from './manipulateDom';

const changeProfilePic = (e) => {
    const selectEl = e.target;
    var imageToUpload = selectEl.files[0];

    if (imageToUpload.type !== 'image/jpeg') {
        snackbar({ text: 'You must choose a JPEG image', level: 'error' });
        return;
    }

    const newImg = document.createElement('img');
    const thumbnail = document.getElementById('image_preview');

    newImg.file = imageToUpload;
    newImg.width = 120;
    newImg.height = 120;
    thumbnail.innerHTML = '';
    thumbnail.appendChild(newImg);

    var reader = new FileReader();

    reader.onload = (function (aImg) {
        return function (e) {
            aImg.src = e.target.result;
        };
    })(newImg);

    var ret = reader.readAsDataURL(imageToUpload);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    newImg.onload = function () {
        ctx.drawImage(newImg, 120, 120);
    };
};

const uploadProfilePic = (e) => {
    e.preventDefault();

    const form = e.target;
    const imageToUpload = document.getElementById('profile_picture_select').files[0];

    if (imageToUpload.type !== 'image/jpeg') {
        snackbar({ text: 'You can only upload JPEG images.', level: 'error' });
        return;
    }

    if (imageToUpload.size > 1000000) {
        snackbar({ text: 'The image cannot be larger than 1 MB.', level: 'error' });
        return;
    }

    axios({
        method: 'PUT',
        responseType: 'json',
        data: imageToUpload,
        url: form.action,
        headers: {
            'Content-Type': imageToUpload.type
        }
    })
        .then((response) => {
            manipulateDom(response.data.manipulateDom);
        })
        .catch((err) => {
            snackbar({ text: `Could not upload image. ${err.toString()}`, level: 'error' });
        });
};

const initProfilePictureSelector = () => {
    const profilePicSelectEl = document.getElementById('profile_picture_select');

    profilePicSelectEl.addEventListener('change', changeProfilePic);

    const profilePicFormEl = document.getElementById('profile_picture_form');

    profilePicFormEl.addEventListener('submit', uploadProfilePic);
};

window.addEventListener('settings-account', () => {
    initProfilePictureSelector();
});
