<?php

namespace Apps\Model\Front\Callback;


use Ffcms\Core\Arch\Model;

/**
 * Class FormAbstractCallback
 * @package Apps\Model\Front\Callback
 */
class FormAbstractCallback extends Model
{
    protected $_sendMethod = 'GET';

    public $name;
    public $phone;
    public $url;
    public $message;

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'phone'], 'required'],
            [['url', 'message'], 'used']
        ];
    }

}