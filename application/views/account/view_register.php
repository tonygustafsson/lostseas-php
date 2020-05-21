<header title="Register">
	<h3>Register</h3>
</header>

<?php if ($user['email'] != ""): ?>
	<div class="info">
		<p>
			You have already registered with the email address <?php echo $user['email']?>, you have to verify your
			account by clicking the link on the email that was sent from us. You can change your email by
			registering again.
		</p>
	</div>
<?php endif; ?>

<p>To be able to save this game you have to register. You will recieve an email verification, when you
have done so, you will be a registered member. You can continue playing while you wait if you want to.</p>

<form id="settings" class="ajaxJSON" method="post" action="<?php echo base_url('account/register_post')?>">

	<fieldset>
		<legend>Account settings</legend>
		
		<div id="msg"></div>
		
		<label for="name">Email address</label>
		<input type="email" name="email">
		
		<label for="password">Desired password</label>
		<input type="password" name="password">
		
		<label for="repeated_password">Repeat password</label>
		<input type="password" name="repeated_password">
		
		<label for="name">Full name</label>
		<input type="text" name="name">
		
		<label for="gender">Gender</label>
		<p>
			Male: <input type="radio" name="gender" value="M" checked>
			Female: <input type="radio" name="gender" value="F">
		</p>
		
		<label for="day, month, year">Birthday</label>
		<select name="day">
			<?php for ($x = 1; $x <= 31; $x++): ?>
				<option value="<?php echo $x?>"><?php echo $x?></option>
			<?php endfor; ?>
		</select>
		
		<select name="month">
			<?php foreach ($months as $number => $month): ?>
				<option value="<?php echo $number?>"><?php echo $month?></option>
			<?php endforeach; ?>
		</select>
		
		<select name="year">
			<?php for ($x = 1930; $x <= 2010; $x++): ?>
				<option value="<?php echo $x?>"<?php echo ($x == 1985) ? 'selected' : ''?>><?php echo $x?></option>
			<?php endfor; ?>
		</select>
		
		<label for="presentation">Presentation</label>
		<textarea name="presentation"></textarea>
		
		<br><input type="submit" value="Register">
	</fieldset>

</form>