<?php
namespace app\controllers;

//схема корзины
/*Array
(
    [1] => Array // 1 - id товара
    (
        [qty] => QTY,  //колличество товара
        [name] => NAME,
        [prie] => PRICE,
        [img] => IMAGE
    )
    [10] => Array // 10 - id товара
    (
        [qty] => QTY,  //колличество товара
        [name] => NAME,
        [prie] => PRICE,
        [img] => IMAGE
    )

)
    [qty] => QTY, // общее колличество 
    [sum] => SUM   // общая сумма
);*/

use app\models\Cart;
use app\models\Product;  
use Yii;

class CartController extends AppController{

    public function actionAdd(){
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if(empty($product)) return false;
        
        $session = Yii::$app->session; // начинаем ссесию через Yii
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product);
        $this->layout = false;

        //debug($session['cart']);
        //debug($session['cart.qty']);
        //debug($session['cart.sum']);

        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear(){  //очистка корзины в модальном окне
        $session = Yii::$app->session; // начинаем ссесию через Yii
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }


}
?>