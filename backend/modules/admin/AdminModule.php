<?php

namespace backend\modules\admin;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\admin\controllers';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
        $this->layout = 'main';
    }
}