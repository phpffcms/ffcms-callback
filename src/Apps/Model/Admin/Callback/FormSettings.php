<?php

namespace Apps\Model\Admin\Callback;


use Ffcms\Core\Arch\Model;

/**
 * Class FormSettings. Callback settings
 * @package Apps\Model\Admin\Callback
 */
class FormSettings extends Model
{
    public $useCaptcha;
    public $email;

    private $_configs;

    /**
     * FormSettings constructor. Pass config values from controller
     * @param array|null $configs
     */
    public function __construct(array $configs = null)
    {
        $this->_configs = $configs;
        parent::__construct();
    }

    /**
     * Set model properties based on defaults config values
     */
    public function before()
    {
        if (!$this->_configs) {
            return;
        }

        foreach ($this->_configs as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Form display labels
     * @return array
     */
    public function labels(): array
    {
        return [
            'useCaptcha' => __('Captcha'),
            'email' => __('Notification mail')
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules(): array
    {
        return [
            ['useCaptcha', 'required'],
            ['email', 'used'],
            ['useCaptcha', 'boolean'],
            ['email', 'email']
        ];
    }
}