<h2 class="dashboard__heading"><?php echo $title; ?></h2>
<div class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__title">Latest records</h3>
            <?php foreach ($registered as $data) {; ?>
                <div class="block__content">
                    <p class="block__text"><?php echo $data['user']->name . " " . $data['user']->surname; ?></p>
                </div>
            <?php }; ?>
        </div>

        <div class="block">
            <h3 class="block__title">Income</h3>
            <div class="block__content">
                <p class="block__text--amount">$ <?php echo $income; ?></p>
            </div>
        </div>

        <div class="block">
            <h3 class="block__title">Events with less spots available</h3>
            <div class="dashboard__chart--h-20">
                <canvas id="less-spots-chart"></canvas>
            </div>
        </div>

        <div class="block">
            <h3 class="block__title">Events with more spots available</h3>
            <div class="dashboard__chart--h-20">
                <canvas id="more-spots-chart"></canvas>
            </div>
        </div>
    </div>
</div>