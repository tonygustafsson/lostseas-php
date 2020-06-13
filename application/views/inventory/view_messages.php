<div class="container">
	<?php if ($user['id'] == $player['user']['id']): ?>
	<h3>Inventory: Messages</h3>
	<?php else: ?>
	<h3>About <?=$player['user']['name']?>:
		Messages</h3>
	<?php endif; ?>

	<div class="button-area">
		<a class="ajaxHTML button big-icon"
			title="Learn more about <?=$player['user']['name']?>"
			href="inventory/player/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Player">
				<use xlink:href="#player"></use>
			</svg>
			Player
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s ships"
			href="inventory/ships/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Ships">
				<use xlink:href="#ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s crew members"
			href="inventory/crew/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Crew members">
				<use xlink:href="#crew-man"></use>
			</svg>
			Crew
		</a>
		<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML button big-icon"
			title="See graphs and data about <?=$player['game']['character_name']?>s history"
			href="inventory/history/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="History">
				<use xlink:href="#clock"></use>
			</svg>
			History
		</a>
		<a class="ajaxHTML button big-icon"
			title="Check out <?=$player['game']['character_name']?>s log book"
			href="inventory/log/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Log book">
				<use xlink:href="#logbook"></use>
			</svg>
			Log book
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon"
			title="Say something to <?=$player['user']['name']?>"
			href="inventory/messages/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Messages">
				<use xlink:href="#message"></use>
			</svg>
			Messages
		</a>
	</div>

	<?php if ($player['user']['id'] != $this->data['user']['id']): ?>
	<form method="post" class="ajaxJSON" id="write_form"
		action="<?=base_url('inventory/messages_post/' . $player['user']['id'])?>">
		<fieldset>
			<legend>New message</legend>
			<textarea id="input_message" name="message"></textarea>
			<button type="submit">Send</button>
		</fieldset>
	</form>
	<?php endif; ?>

	<p class="text-center">
		<?=$pages?>
	</p>

	<section id="messages_area">
		<?php if (count($messages) > 0): ?>
		<?php foreach ($messages as $key => $row): ?>
		<section id="entry-<?=$row['id']?>">
			<p><strong><?=$row['name']?> at
					<?=$row['time']?></strong>
			</p>
			<p style="margin-top: 0;"><?=$row['entry']?>
			</p>
			<p>
				<?php if ($user['verified'] == 1 && $user['id'] !== $row['writer_id']): ?>
				<a href="inventory/messages/<?=$row['writer_id']?>"
					title="Answer this post">
					<svg width="16" height="16" alt="Answer">
						<use xlink:href="#message"></use>
					</svg>
				</a>
				<?php endif; ?>
				<?php if ($user['id'] === $row['writer_id'] || $user['id'] === $row['user_id']): ?>
				<a class="ajaxJSON" rel="Are you sure you wan't do delete this message?"
					href="<?=base_url('inventory/message_remove/' . $this->data['player']['user']['id'] . '/' . $row['id'])?>"
					title="Erase this post">
					<svg width="16" height="16" class="Remove">
						<use xlink:href="#trashcan"></use>
					</svg>
				</a>
				<?php endif; ?>
			</p>
		</section>
		<?php endforeach; ?>
		<?php else: ?>
		<p>No messages yet...</p>
		<?php endif; ?>
	</section>
</div>