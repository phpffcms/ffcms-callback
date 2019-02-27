<?php

namespace Apps\Controller\Admin;

use Apps\ActiveRecord\App as AppRecord;
use Extend\Core\Arch\AdminController;
use Ffcms\Core\App;
use Ffcms\Core\Exception\NotFoundException;
use Ffcms\Core\Helper\FileSystem\File;
use Ffcms\Core\Helper\Serialize;
use Ffcms\Core\Managers\MigrationsManager;
use Apps\Model\Admin\Callback\FormSettings;


/**
 * Class Callback
 * @package Apps\Controller\Admin
 */
class Callback extends AdminController
{
    const VERSION = '1.0.0';
    const ITEM_PER_PAGE = 25;

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
        $this->tplRoot = realpath($this->appRoot . '/Apps/View/Admin/default');
        $langFile = $this->appRoot . '/I18n/Admin/' . App::$Request->getLanguage() . '/Callback.php';
        if (App::$Request->getLanguage() !== 'en' && File::exist($langFile)) {
            App::$Translate->append($langFile);
        }

        $this->view->addFallback($this->tplRoot);
    }

    /**
     * Render index page
     * @return string
     */
    public function actionIndex(): ?string
    {
        $page = (int)$this->request->query->get('page', 0);
        $offset = $page * static::ITEM_PER_PAGE;

        // get records from db
        $records = \Apps\ActiveRecord\Callback::orderBy('done', 'ASC')
            ->orderBy('id', 'DESC')
            ->take(static::ITEM_PER_PAGE)
            ->skip($offset)
            ->get();

        return $this->view->render('callback/index', [
            'records' => $records,
            'pagination' => [
                'page' => $page,
                'total' => \Apps\ActiveRecord\Callback::count(),
                'step' => static::ITEM_PER_PAGE,
                'url' => ['callback/index']
            ],
            'tplDir' => $this->tplRoot
        ], $this->tplRoot);
    }

    /**
     * Close callback request
     * @param $id
     * @throws NotFoundException
     */
    public function actionClose($id)
    {
        $record = \Apps\ActiveRecord\Callback::find($id);
        if (!$record || $record->done !== false) {
            throw new NotFoundException(__('Nothing found'));
        }

        $record->done = true;
        $record->save();
        
        $this->response->redirect('callback/index');
    }

    public function actionSettings()
    {
        // init model with config array data
        $model = new FormSettings($this->getConfigs());

        // check if form is submited
        if ($model->send()) {
            if ($model->validate()) {
                $this->setConfigs($model->getAllProperties());
                App::$Session->getFlashBag()->add('success', __('Settings is successful updated'));
                $this->response->redirect('callback/index');
            } else {
                App::$Session->getFlashBag()->add('error', __('Form validation is failed'));
            }
        }

        // render response
        return $this->view->render('callback/settings', [
            'model' => $model
        ]);
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