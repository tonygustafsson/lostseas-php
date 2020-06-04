<aside id="inventory_panel" class="action-panel">
    <form method="post"
        action="<?php echo base_url('account/login')?>"
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
                <p>You are now registered with the username: <?php echo $user['success']?>!
                    Please log in.</p>
            </div>
            <?php endif; ?>

            <label for="login_email">Email</label>
            <input type="text" value="mail@tonyg.se" id="login_email" name="login_email" autofocus style="width: 100%">

            <label for="login_password">Password</label>
            <input type="password" value="Tony19831528" id="login_password" name="login_password" style="width: 100%">

            <p style="font-size: 12px; margin: 0 1em;"><a style="color: #000" class="ajaxHTML"
                    href="<?php echo base_url('account/password_forgotten')?>">Have
                    you forgotten your password?</a></p>

            <input class="small" type="submit" value="Log in" style="margin-top: 1em;">
        </fieldset>
    </form>

    <p>
        <a href="https://www.facebook.com/lostseas" class="fb-like-box" title="Visit us on Facebook"><img
                src="<?php echo base_url('assets/images/design/facebook.png')?>"
                alt="Visit us on facebook"></a>
    </p>
</aside>