<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Create your account at DevWebCamp</p>

    <?php if(isset($alerts['error']['user_exists'])) { ?>
        <div class="alert alert__error" id="alert-user_exists"><?php echo $alerts['error']['user_exists']; ?></div>
    <?php } ?>

    <form method="POST" action="/signup" class="form">
        <div class="form__field form__field--auth">
            <label class="form__label" for="name">Name</label>
            <input type="name" class="form__input" id="name" name="name" placeholder="Your name" value="<?php echo sanitizeHTML($user->name); ?>" autocomplete="name">
            <?php if(isset($alerts['error']['name'])) { ?>
                <div class="alert alert__error" id="alert-name"><?php echo $alerts['error']['name']; ?></div>
            <?php } ?>
        </div>

        <div class="form__field form__field--auth">
            <label class="form__label" for="surname">Surname</label>
            <input type="surname" class="form__input" id="surname" name="surname" placeholder="Your surname" value="<?php echo sanitizeHTML($user->surname); ?>" autocomplete="off">
            <?php if(isset($alerts['error']['surname'])) { ?>
                <div class="alert alert__error" id="alert-surname"><?php echo $alerts['error']['surname']; ?></div>
            <?php } ?>
        </div>

        <div class="form__field form__field--auth">
            <label class="form__label" for="email">Email</label>
            <input type="email" class="form__input" id="email" name="email" placeholder="Your email" value="<?php echo sanitizeHTML($user->email); ?>" autocomplete="email">
            <?php if(isset($alerts['error']['email'])) { ?>
                <div class="alert alert__error" id="alert-email"><?php echo $alerts['error']['email']; ?></div>
            <?php } ?>
        </div>

        <div class="form__field form__field--auth">
            <label class="form__label" for="password">Password</label>
            <input type="password" class="form__input" id="password" name="password" placeholder="Your password" autocomplete="new-password">
            <?php if(isset($alerts['error']['password'])) { ?>
                <div class="alert alert__error" id="alert-password"><?php echo $alerts['error']['password']; ?></div>
            <?php } else if(isset($alerts['error']['password_length'])) { ?>
                <div class="alert alert__error" id="alert-password_length"><?php echo $alerts['error']['password_length']; ?></div>
            <?php } ?>
        </div>

        <div class="form__field form__field--auth">
            <label class="form__label" for="password2">Repeat Password</label>
            <input type="password" class="form__input" id="password2" name="password2" placeholder="Repeat password" autocomplete="new-password">
            <?php if(isset($alerts['error']['different_psw'])) { ?>
                <div class="alert alert__error" id="alert-different_psw"><?php echo $alerts['error']['different_psw']; ?></div>
            <?php } ?>
        </div>

        <input type="submit" class="form__submit" value="Create Account">
    </form>

    <div class="actions">
        <a href="/signin" class="actions__link" id="link">Already have an account? Sign In</a>
        <a href="/forgot-password" class="actions__link" id="link">Forgot your password?</a>
    </div>
</main>