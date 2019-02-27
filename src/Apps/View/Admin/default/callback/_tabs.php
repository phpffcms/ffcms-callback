<?php
/** @var \Ffcms\Templex\Template\Template $this */
?>

<?= $this->bootstrap()->nav('ul', ['class' => 'nav-tabs nav-fill'])
    ->menu(['text' => __('Requests'), 'link' => ['callback/index']])
    ->menu(['text' => __('Settings'), 'link' => ['callback/settings']])
    ->display(); ?>