<?php

namespace app\modules\admin;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors(){ // для закрытия доступа неавторизованым пользователям к админке
        return [    
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,     //разрешить доступ только авторизов пользователям
                        'roles' => ['@']    //@ - авторизованый пользователь, ? - неавторизованый пользователь     
                    ]
                ]
            ]
        ];
    }
}
