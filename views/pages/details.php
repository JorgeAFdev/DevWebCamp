<div class="details">
    <h2 class="details__heading"><?php echo $title; ?></h2>

    <div class="details__info">
        <p class="details__descriptions"><?php echo $event['event']->description; ?></p>

        <h3 class="details__speaker-name">Event speaker</h3>

        <div class="speaker" <?php aos_animation() ;?>>
            <picture>
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                <img class="speaker__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $speaker->image; ?>.png" alt="Speaker Image">
            </picture>

            <div class="speaker__info">
                <h4 class="speaker__name">
                    <?php echo $speaker->name . " " . $speaker->surname; ?>
                </h4>

                <p class="speaker__location">
                    <?php echo $speaker->city . ", " . $speaker->country; ?>
                </p>

                <div class="speaker-socials--margin">
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
    </div>
</div>