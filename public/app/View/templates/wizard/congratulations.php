<h1><?= \app\I18n\I18n::get('congratulations.title') ?></h1>

<p>
    <?= \app\I18n\I18n::get('congratulations.dsc') ?>
</p>

<form class="form" method="post">
    <div class="form__row form__row--actions">
        <button type="submit" name="reset" value="1" class="form__button"><?= \app\I18n\I18n::get('form.action.reset') ?></button>
        <button type="submit" class="form__button"><?= \app\I18n\I18n::get('form.action.finish') ?></button>
    </div>
</form>