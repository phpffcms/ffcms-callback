<?php

/** @var \Ffcms\Templex\Template\Template $this */

use Ffcms\Templex\Url\Url;

$this->layout('_layouts/default', [
    'title' => __('Settings'),
    'breadcrumbs' => [
        Url::to('main/index') => __('Main'),
        Url::to('application/index') => __('Widgets'),
        Url::to('callback/index') => __('Callback'),
        __('Settings')
    ]
]);
?>

<?php $this->start('body') ?>

<?= $this->insert('callback/_tabs') ?>

<h1><?= __('Callback settings') ?></h1>

<?php $form = $this->form($model) ?>

<?= $form->start() ?>

<?= $form->fieldset()->boolean('useCaptcha', null, __('Use captcha on callback form?')) ?>
<?= $form->fieldset()->text('email', null, __('Send notifications to email? Leave empty to disable this feature')) ?>

<?= $form->button()->submit(__('Save'), ['class' => 'btn btn-primary']) ?>

<?= $form->stop() ?>

<?php $this->stop() ?>
