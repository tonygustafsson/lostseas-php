<header title="Chat">
	<h3>Chat</h3>
</header>

<div class="chat-wrapper">
	<section id="dynamic_chat" class="chat"></section>

	<section id="chat_input">
		<form id="chat_form" method="post" action="<?=base_url('chat/post_chat')?>">
			<input type="text" id="entry" name="entry" autocomplete="off">
			<input class="small" type="submit" value="Speak">
		</form>
	</section>
</div>