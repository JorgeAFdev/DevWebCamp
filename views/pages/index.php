<?php include_once __DIR__ . '/conferences.php'; ?>

<section class="summary">
    <div class="summary__grid">
        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $speakers_total; ?></p>
            <p class="summary__text">Speakers</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $conferences_total; ?></p>
            <p class="summary__text">Conferences</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $workshops_total; ?></p>
            <p class="summary__text">Workshops</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number">500</p>
            <p class="summary__text">Assistants</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Speakers</h2>
    <p class="speakers__description">Meet our DevWebCamp experts</p>

    <div <?php aos_animation(); ?> class="speakers__grid">
        <?php foreach ($speakers as $speaker) { ?>
            <div class="speaker">
                <picture>
                    <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                    <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                    <img class="speaker__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event->speaker->image; ?>.png" alt="Speaker Image">
                </picture>

                <div class="speaker__info">
                    <h4 class="speaker__name">
                        <?php echo $speaker->name . " " . $speaker->surname; ?>
                    </h4>

                    <p class="speaker__location">
                        <?php echo $speaker->city . ", " . $speaker->country; ?>
                    </p>

                    <div class="speaker-socials">
                        <?php
                        $socials = json_decode($speaker->socials);
                        ?>

                        <?php if (!empty($socials->facebook)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->facebook; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if (!empty($socials->twitter)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->twitter; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if (!empty($socials->youtube)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->youtube; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if (!empty($socials->instagram)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->instagram; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if (!empty($socials->tiktok)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->tiktok; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if (!empty($socials->github)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $socials->github; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>
                    </div>

                    <ul class="speaker__list-skills">
                        <?php
                        $tags = explode(',', $speaker->tags);
                        foreach ($tags as $tag) { ?>
                            <li class="speaker__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="map" class="map"></div>

<section class="tickets">
    <h2 class="tickets__heading">Tickets & Prices</h2>
    <p class="tickets__description">Pricing for DevWebCamp</p>

    <div <?php aos_animation(); ?> class="tickets__grid">
        <div class="ticket ticket--in-person ticket--access">
            <h4 class="ticket__logo">DevWebCamp</h4>
            <p class="ticket__type">In-person</p>
            <p class="ticket__price">$80</p>
        </div>

        <div class="ticket ticket--online ticket--access">
            <h4 class="ticket__logo">DevWebCamp</h4>
            <p class="ticket__type">Online</p>
            <p class="ticket__price">$30</p>
        </div>

        <div class="ticket ticket--free ticket--access">
            <h4 class="ticket__logo">DevWebCamp</h4>
            <p class="ticket__type">Free</p>
            <p class="ticket__price">Free - $0</p>
        </div>
    </div>

    <div <?php aos_animation(); ?> class="packages__link-container">
        <a href="/packages" class="packages__link">See packages</a>
    </div>
</section>