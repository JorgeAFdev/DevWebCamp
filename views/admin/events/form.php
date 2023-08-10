<fieldset class="form__fieldset">
    <legend class="form__legend">Event information</legend>

    <div class="form__field">
        <label for="name" class="form__label">Name</label>
        <input type="text" class="form__input" id="name" name="name" value="<?php echo sanitizeHTML($event->name); ?>" placeholder="Event name" autocomplete="no">
        <?php if(isset($alerts['error']['name'])) { ?>
            <div class="alert alert__error" id="alert-name"><?php echo $alerts['error']['name']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="description" class="form__label">Description</label>
        <textarea class="form__input form__input--textarea" id="description" name="description" placeholder="Event description"><?php echo sanitizeHTML($event->description); ?></textarea>
        <?php if(isset($alerts['error']['description'])) { ?>
            <div class="alert alert__error" id="alert-description"><?php echo $alerts['error']['description']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="category" class="form__label">Category</label>
        <select class="form__select" id="category" name="category_id">
            <option value="" selected disabled>- Select -</option>
            <?php foreach($categories as $category) { ?>
                <option <?php echo ($event->category_id === $category->id) ? 'selected' : ''; ?> value="<?php echo sanitizeHTML($category->id); ?>"><?php echo $category->name; ?></option>
            <?php } ?>
        </select>
        <?php if (isset($alerts['error']['category'])) { ?>
            <div class="alert alert__error" id="alert-category"><?php echo $alerts['error']['category']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field" >
        <label class="form__label">Select the day</label>
        <div class="form__radio">
            <?php foreach($days as $day) { ?>
                <div>
                    <label for="<?php echo strtolower($day->name); ?>"><?php echo $day->name; ?></label>
                    <input type="radio" id="<?php echo strtolower($day->name); ?>" name="day" value="<?php echo sanitizeHTML($day->id); ?>" 
                    <?php echo ($event->day_id === $day->id) ? 'checked' : ''; ?>>
                </div>
            <?php } ?>
        </div>

        <input type="hidden" name="day_id" value="<?php echo sanitizeHTML($event->day_id); ?>">
        <?php if(isset($alerts['error']['day'])) { ?>
            <div class="alert alert__error" id="alert-day"><?php echo $alerts['error']['day']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label class="form__label">Select time</label>
        <ul id="times" class="times">
            <?php foreach($times as $time) { ?>
                <li id="time" data-time-id="<?php echo $time->id; ?>" class="times__time times__time--disabled"><?php echo $time->time; ?></li>
            <?php } ?>
        </ul>

        <input type="hidden" name="time_id" value="<?php echo sanitizeHTML($event->time_id); ?>">
        <?php if(isset($alerts['error']['time'])) { ?>
            <div class="alert alert__error" id="alert-time"><?php echo $alerts['error']['time']; ?></div>
        <?php } ?>
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Extra information</legend>

    <div class="form__field">
        <label for="speakers" class="form__label">Speaker</label>
        <input type="text" class="form__input" id="speakers"
        placeholder="Search speaker">
        <?php if(isset($alerts['error']['speaker'])) { ?>
            <div class="alert alert__error" id="alert-speaker"><?php echo $alerts['error']['speaker']; ?></div>
        <?php } ?>
        <ul id="speakers-list" class="speakers-list"></ul>

        <input type="hidden" name="speaker_id" value="<?php echo sanitizeHTML($event->speaker_id); ?>">
    </div>

    <div class="form__field">
        <label for="spots" class="form__label">Available spots</label>
        <input type="number" min="1" class="form__input" id="spots" name="spots" value="<?php echo sanitizeHTML($event->spots); ?>" placeholder="Ex. 20">
        <?php if(isset($alerts['error']['spots'])) { ?>
            <div class="alert alert__error" id="alert-spots"><?php echo $alerts['error']['spots']; ?></div>
        <?php } ?>
    </div>
</fieldset>