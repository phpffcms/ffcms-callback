<?php

/** @var \Ffcms\Templex\Template\Template $this */
/** @var \Apps\ActiveRecord\Callback[]|\Illuminate\Support\Collection $records */
/** @var array $pagination */
/** @var string $tplDir */

use Ffcms\Core\Helper\Date;
use Ffcms\Templex\Url\Url;

$this->layout('_layouts/default', [
    'title' => __('Callback'),
    'breadcrumbs' => [
        Url::to('main/index') => __('Main'),
        Url::to('application/index') => __('Widgets'),
        __('Callback')
    ]
]);

?>

<?php $this->start('body') ?>
<h1><?= __('Callback requests') ?></h1>

<?= $this->insert('callback/_tabs') ?>

<?php
if ($records->count() < 1) {
    echo $this->bootstrap()->alert('warning', __('Callbacks not found yet!'));
    $this->stop();
    return;
}

$table = $this->table(['class' => 'table table-striped'])
    ->head([
        ['text' => '#'],
        ['text' => __('Phone')],
        ['text' => __('Name')],
        ['text' => __('Date')],
        ['text' => __('Actions'), 'properties' => ['class' => 'text-center']]
    ]);

foreach ($records as $row) {
    $actionMenu = $this->bootstrap()->btngroup(['class' => 'btn-group btn-group-sm']);
    if (!$row->done) {
        $actionMenu->add('<i class="fas fa-bell" style="color: #ff252d;"></i>', ['callback/close', [$row->id]], ['html' => true]);
    }

    $actionMenu->add('<i class="fas fa-eye"></i>', ['callback/read', [$row->id]], ['html' => true]);

    $table->row([
        ['text' => $row->id],
        ['text' => '<a href="tel:' . $row->phone . '">' . $row->phone . '</a>', 'html' => true],
        ['text' => $row->name],
        ['text' => Date::convertToDatetime($row->created_at, Date::FORMAT_TO_HOUR)],
        ['text' => $actionMenu->display(), 'html' => true, 'properties' => ['class' => 'text-center']]
    ]);
}
?>

<div class="table-responsive">
    <?= $table->display() ?>
</div>

<?= $this->bootstrap()->pagination($pagination['url'], ['class' => 'pagination justify-content-center'])
    ->size($pagination['total'], $pagination['page'], $pagination['step'])
    ->display(); ?>

<?php $this->stop(); ?>
