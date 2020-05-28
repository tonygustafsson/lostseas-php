import axios from 'axios';
import snackbar from './components/snackbar';
import manipulateDom from './manipulateDom';

$(document).on('change', '#profile_picture_select', function () {
    var imageToUpload = document.getElementById('profile_picture_select').files[0];

    if (imageToUpload.type == 'image/jpeg') {
        var image = document.createElement('img');
        var thumbnail = document.getElementById('image_preview');
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
    }
});

$(document).on('submit', '#profile_picture_form', function () {
    var imageToUpload = document.getElementById('profile_picture_select').files[0];
    var data = {};

    if (imageToUpload.type != 'image/jpeg') {
        snackbar({ text: 'You can only upload JPEG images.', level: 'error' });
    } else if (imageToUpload.size > 1000000) {
        snackbar({ text: 'The image cannot be larger than 1 MB.', level: 'error' });
    } else {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: imageToUpload,
            url: $(this).attr('action'),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                manipulateDom(data);
            }
        });
    }

    return false;
});
