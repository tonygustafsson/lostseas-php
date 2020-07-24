<div class="avatar-selector">
	<div style="width: 100%; padding: 1em 0;">
		The avatars available depends on the gender of your character.
	</div>

	<?php for ($x = 1; $x <= $number_of_avatars; $x++): ?>
	<a href="#" class="avatar-selector-item" style="text-decoration: none"
		data-gender="<?=$gender?>"
		data-character="<?=$x?>"
		data-imagebasepath="<?=base_url('/assets/images/avatars/' . $gender . '/')?>">
		<img loading="lazy"
			src="<?=base_url('assets/images/avatars/' . $gender . '/avatar_' . $x . '.png')?>"
			alt="Avatar <?=$x?>" width="100" height="100">
	</a>
	<?php endfor; ?>
</div>