<div class="event">
    <p class="event__time"><?php echo $event->time->time; ?></p>

    <div class="event__info">
        <h4 class="event__name"><?php echo $event->name; ?></h4>

        <p class="event__introduction"><?php echo $event->description ?></p>

        <div class="event__speaker-info">
            <picture>
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event->speaker->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event->speaker->image; ?>.png" type="image/png">
                <img class="event__speaker-image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['APP_URL'] . '/img/speakers/' . $event->speaker->image; ?>.png" alt="Speaker Image">
            </picture>

            <p class="event__speaker-name">
                <?php echo $event->speaker->name . " " . $event->speaker->surname; ?>
            </p>
        </div>

        <button 
            type="button" 
            data-id="<?php echo $event->id; ?>" 
            class="event__add" <?php echo ($event->spots === "0") ? 'disabled' : ''; ?>
        >
            <?php echo ($event->spots === "0") ? 'No Spots Left' : 'Add - ' .  $event->spots . ' Spots' ;?>
        </button>
    </div>
</div>