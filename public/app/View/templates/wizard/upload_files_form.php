<h1><?= \app\I18n\I18n::get('upload_files.title') ?></h1>

<form class="form" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <div class="form__col form__col--label">
            <label><?= \app\I18n\I18n::get('upload_files.field.file') ?></label>
        </div>
        <div class="form__col form__col--field">
            <input type="file" name="file" multiple>
        </div>
    </div>
    <?php if ($errors->has('files')): ?>
        <div class="form__row form__row--error"><?= \app\I18n\I18n::get($errors->first('files')) ?></div>
    <?php endif; ?>
    <div class="form__row form__row--actions">
        <button type="submit" class="form__button"><?= \app\I18n\I18n::get('form.action.upload') ?></button>
        <button type="submit" name="finish" value="1" class="form__button"><?= \app\I18n\I18n::get('form.action.finish') ?></button>
    </div>
</form>