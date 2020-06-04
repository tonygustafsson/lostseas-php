<div class="header-panel">
    <header>
        <h1><a title="Go back to start page"
                href="<?php echo base_url()?>"><?php echo $this->config->item('site_name')?></a>
        </h1>
    </header>

    <?php if (isset($user)): ?>
    <a id="nav_top_button" href="#">
        <img src="<?php echo base_url('assets/images/icons/game.png')?>"
            alt="Game menu">
    </a>

    <a id="action_panel_button" class="action-panel-button" href="#">
        <img src="<?php echo base_url('assets/images/icons/action.png')?>"
            alt="Action menu">
    </a>

    <a id="inventory_panel_button" class="inventory-panel-button" href="#">
        <img src="<?php echo base_url('assets/images/icons/food.png')?>"
            alt="Inventory menu">
    </a>
    <?php else: ?>
    <a id="inventory_panel_button" class="inventory-panel-button" href="#">
        <img src="<?php echo base_url('assets/images/icons/login.png')?>"
            alt="Login menu">
    </a>
    <?php endif; ?>

    <nav id="nav_top">
        <?php if (isset($user)): ?>
        <ul>
            <li><a id="nav_game" title="Continue playing"
                    href="<?php echo base_url()?>">Game</a>
            </li>
            <?php if ($user['verified'] == 0): ?>
            <li><a class="ajaxHTML" id="nav_register" title="Please register to save this game!"
                    href="<?php echo base_url('account/register')?>">Register</a>
            </li>
            <?php endif; ?>
            <?php if ($user['verified'] == 1): ?>
            <li><a class="ajaxHTML" id="nav_players" title="Other players"
                    href="<?php echo base_url('inventory/players')?>">Players</a>
            </li>
            <li><a class="ajaxHTML" id="nav_chat" title="Chat"
                    href="<?php echo base_url('chat')?>">Chat</a>
            </li>
            <?php else: ?>
            <li><a class="disabled" id="nav_players" title="This option will be enabled when you are registered!"
                    href="<?php echo base_url('inventory/players')?>">Players</a>
            </li>
            <li><a class="disabled" id="nav_chat" title="This option will be enabled when you are registered!"
                    href="<?php echo base_url('chat')?>">Chat</a>
            </li>
            <?php endif; ?>
            <li><a class="ajaxHTML" id="nav_about" title="What's new in here?"
                    href="<?php echo base_url('about')?>">About</a>
            </li>
            <?php if ($user['verified'] == 1): ?>
            <li><a class="ajaxHTML" id="nav_settings" title="Change your settings"
                    href="<?php echo base_url('account/settings_account')?>">Settings</a>
            </li>
            <?php else: ?>
            <li><a class="disabled" id="nav_settings" title="This option will be enabled when you are registered!"
                    href="<?php echo base_url('account/settings_account')?>">Settings</a>
            </li>
            <?php endif; ?>
            <li><a id="nav_logout" title="Log out from this game"
                    href="<?php echo base_url('account/logout')?>">Quit</a>
            </li>
        </ul>

        <div id="music_control" style="display: inline-table; padding-left: 20px; padding-top: 15px;"
            data-autoplay="<?php echo ($user['music_play'] == 1) ? 'yes' : 'no';?>"
            data-musicvolume="<?php echo $user['music_volume']?>">
            <a href="#" id="sound_controls_icon" title="Control music and sound effects"><img
                    src="<?php echo base_url('assets/images/icons/sound_controls.png')?>"
                    alt="Sound controls"></a>
        </div>
        <?php else: ?>
        <p style="padding-left: 2em;"><em>A pirate influenced web game.</em></p>
        <?php endif; ?>
    </nav>
</div>