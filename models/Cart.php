<?php
namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord{

    public function addToCart($product, $qty = 1){ // колличество $qty по умолчанию 1
        if(isset($_SESSION['cart'][$product->id])){
            $_SESSION['cart'][$product->id]['qty'] += $qty;  //присваиваем колличество + 1
        }else{
            $_SESSION['cart'][$product->id] = [ //или добавляем данніе в сессию
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty; // общее колличество 
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;// общая сумма 
    }

    public function recalc($id){  //метода для изменения колличества товаров и общей суммы
        if(!isset($_SESSION['cart'][$id])) return false;
        $qtyMinus =  $_SESSION['cart'][$id]['qty'];
        $sumMinus =  $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset( $_SESSION['cart'][$id]);
    }

    


}

?>