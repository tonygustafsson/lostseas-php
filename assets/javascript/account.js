"use strict";

$(document).on('change', '#profile_picture_select', function() {
	var imageToUpload = document.getElementById('profile_picture_select').files[0];

	if (imageToUpload.type == "image/jpeg")	{
		var image = document.createElement("img");
		var thumbnail = document.getElementById("image_preview");
		image.file = imageToUpload;
		image.width = 120;
		image.height = 120;
		thumbnail.innerHTML = "";
		thumbnail.appendChild(image);
		thumbnail.style.display = "block";
		
		var reader = new FileReader();
		
		reader.onload = (function(aImg) {
			return function(e){
				aImg.src = e.target.result;
			};
		}(image));
		
		var ret = reader.readAsDataURL(imageToUpload);
		var canvas = document.createElement("canvas");
		var ctx = canvas.getContext("2d");
		image.onload= function() {
			ctx.drawImage(image, 120, 120);
		}
	}
});

$(document).on('submit', '#profile_picture_form', function() {
	var imageToUpload = document.getElementById('profile_picture_select').files[0];
	var data = {};
	
	if (imageToUpload.type != "image/jpeg") {
		data.error = 'You can only upload JPEG images.';
		gameManipulateDOM(data);
	}
	else if (imageToUpload.size > 1000000) {
		data.error = 'The image cannot be larger than 1 MB.';
		gameManipulateDOM(data);
	}
	else {
		$.ajax({
			type: 'POST',
			dataType: "json",
			data: imageToUpload,
			url: $(this).attr('action'),
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				console.log(data);
				gameManipulateDOM(data);
			}
		});
	}
	
	return false;
});

$(document).on('click', '#change_avatar_button', function() {
	var url = $('#avatar_selector_div').data('url');
	
	$('#avatar_selector_div').dialog({
		autoOpen: false,
		height: 500,
		width: 600
	});
	
	$('#avatar_selector_div').load(url).dialog('open');
	
	return false;
});

$(document).on('click', 'a.select_avatar_link', function() {
	var gender = $(this).data('gender');
	var shortGender = (gender == 'male') ? 'M' : 'F';

	var imageBasePath = $(this).data('imagebasepath');
	var selectedAvatar = $(this).data('character');

	var imagePath = imageBasePath + 'avatar_' + selectedAvatar + '.jpg';
	
	$('#current_avatar_img').attr('src', imagePath);
	$('#character_avatar').val(gender + '###' + selectedAvatar);
	$('#character_gender').val(shortGender);
	
	$('#avatar_selector_div').dialog("close");
	
	return false;
});

$(document).on('click', 'button.gender_select_button', function() {
	var url = $(this).data('url');
	
	$('#avatar_selector_div').load(url);
});