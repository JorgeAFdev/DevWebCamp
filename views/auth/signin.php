<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Sign in to DevWebCamp</p>

    <?php if(isset($alerts['error']['no-user'])) { ?>
        <div class="alert alert__error" id="alert-no-user"><?php echo $alerts['error']['no-user']; ?></div>
    <?php } ?>
    
    <form class="form" method="POST" action="/signin">
        <div class="form__field form__field--auth">
            <label class="form__label" for="signIn-email">Email</label>
            <input type="email" class="form__input" id="signIn-email" name="email" placeholder="Your email" autocomplete="on">
            <?php if(isset($alerts['error']['email'])) { ?>
                <div class="alert alert__error" id="alert-email"><?php echo $alerts['error']['email']; ?></div>
            <?php } ?>
        </div>

        <div class="form__field form__field--auth">
            <label class="form__label" for="password">Password</label>
            <input type="password" class="form__input" id="password" name="password" placeholder="Your password" autocomplete="off">
            <?php if(isset($alerts['error']['password'])) { ?>
                <div class="alert alert__error" id="alert-password"><?php echo $alerts['error']['password']; ?></div>
            <?php } ?>
        </div>

        <?php if(isset($alerts['error']['inv_psw'])) { ?>
            <div class="alert alert__error" id="alert-inv-psw"><?php echo $alerts['error']['inv_psw']; ?></div>
        <?php } ?>
        <input type="submit" class="form__submit" value="Sign In">
    </form>

    <div class="actions">
        <a href="/signup" class="actions__link">Don't you have an account yet? Create one</a>
        <a href="/forgot-password" class="actions__link">Forgot your password?</a>
    </div>
</main>