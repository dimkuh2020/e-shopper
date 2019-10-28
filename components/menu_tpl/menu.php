<?php use yii\helpers\Url;?>
<li>
    <a href="<?=Url::to(['category/view', 'id' => $category['id']])?>">
        <?=$category['name'];?>
        <?php if (isset($category['childs'])) : // если есть наследники то добавляем +?>
            <span class="badage pull-right"><i class="fa fa-plus"></i></span>
        <?php endif;?>
    </a>
    <?php if (isset($category['childs'])) : // если есть наследники то передаём узел данного дерева?>
        <ul>
            <?=$this->getMenuHtml($category['childs'])?>
        </ul>
    <?php endif;?>
</li>




