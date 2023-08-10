<fieldset class="form__fieldset">
    <legend class="form__legend">Personal information</legend>

    <div class="form__field">
        <label for="name" class="form__label">Name</label>
        <input type="text" class="form__input" id="name" name="name"
        placeholder="Speaker name" value="<?php echo sanitizeHTML($speaker->name); ?>" autocomplete="off">
        <?php if(isset($alerts['error']['name'])) { ?>
            <div class="alert alert__error" id="alert-name"><?php echo $alerts['error']['name']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="surname" class="form__label">Surname</label>
        <input type="text" class="form__input" id="surname" name="surname"
        placeholder="Speaker surname" value="<?php echo sanitizeHTML($speaker->surname); ?>">
        <?php if(isset($alerts['error']['surname'])) { ?>
            <div class="alert alert__error" id="alert-surname"><?php echo $alerts['error']['surname']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="city" class="form__label">City</label>
        <input type="text" class="form__input" id="city" name="city"
        placeholder="Speaker City" value="<?php echo sanitizeHTML($speaker->city); ?>">
        <?php if(isset($alerts['error']['city'])) { ?>
            <div class="alert alert__error" id="alert-city"><?php echo $alerts['error']['city']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="country" class="form__label">Country</label>
        <input type="text" class="form__input" id="country" name="country"
        placeholder="Speaker Country" value="<?php echo sanitizeHTML($speaker->country); ?>" autocomplete="on">
        <?php if(isset($alerts['error']['country'])) { ?>
            <div class="alert alert__error" id="alert-country"><?php echo $alerts['error']['country']; ?></div>
        <?php } ?>
    </div>

    <div class="form__field">
        <label for="image" class="form__label">Image</label>
        <input type="file" class="form__input form__input--file" id="image" name="image">
        <?php if(isset($alerts['error']['image'])) { ?>
            <div class="alert alert__error" id="alert-image"><?php echo $alerts['error']['image']; ?></div>
        <?php } ?>
        
    </div>

    <?php if(isset($speaker->current_image)) { ?>
        <p class="form__text">Current Image:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" alt="Speaker Image">
            </picture>
        </div>
    <?php } ?>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Extra information</legend>

    <div class="form__field">
        <label for="tags_input" class="form__label">Areas of Expertise (separated by commas)</label>
        <input type="text" class="form__input" id="tags_input"
        placeholder="Ex. Node.js, PHP, CSS, Laravel, UX / UI ">
        <?php if(isset($alerts['error']['tags'])) { ?>
            <div class="alert alert__error" id="alert-tags"><?php echo $alerts['error']['tags']; ?></div>
        <?php } ?>

        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo sanitizeHTML($speaker->tags); ?>">
    </div>

</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Social networks</legend>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[facebook]"
            placeholder="Facebook" value="<?php echo isset($socials->facebook) ? sanitizeHTML($socials->facebook) : ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[twitter]"
            placeholder="Twitter" value="<?php echo isset($socials->twitter) ? sanitizeHTML($socials->twitter) : ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[youtube]"
            placeholder="Youtube" value="<?php echo isset($socials->youtube) ? sanitizeHTML($socials->youtube) : ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[instagram]"
            placeholder="Instagram" value="<?php echo isset($socials->instagram) ? sanitizeHTML($socials->instagram) : ''; ?>">
        </div>
    </div>
    
    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[tiktok]"
            placeholder="Tiktok" value="<?php echo isset($socials->tiktok) ? sanitizeHTML($socials->tiktok) : ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-github"></i>
            </div>
            <input type="text" class="form__input--socials" name="socials[github]"
            placeholder="Github" value="<?php echo isset($socials->github) ? sanitizeHTML($socials->github) : ''; ?>">
        </div>
    </div>
</fieldset>