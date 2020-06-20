<div class="avatar-selector">
	<div style="width: 100%; padding-bottom: 1em;">
		<button type="button" class="avatar-selector-change-gender" data-gender="M"
			data-url="<?=base_url('account/avatar_selector/male')?>">Male</button>
		<button type="button" class="avatar-selector-change-gender" data-gender="F"
			data-url="<?=base_url('account/avatar_selector/female')?>">Female</button>
	</div>

	<?php for ($x = 1; $x <= $number_of_avatars; $x++): ?>
	<a href="#" class="avatar-selector-item" style="text-decoration: none"
		data-gender="<?=$gender?>"
		data-character="<?=$x?>"
		data-imagebasepath="<?=base_url('/assets/images/avatars/' . $gender . '/')?>">
		<img loading="lazy"
			src="<?='assets/images/avatars/' . $gender . '/avatar_' . $x . '.png'?>"
			alt="Avatar <?=$x?>" width="100" height="100">
	</a>
	<?php endfor; ?>
</div>