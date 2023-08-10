<header class="header">
    <div class="header__container">
        <nav class="header__nav">
            <?php if (is_auth()) { ?>
                <?php if (is_admin()) { ?>
                    <a href="/admin/dashboard" class="header__link">Admin</a>
                <?php } else { ?>
                    <a href="/complete-registration" class="header__link">Complete Registraton</a>
                <?php } ?>
                <form class="header__form" method="POST" action="/signout">
                    <input type="submit" value="Sign Out" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/signin" class="header__link">Sign in</a>
                <a href="/signup" class="header__link">Sign up</a>
            <?php } ?>
        </nav>


        <div class="header__content">
            <a href="/">
                <h1 class="header__logo">
                    DevWebCamp
                </h1>
            </a>

            <p class="header__text">October 5-6, 2023</p>
            <p class="header__text header__text--mode">Online and In-person</p>

            <?php if (!is_auth()) { ?>
                <a href="/signup" class="header__button">Buy Pass</a>
            <?php } else { ?>
                <a href="/complete-registration" class="header__button">Buy Pass</a>
            <?php }  ?>
        </div>
    </div>
</header>
<div class="bar">
    <div class="bar__content">
        <a href="/">
            <h2 class="bar__logo">
                DevWebCamp
            </h2>
        </a>
        <nav class="nav">
            <a href="/about" class="nav__link <?php echo current_page('/about') ? 'nav__link--current' : ''; ?> ">About</a>
            <a href="/packages" class="nav__link <?php echo current_page('/packages') ? 'nav__link--current' : ''; ?> "">Packages</a>
            <a href="/workshops-conferences" class="nav__link <?php echo current_page('/workshops-conferences') ? 'nav__link--current' : ''; ?> "">Workshops / Conferences</a>
            <?php if(!empty($_SESSION)) { ?>
                <a href="/complete-registration" class="nav__link <?php echo current_page('/sign-up') ? 'nav__link--current' : ''; ?> "">Buy Pass</a>
            <?php } else { ?>
                <a href="/signup" class="nav__link <?php echo current_page('/sign-up') ? 'nav__link--current' : ''; ?> "">Buy Pass</a>
            <?php } ?>
        </nav>
    </div>
</div>