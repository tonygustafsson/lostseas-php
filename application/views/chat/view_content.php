<div id="chat_users" class="chat-users">
	<?php foreach ($online_users as $this_user): ?>
		<div>
			<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg')): ?>
				<img src="<?php echo base_url('/assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg')?>" alt="<?php echo $this_user['name']?>">
			<?php else: ?>
				<img src="<?php echo base_url('/assets/images/profile_pictures/nopic_thumb.jpg')?>" alt="<?php echo $this_user['name']?>">
			<?php endif; ?>
			<span><?php echo $this_user['name']?></span>
		</div>
	<?php endforeach; ?>
</div>

<div id="chat_content" class="chat-content">
	<?php foreach ($chat as $row): ?>
		<div class="chat-entry">
			<div style="float: left; min-width: 50px;">
				<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg')): ?>
					<img src="<?php echo base_url('/assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg')?>" alt="<?php echo $row['name']?>">
				<?php else: ?>
					<img src="<?php echo base_url('/assets/images/profile_pictures/nopic_thumb.jpg')?>" alt="<?php echo $row['name']?>">
				<?php endif; ?>
			</div>
			
			<div style="float: left; clear: right; width: 90%">
				<span class="timestamp">[<?php echo substr($row['time'], 0, -3)?>] <?php echo $row['name']?>:</span> <?php echo $row['entry']?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
