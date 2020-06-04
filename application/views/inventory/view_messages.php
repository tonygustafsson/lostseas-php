<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Crew">
		<h3>Inventory: Messages</h3>
	</header>
<?php else: ?>
	<header title="About <?=$player['user']['name']?>">
	<h3>About <?=$player['user']['name']?>: Messages</h3>
	</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML" title="Learn more about <?=$player['user']['name']?>" href="inventory/player/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s ships" href="inventory/ships/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s crew members" href="inventory/crew/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?=$player['game']['character_name']?>s history" href="inventory/history/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?=$player['game']['character_name']?>s log book" href="inventory/log/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Say something to <?=$player['user']['name']?>" href="inventory/messages/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<?php if ($player['user']['id'] != $this->data['user']['id']): ?>
	<form method="post" class="ajaxJSON" id="write_form" action="<?=base_url('inventory/messages_post/' . $player['user']['id'])?>">
		<fieldset>
			<legend>New message</legend>
			<textarea id="input_message" name="message"></textarea>
			<input type="submit" value="Send">
		</fieldset>
	</form>
<?php endif; ?>

<p class="center"><?=$pages?></p>

<section id="messages_area">
	<?php if (count($messages) > 0): ?>
		<?php foreach ($messages as $key => $row): ?>
			<section id="entry-<?=$row['id']?>">
				<h4><?=$row['name']?> at <?=$row['time']?></h4>
				<p style="margin-top: 0;"><?=$row['entry']?></p>
				<p>
					<?php if ($user['verified'] == 1 && $user['id'] !== $row['writer_id']): ?>
						<a href="inventory/messages/<?=$row['writer_id']?>" title="Answer this post"><img src="<?=base_url()?>assets/images/icons/answer.png" alt="Answer" width="16" height="16"></a>
					<?php endif; ?>
					<?php if ($user['id'] === $row['writer_id'] || $user['id'] === $row['user_id']): ?>
						<a class="ajaxJSON" rel="Are you sure you wan't do delete this message?" href="<?=base_url('inventory/message_remove/' . $this->data['player']['user']['id'] . '/' . $row['id'])?>" title="Erase this post">
							<img src="<?=base_url('assets/images/icons/erase.png')?>" alt="Erase" width="16" height="16">
						</a>
					<?php endif; ?>
				</p>
			</section>
		<?php endforeach; ?>
	<?php else: ?>
		<p>No messages yet...</p>
	<?php endif; ?>
</section>