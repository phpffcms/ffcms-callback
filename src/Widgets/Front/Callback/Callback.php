<?php

namespace Widgets\Front\Callback;

use Ffcms\Core\App;
use Ffcms\Core\Arch\Widget;


/**
 * Class Callback
 * @package Widgets\Callback
 */
class Callback extends Widget
{
    public $tpl = 'form_ajax';
    public $tplParams = [];

    private $rootDir;
    private $tplDir;

    private $configs;

    public function init(): void
    {
        if (App::$Request->getLanguage() !== 'en') {
            //App::$Translate->append('/i18n/Front/' . App::$Request->getLanguage() . '/CommentWidget.php');
        }

        $this->rootDir = realpath(__DIR__ . '/../../../');
        $this->tplDir = realpath($this->rootDir . '/Apps/View/Front/default');
        App::$View->addFallback($this->tplDir);
        $this->configs = $this->getConfigs();
    }

    /**
     * @return string|null
     */
    public function display(): ?string
    {
        return App::$View->render('widgets/callback/' . $this->tpl, [
            'configs' => $this->configs,
            'params' => $this->tplParams
        ]);
    }
}