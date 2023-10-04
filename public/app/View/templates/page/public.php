<h1><?= \app\I18n\I18n::get('public.title') ?></h1>

<p>
    <?= $message ?? '' ?>
</p>

<ul>
    <?php foreach($files ?? [] as $file):?>
    <li>
        <a href="<?= $file['url'] ?>" target="_blank"><?= $file['name'] ?></a>
    </li>
    <?php endforeach ?>
</ul>