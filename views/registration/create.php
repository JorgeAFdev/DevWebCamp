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

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "1",
                        "amount": {
                            "currency_code": "USD",
                            "value": 80
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const data = new FormData();
                    data.append('package_id', orderData.purchase_units[0].description);
                    data.append('pay_id', orderData.purchase_units[0].payments.captures[0].id);
                    
                    fetch('/complete-registration/pay', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.result) {
                            actions.redirect('http://localhost:3000/complete-registration/conferences');
                        }
                    })
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');

        // Online Pass
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay'
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "2",
                        "amount": {
                            "currency_code": "USD",
                            "value": 30
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const data = new FormData();
                    data.append('package_id', orderData.purchase_units[0].description);
                    data.append('pay_id', orderData.purchase_units[0].payments.captures[0].id);
                    
                    fetch('/complete-registration/pay', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.result) {
                            actions.redirect('http://localhost:3000/complete-registration/conferences');
                        }
                    })
                });
            },
            
        }).render('#paypal-button-container-online');
    }

    initPayPalButton();
</script>