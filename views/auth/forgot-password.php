<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Recover your Password</p>

    <form class="form" action="/forgot-password" method="POST">
        <div class="form__field">
            <label class="form__label" for="email">Email</label>
            <input type="email" class="form__input" id="email" name="email" placeholder="Your email" autocomplete="off">
            <?php if(isset($alerts['error']['email'])) { ?>
                <div class="alert alert__error" id="alert-email"><?php echo $alerts['error']['email']; ?></div>
            <?php } ?>
        </div>

        <?php if(isset($alerts['success']['instructions'])) { ?>
            <div class="alert alert__success"><?php echo $alerts['success']['instructions']; ?></div>
        <?php } ?>

        <?php if(isset($alerts['error']['no-user'])) { ?>
            <div class="alert alert__error" id="alert-no-user"><?php echo $alerts['error']['no-user']; ?></div>
        <?php } ?>

        <input type="submit" class="form__submit" value="Send Instructions">
    </form>

    <div class="actions">
        <a href="/signin" class="actions__link">Already have an account? Sign In</a>
        <a href="/signup" class="actions__link">Don't you have an account yet? Create one</a>
    </div>
</main>