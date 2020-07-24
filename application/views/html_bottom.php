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

		<?php
            if (isset($user)) {
                include('partials/sound_controls_dialog.php');
            }
        ?>

		</div>

		<?php include('./assets/images/icon-map.svg') ?>

		<script
			src="<?=base_url('assets/js/main.js?202005171562')?>">
		</script>

		</body>

		</html>