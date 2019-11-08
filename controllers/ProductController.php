<?php
namespace app\controllers;

use app\models\Category;
use app\models\Product;  
use Yii;


class ProductController extends AppController{

    public function actionView($id){        
        $id = Yii::$app->request->get(); // выбрать всё из бд по id
        $product = Product::findOne($id); // ленивая загрузка
                //или жадная
        //$product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();

        return $this->render('view', compact('product'));
    }

}

?>