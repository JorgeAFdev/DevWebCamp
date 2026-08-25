<main class="pacakges">
    <h2 class="pacakges__heading"><?php echo $title; ?></h2>
    <p class="pacakges__description">Choose your plan</p>

    <div class="packages__grid">
        <div class="package">
            <h3 class="package__name">Free Pass</h3>
            <ul class="package__list">
                <li class="package__element">Virtual Access to DevWebCamp</li>
            </ul>

            <p class="package__price">$0</p>

            <form method="POST" action="/complete-registration/free">
                <input type="submit" class="packages__submit" value="Free Registration">
            </form>
        </div>

        <div class="package">
            <h3 class="package__name">In-person Pass</h3>
            <ul class="package__list">
                <li class="package__element">In-person Acces to DevWebCamp</li>
                <li class="package__element">2 day pass</li>
                <li class="package__element">Access to workshops and conferences</li>
                <li class="package__element">Access to event recordings</li>
                <li class="package__element">Event Shirt</li>
                <li class="package__element">Food and drink</li>
            </ul>

            <p class="package__price">$80</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="package">
            <h3 class="package__name">Online Pass</h3>
            <ul class="package__list">
                <li class="package__element">Online Acces to DevWebCamp</li>
                <li class="package__element">2 day pass</li>
                <li class="package__element">Access to workshops and conferences</li>
                <li class="package__element">Access to event recordings</li>
            </ul>

            <p class="package__price">$30</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-online"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=AdGlXRBjeZzUi_MqMS6l6iU_nECPc3FtAWNI5Kc4vAPOpGNsBYwd_v2qH2PdO5epCbBoJo_zJGVKajPm&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>