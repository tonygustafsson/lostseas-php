<aside id="inventory_panel" class="action-panel">
    <a class="js-panel-close top-nav-panel__close-btn">
        <svg width="20" height="20" alt="Close">
            <use xlink:href="#icon-close"></use>
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
            <div class="error">Your login was denied...</div>
            <?php endif; ?>

            <?php if (isset($user['success'])): ?>
            <div class="success">
                <p>You are now registered with the username: <?=$user['success']?>!
                    Please log in.</p>
            </div>
            <?php endif; ?>

            <label for="login_email">Email</label>
            <input type="text" id="login_email" name="login_email" />

            <label for="login_password">Password</label>
            <input type="password" id="login_password" name="login_password" />

            <p style="font-size: 12px; margin: 0 0 1em 0;">
                <a style="color: #000" class="ajaxHTML"
                    href="<?=base_url('account/password_forgotten')?>">Have
                    you forgotten your password?
                </a>
            </p>

            <button type="submit" class="w-100">Login</button>
        </fieldset>
    </form>

    <div class="action-panel__logos">
        <a target="_blank" href="https://www.facebook.com/lostseas" title="Visit us on Facebook">
            <svg width="32" height="32" alt="Facebook">
                <use xlink:href="#icon-facebook"></use>
            </svg>
        </a>

        <a target="_blank" href="https://join.slack.com/t/lostseas/shared_invite/zt-f38krf6a-lGs1cFO9nKO~NJsJadA3VA"
            title="Talk to each other and the creator on Slack Chat">
            <svg width="32" height="32" alt="Slack">
                <use xlink:href="#icon-slack"></use>
            </svg>
        </a>
    </div>
</aside>