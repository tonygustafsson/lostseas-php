<section id="chat_users">
	<? foreach ($online_users as $this_user): ?>
		<p>
			<? if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg')): ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/' . $this_user['id'] . '_thumb.jpg'?>" alt="<?php echo $this_user['name']?>">
			<? else: ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/nopic_thumb.jpg'?>" alt="<?php echo $this_user['name']?>">
			<? endif; ?>
			<span><?php echo $this_user['name']?></span>
		</p>
	<? endforeach; ?>
</section>

<article id="chat">
	<? foreach ($chat as $row): ?>
		<div class="entry">
			<div style="float: left; min-width: 50px;">
			<? if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg')): ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/' . $row['user_id'] . '_thumb.jpg'?>" alt="<?php echo $row['name']?>">
			<? else: ?>
				<img src="<?php echo APPPATH . '../assets/images/profile_pictures/nopic_thumb.jpg'?>" alt="<?php echo $row['name']?>">
			<? endif; ?>
			</div>
			
			<div style="float: left; clear: right; width: 90%">
				<span class="timestamp">[<?php echo substr($row['time'], 0, -3)?>] <?php echo $row['name']?>:</span> <?php echo $row['entry']?>
			</div>
		</div>
	<? endforeach; ?>
</article>