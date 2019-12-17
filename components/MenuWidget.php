<?php
namespace app\components;

use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget{
    
    public $tpl; //шаблон для init()
    public $data; //хранятся все категории в массиве
    public $tree; // хранится результат функции в массив дерева
    public $menuHtml; // хранение хтмл код в $tpl
    public $model;

    public function init(){
        parent::init();
        if($this->tpl === null){
            $this->tpl = 'menu';
        }
        $this->tpl.='.php';
    }

    public function run(){
        //get cache
        if($this->tpl == 'menu.php'){  
            $menu = Yii::$app->cache->get('menu'); // (1)кеш для menu.php
            if($menu) return $menu;
        }        

        $this->data = Category::find()->indexBy('id')->asArray()->all(); //в дату всё из категорий
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree); //передаём дерево
        //debug($this->tree);

        //set cache
        if($this->tpl == 'menu.php'){ // (2)кеш для menu.php
        Yii::$app->cache->set('menu', $this->menuHtml, 60); // время 1 мин
        }

        return $this->menuHtml;
    }

    protected function getTree(){  // для получения дочерних узлов дерева.
        $tree = [];
        foreach($this->data as $id=>&$node){
            if(!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''){  //для получения в хтмл
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab){  // возвращает буффкризированый вывод в $str
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}

?>