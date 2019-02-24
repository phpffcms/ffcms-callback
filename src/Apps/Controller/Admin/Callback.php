<?php

namespace Apps\Controller\Admin;

use Apps\ActiveRecord\App as AppRecord;
use Extend\Core\Arch\AdminController;
use Ffcms\Core\App;
use Ffcms\Core\Helper\FileSystem\File;
use Ffcms\Core\Helper\Serialize;
use Ffcms\Core\Managers\MigrationsManager;


/**
 * Class Callback
 * @package Apps\Controller\Admin
 */
class Callback extends AdminController
{
    const VERSION = '1.0.0';

    public $type = 'widget';

    private $appRoot;
    private $tplRoot;

    /**
     * Make before preset
     */
    public function before()
    {
        parent::before();

        $this->appRoot = realpath(__DIR__ . '/../../../');
        $this->tplRoot = realpath($this->appRoot . '/Apps/View/Admin/default/callback');
        $langFile = $this->appRoot . '/I18n/Admin/' . App::$Request->getLanguage() . '/Demoapp.php';
        if (App::$Request->getLanguage() !== 'en' && File::exist($langFile)) {
            App::$Translate->append($langFile);
        }
    }

    public function actionIndex()
    {

    }


    /**
     * Installation features
     */
    public static function install()
    {
        // prepare application information to extend inserted before row to table apps
        $appData = new \stdClass();
        $appData->configs = [
            'useCaptcha' => true
        ];
        $appData->name = [
            'ru' => 'Обратный звонок',
            'en' => 'Call back'
        ];

        $query = AppRecord::where('type', 'widget')->where('sys_name', 'Callback');
        if ($query->count() !== 1) {
            return;
        }

        $query->update([
            'name' => Serialize::encode($appData->name),
            'configs' => Serialize::encode($appData->configs),
            'disabled' => 0
        ]);
        $root = realpath(__DIR__ . '/../../../');
        // implement migrations
        $manager = new MigrationsManager($root . '/Private/Migrations/');
        $manager->makeUp([
            'install_callback_table-2019-02-23-18-23-10.php'
        ]);
    }
}