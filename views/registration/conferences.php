<h2 class="conferences__heading"><?php echo $title; ?></h2>
<p class="conferences__description">Choose up to 5 events to attend in person</p>

<div class="events-registered">
    <main class="events-registered__list">
        <h3 class="events-registered__heading--conferences">Conferences</h3>
        <p class="events-registered__date">Friday may 19</p>

        <div class="events-registered__grid">
            <?php foreach ($events['conferences_f'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-registered__date">Saturday may 20</p>

        <div class="events-registered__grid">
            <?php foreach ($events['conferences_s'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <h3 class="events-registered__heading--workshops">Workshops</h3>
        <p class="events-registered__date">Friday may 19</p>

        <div class="events-registered__grid events--workshops">
            <?php foreach ($events['workshops_f'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-registered__date">Saturday may 20</p>

        <div class="events-registered__grid events--workshops">
            <?php foreach ($events['workshops_s'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>
    </main>

    <aside class="registration">
        <h2 class="registration__heading">Selected events</h2>

        <div id="registration-summary" class="registration__summary"></div>

        <div class="registration__gift">
            <label for="gift" class="registration__label">Select gift</label>
            <select id="gift" class="registration__select">
                <option value="" selected disabled>-- Select your gift --</option>
                <?php foreach($gifts as $gift) {?>
                    <option value="<?php echo sanitizeHTML($gift->id); ?>"><?php echo $gift->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <form id="registration" class="form">
            <div class="form__field">
                <input type="submit" class="form__submit form__submit--register" value="Register">
            </div>
        </form>
    </aside>
</div>