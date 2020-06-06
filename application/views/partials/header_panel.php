<div class="header-panel">
        <header>
                <h1><a title="Go back to start page"
                                href="<?=base_url()?>"><?=$this->config->item('site_name')?></a>
                </h1>
        </header>

        <?php if (isset($user)): ?>
        <a id="nav_top_button" class="inventory-panel-button" href="#">
                <img src="<?=base_url('assets/images/icons/game.png')?>"
                        alt="Game menu">
        </a>

        <a id="action_panel_button" class="inventory-panel-button" href="#">
                <img src="<?=base_url('assets/images/icons/action.png')?>"
                        alt="Action menu">
        </a>

        <a id="inventory_panel_button" class="inventory-panel-button" href="#">
                <img src="<?=base_url('assets/images/icons/food.png')?>"
                        alt="Inventory menu">
        </a>
        <?php else: ?>
        <a id="inventory_panel_button" class="inventory-panel-button" href="#">
                <img src="<?=base_url('assets/images/icons/login.png')?>"
                        alt="Login menu">
        </a>
        <?php endif; ?>

        <nav id="nav_top_panel" class="top-nav-panel">
                <?php if (isset($user)): ?>
                <a class="top-nav-panel__item" title="Continue playing"
                        href="<?=base_url()?>">
                        <svg width="32" height="32" class="Game">
                                <use xlink:href="#swords"></use>
                        </svg>
                        Game
                </a>

                <?php if ($user['verified'] == 0): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Please register to save this game!"
                        href="<?=base_url('account/register')?>">
                        <svg width="32" height="32" class="Game">
                                <use xlink:href="#logbook"></use>
                        </svg>
                        Register
                </a>
                <?php endif; ?>

                <?php if ($user['verified'] == 1): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Other players"
                        href="<?=base_url('inventory/players')?>">
                        <svg width="32" height="32" class="Players">
                                <use xlink:href="#crew-member"></use>
                        </svg>
                        Players
                </a>

                <a class="top-nav-panel__item ajaxHTML" title="Chat"
                        href="<?=base_url('chat')?>">
                        <svg width="32" height="32" class="Chat">
                                <use xlink:href="#parrot"></use>
                        </svg>
                        Chat
                </a>

                <?php else: ?>
                <a class="top-nav-panel__item top-nav-panel__item--disabled"
                        title="This option will be enabled when you are registered!"
                        href="<?=base_url('inventory/players')?>">
                        <svg width="32" height="32" class="Players">
                                <use xlink:href="#crew-member"></use>
                        </svg>
                        Players
                </a>

                <a class="top-nav-panel__item top-nav-panel__item--disabled"
                        title="This option will be enabled when you are registered!"
                        href="<?=base_url('chat')?>">
                        <svg width="32" height="32" class="Chat">
                                <use xlink:href="#parrot"></use>
                        </svg>
                        Chat
                </a>

                <?php endif; ?>
                <a class="top-nav-panel__item ajaxHTML" title="What's new in here?"
                        href="<?=base_url('about')?>">
                        <svg width="32" height="32" class="About">
                                <use xlink:href="#globe"></use>
                        </svg>
                        About
                </a>

                <?php if ($user['verified'] == 1): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Change your settings"
                        href="<?=base_url('account/settings_account')?>">
                        <svg width="32" height="32" class="Settings">
                                <use xlink:href="#cogs"></use>
                        </svg>
                        Settings
                </a>

                <?php else: ?>
                <a class="top-nav-panel__item top-nav-panel__item--disabled"
                        title="This option will be enabled when you are registered!"
                        href="<?=base_url('account/settings_account')?>">
                        <svg width="32" height="32" class="Settings">
                                <use xlink:href="#cogs"></use>
                        </svg>
                        Settings
                </a>

                <?php endif; ?>
                <a class="top-nav-panel__item" title="Log out from this game"
                        href="<?=base_url('account/logout')?>">
                        <svg width="32" height="32" class="Quit">
                                <use xlink:href="#door"></use>
                        </svg>
                        Quit
                </a>

                <a href="#" id="music_control" title="Control music and sound effects" id="music_control"
                        class="top-nav-panel__item top-nav-panel__item--music-control"
                        data-autoplay="<?=($user['music_play'] == 1) ? 'yes' : 'no';?>"
                        data-musicvolume="<?=$user['music_volume']?>">
                        <svg width="24" height="24" class="Sound controls">
                                <use xlink:href="#sound"></use>
                        </svg>
                </a>
                <?php else: ?>
                <p style="padding-left: 2em;"><em>A pirate influenced web game.</em></p>
                <?php endif; ?>
        </nav>
</div>