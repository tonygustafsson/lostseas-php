<div class="header-panel">
        <header>
                <h1 class="header-panel__main-heading">
                        <a title="Go back to start page" class="js-logo-link header-panel__link"
                                href="<?=base_url()?>"
                                data-weather="<?=isset($game['weather']) ? $game['weather'] : 'sunset'?>">
                                <?php include('assets/images/logo-main.svg'); ?>
                                <span><?=$this->config->item('site_name')?></span>
                        </a>
                </h1>
        </header>

        <nav class="nav-top-mobile-panel">
                <?php if (isset($user)): ?>
                <a id="nav_top_button" class="nav-top-mobile-panel--item" href="#">
                        <svg width="32" height="32" alt="Game menu">
                                <use xlink:href="#icon-swords"></use>
                        </svg>
                </a>

                <a id="action_panel_button" class="nav-top-mobile-panel--item" href="#">
                        <svg width="32" height="32" alt="Actions menu">
                                <use xlink:href="#icon-compass"></use>
                        </svg>
                </a>

                <a id="inventory_panel_button" class="nav-top-mobile-panel--item" href="#">
                        <svg width="32" height="32" alt="Inventory menu">
                                <use xlink:href="#icon-barrels"></use>
                        </svg>
                </a>
                <?php else: ?>
                <a id="inventory_panel_button" class="nav-top-mobile-panel--item" href="#">
                        <svg width="32" height="32" alt="Login">
                                <use xlink:href="#icon-key"></use>
                        </svg>
                </a>
                <?php endif; ?>
        </nav>

        <nav id="nav_top_panel" class="top-nav-panel">
                <a class="js-panel-close top-nav-panel__close-btn">
                        <svg width="20" height="20" alt="Close">
                                <use xlink:href="#icon-close"></use>
                        </svg>
                </a>

                <?php if (isset($user)): ?>
                <a class="top-nav-panel__item" title="Continue playing"
                        href="<?=base_url()?>">
                        <svg width="32" height="32" alt="Game">
                                <use xlink:href="#icon-swords"></use>
                        </svg>
                        Game
                </a>

                <?php if ($user['verified'] == 0): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Please register to save this game!"
                        href="<?=base_url('account/register')?>">
                        <svg width="32" height="32" class="Game">
                                <use xlink:href="#icon-logbook"></use>
                        </svg>
                        Register
                </a>
                <?php endif; ?>

                <?php if ($user['verified'] == 1): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Other players"
                        href="<?=base_url('inventory/players')?>">
                        <svg width="32" height="32" alt="Players">
                                <use xlink:href="#icon-player"></use>
                        </svg>
                        Players
                </a>

                <?php else: ?>
                <a class="top-nav-panel__item top-nav-panel__item--disabled"
                        title="This option will be enabled when you are registered!"
                        href="<?=base_url('inventory/players')?>">
                        <svg width="32" height="32" alt="Players">
                                <use xlink:href="#icon-crew-man"></use>
                        </svg>
                        Players
                </a>

                <?php endif; ?>
                <a class="top-nav-panel__item ajaxHTML" title="What's new in here?"
                        href="<?=base_url('about')?>">
                        <svg width="32" height="32" alt="Guide">
                                <use xlink:href="#icon-logbook"></use>
                        </svg>
                        Guide
                </a>

                <?php if ($user['verified'] == 1): ?>
                <a class="top-nav-panel__item ajaxHTML" title="Change your settings"
                        href="<?=base_url('settings/account')?>">
                        <svg width="32" height="32" alt="Settings">
                                <use xlink:href="#icon-cogs"></use>
                        </svg>
                        Settings
                </a>

                <?php else: ?>
                <a class="top-nav-panel__item top-nav-panel__item--disabled"
                        title="This option will be enabled when you are registered!"
                        href="<?=base_url('settings/account')?>">
                        <svg width="32" height="32" alt="Settings">
                                <use xlink:href="#icon-cogs"></use>
                        </svg>
                        Settings
                </a>
                <?php endif; ?>

                <a href="#" id="music_control" title="Control music and sound effects" id="music_control"
                        class="top-nav-panel__item top-nav-panel__item--icon-only ml-auto"
                        data-autoplay="<?=($user['music_play'] == 1) ? 'yes' : 'no';?>"
                        data-musicvolume="<?=$user['music_volume']?>">
                        <svg width="24" height="24" alt="Sound controls">
                                <use xlink:href="#icon-sound"></use>
                        </svg>
                        <span>Sound</span>
                </a>

                <a title="Visit us at Facebook" class="top-nav-panel__item top-nav-panel__item--icon-only"
                        target="_blank" href="https://www.facebook.com/lostseas">
                        <svg width="24" height="24" alt="Facebook">
                                <use xlink:href="#icon-facebook"></use>
                        </svg>
                        <span>Facebook</span>
                </a>

                <a title="Talk to each other at our Slack Chat" target="_blank"
                        href="https://join.slack.com/t/lostseas/shared_invite/zt-f38krf6a-lGs1cFO9nKO~NJsJadA3VA"
                        class="top-nav-panel__item top-nav-panel__item--icon-only">
                        <svg width="24" height="24" alt="Slack">
                                <use xlink:href="#icon-slack"></use>
                        </svg>
                        <span>Slack</span>
                </a>

                <?php if (isset($user['admin']) && $user['admin'] == 1): ?>
                <a title="Enter God Mode!"
                        href="<?=base_url('godmode/index/' . $user['id'])?>"
                        class="ajaxHTML top-nav-panel__item top-nav-panel__item--icon-only">
                        <svg width="24" height="24" alt="Parrot">
                                <use xlink:href="#icon-godmode"></use>
                        </svg>
                        <span>God Mode</span>
                </a>
                <?php endif; ?>

                <a id="nav_logout" class="top-nav-panel__item top-nav-panel__item--icon-only" title="Log out"
                        href="<?=base_url('account/logout')?>">
                        <svg width="24" height="24" alt="Log out">
                                <use xlink:href="#icon-logout"></use>
                        </svg>
                        <span>Log out</span>
                </a>

                <?php else: ?>
                <p style="padding-left: 2em;"><em>A pirate influenced web game.</em></p>
                <?php endif; ?>
        </nav>
</div>