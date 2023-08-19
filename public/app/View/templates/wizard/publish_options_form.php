<h1><?= \app\I18n\I18n::get('publish_options.title') ?></h1>

<form class="form" method="post">
    <div class="form__row">
        <div class="form__col form__col--label">
            <label><?= \app\I18n\I18n::get('publish_options.field.delay') ?></label>
        </div>
        <div class="form__col form__col--field">
            <input type="number" name="delay" value="14">
        </div>
    </div>
    <div class="form__row form__row--actions">
        <button type="submit" class="form__button"><?= \app\I18n\I18n::get('form.action.save') ?></button>
    </div>
</form>