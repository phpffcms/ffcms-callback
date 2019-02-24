<?php

namespace Apps\Controller\Api;

use Extend\Core\Arch\ApiController;

class Callback extends ApiController
{
    /**
     * Process form data
     * @return array
     */
    public function actionSend()
    {
        return json_encode(['message' => 'test', 'status' => 1]);
    }
}