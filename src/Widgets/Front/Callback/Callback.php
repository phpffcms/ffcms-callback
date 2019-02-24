<?php

namespace Widgets\Front\Callback;

use Apps\Model\Front\Callback\FormAbstractCallback;
use Ffcms\Core\App;
use Ffcms\Core\Arch\Widget;


/**
 * Class Callback
 * @package Widgets\Callback
 */
class Callback extends Widget
{
    public $tpl = 'form_post';

    private $rootDir;
    private $tplDir;

    public function init(): void
    {
        if (App::$Request->getLanguage() !== 'en') {
            //App::$Translate->append('/i18n/Front/' . App::$Request->getLanguage() . '/CommentWidget.php');
        }

        $this->rootDir = realpath(__DIR__ . '/../../../');
        $this->tplDir = realpath($this->rootDir . '/Apps/View/Front/default');
    }

    /**
     * @return string|null
     */
    public function display(): ?string
    {
        $model = new FormAbstractCallback();

        return App::$View->render('widgets/callback/' . $this->tpl, [
            'model' => $model
        ], $this->tplDir);
    }
}