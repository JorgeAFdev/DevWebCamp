<h2 class="dashboard__heading"><?php echo $title; ?></h2>
<main class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__heading">Latest Records</h3>
            <?php foreach ($registered as $record) {; ?>
                <div class="block__content">
                    <p class="block__text"><?php echo $record->user->name . " " . $record->user->surname; ?></p>
                </div>
            <?php }; ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Income</h3>
            <div class="block__content">
                <p class="block__text--amount">$ <?php echo $income; ?></p>
            </div>
        </div>


        <div class="block">
            <h3 class="block__heading">Events with less spots available</h3>
            <?php foreach ($less_spots as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $event->name . " - " . $event->spots . " Available"; ?>
                    </p>
                </div>
            <?php }; ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Events with more spots available</h3>
            <?php foreach ($more_spots as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $event->name . " - " . $event->spots . " Available"; ?>
                    </p>
                </div>
            <?php }; ?>
        </div>
    </div>
</main>