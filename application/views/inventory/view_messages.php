<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<? endif; ?>

<? if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Crew">
		<h3>Inventory: Messages</h3>
	</header>
<? else: ?>
	<header title="About <?php echo $player['user']['name']?>">
	<h3>About <?php echo $player['user']['name']?>: Messages</h3>
	</header>
<? endif; ?>

<section class="actions">
	<a class="ajaxHTML" title="Learn more about <?php echo $player['user']['name']?>" href="inventory/player/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s ships" href="inventory/ships/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s crew members" href="inventory/crew/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<? if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?php echo $player['game']['character_name']?>s history" href="inventory/history/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?php echo $player['game']['character_name']?>s log book" href="inventory/log/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<? endif; ?>
	<a class="ajaxHTML" title="Say something to <?php echo $player['user']['name']?>" href="inventory/messages/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<div id="msg"></div>

<? if ($player['user']['id'] != $this->user['user']['id']): ?>
	<form method="post" class="ajaxJSON" id="write_form" action="<?php echo base_url('inventory/messages_post/' . $player['user']['id'])?>">
		<fieldset>
			<legend>New message</legend>
			<textarea id="input_message" name="message"></textarea>
			<input type="submit" value="Send">
		</fieldset>
	</form>
<? endif; ?>

<p class="center"><?php echo $pages?></p>

<section id="messages_area">
	<? if (count($messages) > 0): ?>
		<? foreach ($messages as $key => $row): ?>
			<section id="entry-<?php echo $row['id']?>">
				<h4><?php echo $row['name']?> at <?php echo $row['time']?></h4>
				<p style="margin-top: 0;"><?php echo $row['entry']?></p>
				<p>
					<? if ($user['verified'] == 1 && $user['id'] !== $row['writer_id']): ?>
						<a href="inventory/messages/<?php echo $row['writer_id']?>" title="Answer this post"><img src="<?echo base_url()?>assets/images/icons/answer.png" alt="Answer" width="16" height="16"></a>
					<? endif; ?>
					<? if ($user['id'] === $row['writer_id'] || $user['id'] === $row['user_id']): ?>
						<a class="ajaxJSON" rel="Are you sure you wan't do delete this message?" href="<?php echo base_url('inventory/message_remove/' . $this->user['player']['user']['id'] . '/' . $row['id'])?>" title="Erase this post">
							<img src="<?echo base_url('assets/images/icons/erase.png')?>" alt="Erase" width="16" height="16">
						</a>
					<? endif; ?>
				</p>
			</section>
		<? endforeach; ?>
	<? else: ?>
		<p>No messages yet...</p>
	<? endif; ?>
</section>