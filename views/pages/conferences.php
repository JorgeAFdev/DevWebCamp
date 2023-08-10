<main class="calendar">
    <h2 class="calendar__heading">Workshops & Conferences</h2>
    <p class="calendar__description">Workshops and Conferences given by experts in web development</p>

    <div class="events">
        <h3 class="events__heading">Conferences</h3>
        <p class="events__date">Friday may 19</p>

        <div class="events__list slider swiper" id="events-slider">
            <div class="swiper-wrapper">
                <?php foreach ($events['conferences_f'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date">Saturday may 20</p>
        <div class="events__list slider swiper" id="events-slider">
            <div class="swiper-wrapper">
                <?php foreach ($events['conferences_s'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="events events--workshops">
        <h3 class="events__heading">Workshops</h3>
        <p class="events__date">Friday may 19</p>

        <div class="events__list slider swiper" id="events-slider">
            <div class="swiper-wrapper">
                <?php foreach ($events['workshops_f'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date">Saturday may 20</p>

        <div class="events__list slider swiper" id="events-slider">
            <div class="swiper-wrapper">
                <?php foreach ($events['workshops_s'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>