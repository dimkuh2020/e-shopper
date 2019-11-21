<?php
namespace app\modules\admin\controllers;
use yii\web\Controller;
use yii\filters\AccessControl;

class AppAdminController extends Controller{

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

?>