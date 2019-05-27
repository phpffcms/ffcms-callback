<?php

use Ffcms\Core\Helper\Date;
use Ffcms\Templex\Url\Url;

/** @var \Ffcms\Templex\Template\Template $this */
/** @var \Apps\ActiveRecord\Callback $record */

$this->layout('_layouts/default', [
    'title' => __('Callback'),
    'breadcrumbs' => [
        Url::to('main/index') => __('Main'),
        Url::to('widget/index') => __('Widgets'),
        Url::to('callback/index') => __('Callback'),
        __('Read callback #%id%', ['id' => $record->id])
    ]
]);
?>

<?php $this->start('body') ?>

<h1><?= __('Read callback: #%id%', ['id' => $record->id]) ?></h1>
<?= $this->insert('callback/_tabs') ?>


<div class="row">
    <div class="col-md-6">
        <h2><?= __('Main info') ?></h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td><?= __('Date') ?></td>
                    <td><?= Date::convertToDatetime($record->created_at, Date::FORMAT_TO_HOUR) ?></td>
                </tr>
                <tr>
                    <td><?= __('Phone') ?></td>
                    <td><?= $record->phone ?></td>
                </tr>
                <tr>
                    <td><?= __('Name') ?></td>
                    <td><?= $this->e($record->name) ?></td>
                </tr>
                <tr>
                    <td><?= __('Status') ?></td>
                    <td>
                        <?php if ($record->done): ?>
                            <span class="badge badge-success"><?= __('Processed') ?></span>
                        <?php else: ?>
                            <span class="badge badge-danger"><?= __('Waiting') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <h2><?= __('Add info') ?></h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <?php foreach ($record->more as $param => $value): ?>
                    <tr>
                        <td><?= $this->e($param) ?></td>
                        <td><?= $this->e($value) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= Url::a(['callback/close', [$record->id]], __('Close request'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php $this->stop() ?>
