<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Tony Gustafsson">
	<meta name="description" content="A web based, pirate influenced game for free!">
	<meta name="keywords" content="online game, web game, pirate game, html5 game, ajax game, pirates gold, caribbean sea, spanish main">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	
	<base href="<?php echo base_url()?>">

	<link rel="stylesheet" href="<?php echo base_url('assets/stylesheets/screen.css?201810172201')?>" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url('assets/stylesheets/chat.css?201810172201')?>" type="text/css" media="all">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>/assets/images/icons/favicon.ico">

	<?php if (strpos(base_url(), 'test') === FALSE): ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-40457155-1', 'lostseas.com');
			ga('send', 'pageview');
		</script>
	<?php endif; ?>
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/javascript/main.js?201309081542')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/javascript/chat.js?201309081542')?>"></script>
	
	<title>Chat - <?php echo $this->config->item('site_name')?></title>
</head>

<body class="chat">

<section id="dynamic_chat">

</section>

<section id="chat_input">
	<form id="chat_form" method="post" action="<?php echo base_url('chat/post_chat')?>">
		<input type="text" id="entry" name="entry" autocomplete="off">
		<input class="small" type="submit" value="Talk">
	</form>
</section>

</body>
</html>