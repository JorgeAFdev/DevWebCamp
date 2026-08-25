<a href="/details?id=<?php echo $event['event']->id; ?>" class="event swiper-slide" rel="noopener noreferrer" target="_blank" title="CLick here to view all the details">
    <p class="event__time"><?php echo $event['time']->time; ?></p>

    <div class="event__info">
        <h4 class="event__name" title="<?php echo$event['event']->name; ?>"><?php echo $event['event']->name; ?></h4>

        <p class="event__descriptions"><?php echo $event['event']->description; ?></p>

        <div class="event__speaker-info">
            <picture>
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event['speaker']->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event['speaker']->image; ?>.png" type="image/png">
                <img class="event__speaker-image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event['speaker']->image; ?>.png" alt="Speaker Image">
            </picture>

            <p class="event__speaker-name">
                <?php echo $event['speaker']->name . " " . $event['speaker']->surname; ?>
            </p>
        </div>
    </div>
</a>