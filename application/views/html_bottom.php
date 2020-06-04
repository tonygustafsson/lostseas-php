		</article>

		<?php
            if (isset($user)) {
                // Logged in user
                include('partials/inventory_panel.php');
            } else {
                include('partials/login_panel.php');
                include('partials/log_panel.php');
            }
        ?>

		<footer>
			<p><a href="about/copyright" class="ajaxHTML"><?php echo $this->config->item('site_name')?>
					&copy;<?php echo date("Y")?></a>
			</p>
		</footer>

		<?php
            if (isset($user)) {
                include('partials/sound_controls_dialog.php');
            }
        ?>

		</div>

		<?php include('./assets/images/icon-map.svg') ?>

		<script type="text/javascript"
			src="<?php echo base_url('assets/js/styles.js?202005171562')?>">
		</script>
		<script type="text/javascript"
			src="<?php echo base_url('assets/js/main.js?202005171562')?>">
		</script>

		</body>

		</html>