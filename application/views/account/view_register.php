<header class="area-header" class="area-header" title="Register">
	<h3>Register</h3>
</header>

<?php if ($user['email'] != ""): ?>
<div class="info">
	<p>
		You have already registered with the email address <?=$user['email']?>, you have to verify your
		account by clicking the link on the email that was sent from us. You can change your email by
		registering again.
	</p>
</div>
<?php endif; ?>

<p>To be able to save this game you have to register. You will recieve an email verification, when you
	have done so, you will be a registered member. You can continue playing while you wait if you want to.</p>

<form id="settings" class="ajaxJSON" method="post"
	action="<?=base_url('account/register_post')?>">
	<fieldset>
		<legend>Account settings</legend>

		<label for="email">Email address</label>
		<input type="email" name="email" id="email" />

		<label for="password">Desired password</label>
		<input type="password" name="password" id="password" />

		<label for="repeated_password">Repeat password</label>
		<input type="password" name="repeated_password" id="repeated_password" />

		<label for="name">Full name</label>
		<input type="text" name="name" id="name" />

		<input type="radio" name="gender" value="M" id="male" checked /> <label for="male">Male</label><br />
		<input type="radio" name="gender" value="F" id="female" /> <label for="female">Female</label>

		<label for="day, month, year">Birthday</label>
		<select name="day">
			<?php for ($x = 1; $x <= 31; $x++): ?>
			<option value="<?=$x?>"><?=$x?>
			</option>
			<?php endfor; ?>
		</select>

		<select name="month">
			<?php foreach ($months as $number => $month): ?>
			<option value="<?=$number?>"><?=$month?>
			</option>
			<?php endforeach; ?>
		</select>

		<select name="year">
			<?php for ($x = 1930; $x <= 2010; $x++): ?>
			<option value="<?=$x?>" <?=($x == 1985) ? 'selected' : ''?>><?=$x?>
			</option>
			<?php endfor; ?>
		</select>

		<label for="presentation">Presentation</label>
		<textarea name="presentation"></textarea>

		<br><input type="submit" value="Register">
	</fieldset>

</form>