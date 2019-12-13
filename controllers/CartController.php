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
use app\models\Order;
use app\models\OrderItems;  
use Yii;

class CartController extends AppController{

    public function actionAdd(){
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty'); // получение количества товаров ро id из карточки товара
        $qty = !$qty ? 1: $qty; // если false - кладём 1 иначе то что приходит

        $product = Product::findOne($id);
        if(empty($product)) return false;
        
        $session = Yii::$app->session; // начинаем ссесию через Yii
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if(!Yii::$app->request->isAjax){  // для выполнение без ajax 
                return $this->redirect(Yii::$app->request->referrer);
        }
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

    public function actionDelItem(){
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session; // начинаем ссесию через Yii
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow(){
        $session = Yii::$app->session; // начинаем ссесию через Yii
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView(){
       // debug(Yii::$app->params['adminEmail']); // админский адрес (config\params.php)

        $session = Yii::$app->session; // начинаем ссесию через Yii, берём корзину
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if($order->load(Yii::$app->request->post())){
           $order->qty = $session['cart.qty'];  //данные по колличеству
           $order->sum = $session['cart.sum'];  // данные по сумме
           if($order->save()){         //сохранение заказа
                $this->saveOrderItems($session['cart'], $order->id);
                Yii::$app->session->setFlash('success', 'Ваш заказ принят.'); // флешка 
                Yii::$app->mailer->compose('order', ['session' => $session]) // отправка почты (\mail\layout\order.php) + изменения в web.php
                            ->setFrom(['dimkuh1985@gmail.com' => 'e-shopper'])
                            ->setTo($order->email)   //  или на админский адрес Yii::$app->params['adminEmail']; (config\params.php)
                            ->setSubject('Заказ')
                            ->setTextBody('Бла бла') // не обязательно
                            ->setHtmlBody('<b>текст сообщения в формате HTML</b>') // не обязательно
                            ->send();
                $session->remove('cart');    //очистка корзины после оформления заказа
                $session->remove('cart.qty'); //..
                $session->remove('cart.sum'); //..
                return $this->refresh();               
           }else{
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа.'); // флешка 
           }
        }        
        
        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $order_id){ //метод лоя получения id заказа
        foreach($items as $id=>$item){
            $order_items = new OrderItems(); //запись в order_items
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty']*$item['price'];
            $order_items->save(); 
        }
    }


}
?>