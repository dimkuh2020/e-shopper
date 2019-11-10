<?php
namespace app\controllers;

use app\models\Category;
use app\models\Product;  
use Yii;


class ProductController extends AppController{

    public function actionView($id){        
        //$id = Yii::$app->request->get(); // выбрать всё из бд по id  //можно без него.
        $product = Product::findOne($id); // ленивая загрузка
        //или жадная
        //$product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();

        if(empty($product))  //404 ошибка если нету категории
            throw new \yii\web\HttpException(404, 'Нема продукта(((');
                
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all(); 
        $this->setMeta('E-SHOPPER | ' . $product->name, $product->keywords, $product->description);

        return $this->render('view', compact('product', 'hits'));
    }

}

?>