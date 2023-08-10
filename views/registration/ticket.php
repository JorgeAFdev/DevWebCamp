<main class="page">
    <h2 class="page__heading"><?php echo $title; ?></h2>
    <p class="page__description">Your Ticket - We recommend you to store it, you can share it on social networks</p>

    <div class="ticket__virtual">

        <div class="ticket ticket--<?php echo strtolower($registration->package->name);?> ticket--access">
            <div class="ticket__content">
                <h4 class="ticket__logo">DevWebCamp</h4>
                <p class="ticket__type"><?php echo $registration->package->name; ?></p>
                <p class="ticket__name"><?php echo $registration->user->name . " " . $registration->user->surname; ?></p>
            </div>

            <p class="ticket__token"><?php echo '#' . $registration->token; ?></p>
        </div>
    </div>
</main>