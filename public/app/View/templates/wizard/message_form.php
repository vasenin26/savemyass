<h1><?= \app\I18n\I18n::get('set_message.title') ?></h1>

<form class="form" method="post">
    <div class="form__row form__row--wide">
        <div class="form__col form__col--label">
            <label for="message"><?= \app\I18n\I18n::get('set_message.field.message') ?></label>
        </div>
        <div class="form__col form__col--field">
            <textarea id="message" name="message"></textarea>
        </div>
    </div>
    <div class="form__row form__row--actions">
        <button type="submit" class="form__button"><?= \app\I18n\I18n::get('form.action.save') ?></button>
    </div>
</form>