<?php

namespace Apps\ActiveRecord;


use Ffcms\Core\Arch\ActiveModel;

/**
 * Class Callback
 * @package Apps\ActiveRecord
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property array $more
 * @property boolean $done
 * @property string $created_at
 * @property string $updated_at
 */
class Callback extends ActiveModel
{
    protected $casts = [
        'more' => 'serialize',
        'done' => 'boolean'
    ];

}