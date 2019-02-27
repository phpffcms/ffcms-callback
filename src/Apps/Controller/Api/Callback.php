<?php

namespace Apps\Controller\Api;

use Extend\Core\Arch\ApiController;
use Ffcms\Core\App;
use Ffcms\Core\Exception\JsonException;
use Ffcms\Core\Helper\Date;
use Ffcms\Core\Helper\FileSystem\File;
use Ffcms\Core\Helper\Type\Any;
use Ffcms\Core\Helper\Type\Str;

/**
 * Class Callback. Process ajax requests
 * @package Apps\Controller\Api
 */
class Callback extends ApiController
{
    private $rootDir;
    private $tplDir;

    /**
     * Set custom paths
     */
    public function before()
    {
        parent::before();
        $this->rootDir = realpath(__DIR__ . '/../../../');
        $this->tplDir = realpath($this->rootDir . '/Apps/View/Api/default');
        App::$View->addFallback($this->tplDir);

        $langFile = $this->rootDir . '/I18n/Api/' . App::$Request->getLanguage() . '/Callback.php';
        if (App::$Request->getLanguage() !== 'en' && File::exist($langFile)) {
            App::$Translate->append($langFile);
        }
    }

    /**
     * Process form data
     * @return array
     * @throws JsonException
     */
    public function actionSend()
    {
        $callback = $this->request->request->get('callback', null);
        if (!$callback || !Any::isArray($callback)) {
            throw new JsonException('Invalid request');
        }

        $configs = \Apps\ActiveRecord\App::getConfigs('widget', 'Callback');
        if ($configs['useCaptcha']) {
            $value = App::$Captcha->isFull() ? null : $callback['captcha'];
            if (!App::$Captcha->validate($value)) {
                throw new JsonException('Invalid captcha');
            }
        }


        $phone = $callback['phone'];
        if (!$phone || !Str::isPhone($phone)) {
            throw new JsonException('Invalid phone number');
        }
        $name = Str::sub((string)$callback['name'], 0 ,127);

        // sanitize other post fields
        unset($callback['phone'], $callback['name']);
        foreach ($callback as $k => $v) {
            $all[$k] = App::$Security->strip_tags($v);
        }


        $query = new \Apps\ActiveRecord\Callback();
        $query->phone = $phone;
        $query->name = $name;
        $query->more = $callback;
        $query->save();

        // send email
        if (App::$Mailer && Str::isEmail($configs['email'])) {
            App::$Mailer->tpl('callback/mail', [
                'id' => $query->id,
                'callback' => $callback,
                'phone' => $phone,
                'name' => $name,
                'date' => Date::convertToDatetime($query->created_at, Date::FORMAT_TO_HOUR)
            ])->send($configs['email'], (new \Swift_Message(__('New callback request for: %phone%', ['phone' => $phone]))));
        }

        return json_encode(['message' => __('Request successful send. We we call you as soon as posible!'), 'status' => 1]);
    }
}