<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Protected data storage' ?></title>

    <link href="/style/main.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form action="/configure" method="post" class="row">
        Lang: <select name="lang">
            <?php foreach (app\I18n\I18n::getAvailableLanguages() as $lang => $langName) : ?>
                <option value="<?= $lang ?>" <?= ($lang === $currentLanguage ? 'selected="selected"' : '') ?>> <?= $langName ?></option>
            <?php endforeach ?>
        </select>
        <button><?= \app\I18n\I18n::get('set') ?></button>
    </form>
    <?= $body ?>
</div>
</body>
</html>