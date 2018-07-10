<div style="width: 100%; padding-bottom: 1em;">
	<button type="button" class="gender_select_button" data-gender="M" data-url="<?php echo base_url('account/avatar_selector/male')?>">Male</button>
	<button type="button" class="gender_select_button" data-gender="F" data-url="<?php echo base_url('account/avatar_selector/female')?>">Female</button>
</div>

<? for ($x = 1; $x <= $number_of_avatars; $x++): ?>
	<a href="#" class="select_avatar_link" style="text-decoration: none" data-gender="<?php echo $gender?>" data-character="<?php echo $x?>" data-imagebasepath="<?php echo APPPATH . '../assets/images/avatars/' . $gender . '/'?>">
		<img src="<?php echo APPPATH . '../assets/images/avatars/' . $gender . '/avatar_' . $x . '.jpg'?>" alt="Avatar <?php echo $x?>" style="margin-left: 0.5em; border: 1px black solid; border-radius: 4px;" width="120" height="120">
	</a>
<?php endfor; ?>