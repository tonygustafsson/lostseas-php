<aside id="inventory_panel" class="action-panel">
    <a class="js-panel-close top-nav-panel__close-btn">
        <svg width="20" height="20" alt="Close">
            <use xlink:href="#close"></use>
        </svg>
    </a>

    <form method="post"
        action="<?=base_url('account/login')?>"
        style="width: 100%; margin: 0; padding: 0;">
        <fieldset>
            <legend>Log in</legend>

            <?php if ($this->session->userdata('email') || $this->session->userdata('password')): ?>
            <?php $this->session->unset_userdata('email') ?>
            <?php $this->session->unset_userdata('password') ?>
            <p style="margin: 0.2em 1em; background: #d96868; padding: 0.3em;">Your login was denied...</p>
            <?php endif; ?>

            <?php if (isset($user['success'])): ?>
            <div class="success">
                <p>You are now registered with the username: <?=$user['success']?>!
                    Please log in.</p>
            </div>
            <?php endif; ?>

            <label for="login_email">Email</label>
            <input type="text" value="mail@tonyg.se" id="login_email" name="login_email" autofocus />

            <label for="login_password">Password</label>
            <input type="password" value="Tony19831528" id="login_password" name="login_password" />

            <p style="font-size: 12px; margin: 0 1em;">
                <a style="color: #000" class="ajaxHTML"
                    href="<?=base_url('account/password_forgotten')?>">Have
                    you forgotten your password?
                </a>
            </p>

            <input class="small" type="submit" value="Log in" style="margin-top: 1em;" />
        </fieldset>
    </form>

    <a href="https://www.facebook.com/lostseas" class="action-panel__facebook-logo" title="Visit us on Facebook">
        <svg width="32" height="32" alt="Facebook">
            <use xlink:href="#facebook"></use>
        </svg>
    </a>
</aside>