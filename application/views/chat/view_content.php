<section id="chat_users">
	<?php foreach ($online_users as $this_user): ?>
		<p>
			<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg')): ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg'?>" alt="<?php echo $this_user['name']?>">
			<?php else: ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/nopic_thumb.jpg'?>" alt="<?php echo $this_user['name']?>">
			<?php endif; ?>
			<span><?php echo $this_user['name']?></span>
		</p>
	<?php endforeach; ?>
</section>

<article id="chat">
	<?php foreach ($chat as $row): ?>
		<div class="entry">
			<div style="float: left; min-width: 50px;">
			<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg')): ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg'?>" alt="<?php echo $row['name']?>">
			<?php else: ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/nopic_thumb.jpg'?>" alt="<?php echo $row['name']?>">
			<?php endif; ?>
			</div>
			
			<div style="float: left; clear: right; width: 90%">
				<span class="timestamp">[<?php echo substr($row['time'], 0, -3)?>] <?php echo $row['name']?>:</span> <?php echo $row['entry']?>
			</div>
		</div>
	<?php endforeach; ?>
</article>