<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Enter your new password</p>

    <?php if(isset($alerts['error']['inv-token'])) { ?>
        <div class="alert alert__error"><?php echo $alerts['error']['inv-token']; ?></div>
    <?php } ?>

    <?php if($show) { ?>

        <form class="form" method="POST">
            <div class="form__field">
                <label class="form__label" for="password">New Password</label>
                <input type="password" class="form__input" id="password" name="password" placeholder="Your new password">

                <?php if(isset($alerts['error']['password'])) { ?>
                    <div class="alert alert__error"><?php echo $alerts['error']['password']; ?></div>
                <?php } else if(isset($alerts['error']['password_length'])) { ?>
                    <div class="alert alert__error"><?php echo $alerts['error']['password_length']; ?></div>
                <?php } ?>
            </div>

            <input type="submit" class="form__submit" value="Save Password">
        </form>

    <?php } ?>

    <div class="actions">
        <a href="/signin" class="actions__link">Already have an account? Sign In</a>
        <a href="/signup" class="actions__link">Don't you have an account yet? Create one</a>
    </div>
</main>