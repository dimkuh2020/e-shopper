<?php
 namespace app\controllers;

 use app\models\Category;
 use app\models\Product;
 use yii\data\Pagination;
 
 use Yii;

 class CategoryController extends AppController{
      
    public function actionIndex(){
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all(); // найти все шесть товаров где стоит знак 1 на hits (хит сезона)
        //debug($hits);
        $this->setMeta('E-SHOPPER');

        return $this->render('index', compact('hits'));
    }

    public function actionView($id){ //для получения всех товаров по категориям при клике на категории
        $id = Yii::$app->request->get('id');
        //$products = Product::find()->where(['category_id' => $id])->all();

        //для пагин
        $query = Product::find()->where(['category_id' => $id]); 
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $category = Category::findOne($id);
        $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);

        return $this->render('view', compact('products', 'pages', 'category'));

    }

 }

?>