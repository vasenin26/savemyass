<h1><?= \app\I18n\I18n::get('protected.title') ?></h1>

<p>
    <?= \app\I18n\I18n::get('protected.dsc') ?> <?= date("Y-m-d H:i", $publishTime ?? null)?>
</p>