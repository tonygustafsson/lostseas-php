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

    const image = document.createElement('img');
    const thumbnail = document.getElementById('image_preview');

    image.file = imageToUpload;
    image.width = 120;
    image.height = 120;
    thumbnail.innerHTML = '';
    thumbnail.appendChild(image);
    thumbnail.style.display = 'block';

    var reader = new FileReader();

    reader.onload = (function (aImg) {
        return function (e) {
            aImg.src = e.target.result;
        };
    })(image);

    var ret = reader.readAsDataURL(imageToUpload);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    image.onload = function () {
        ctx.drawImage(image, 120, 120);
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

    const formData = new FormData();
    formData.append('profile_picture_select', imageToUpload);

    axios({
        method: 'post',
        responseType: 'json',
        data: formData,
        url: form.action,
        headers: {
            'Content-Type': 'multipart/form-data'
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

window.addEventListener('account-settings_account', () => {
    initProfilePictureSelector();
});
