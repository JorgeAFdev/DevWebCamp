<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Create your account at DevWebCamp</p>

    <?php if(isset($alerts['success']['confirmed'])) { ?>
        <div class="alert alert--center alert__success"><?php echo $alerts['success']['confirmed']; ?></div>
    <?php } ?>

    <?php if(isset($alerts['error']['inv-token'])) { ?>
        <div class="alert alert--center alert__error"><?php echo $alerts['error']['inv-token']; ?></div>
    <?php } ?>

    <?php if(isset($alerts['success']['confirmed'])) { ?>
        <div class="actions--center">
            <a href="/signin" class="actions__link">Sign In</a>
        </div>
    <?php } ?>
</main>