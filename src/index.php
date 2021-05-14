<?= start() ?>
    <?= partial('_partials/hello', ['name' => 'Ryan']) ?>
<?= stop('content') ?>

<?= extend('_layouts/layout') ?>