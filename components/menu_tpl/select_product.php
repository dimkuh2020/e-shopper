<!--выпадающий список для продуктов-->
<option value="<?= $category['id']?>" 
    <?php if($category['id'] == $this->model->category_id) echo 'selected'?>
    ><?=$tab . $category['name']?></option>
<?php if (isset($category['childs'])) : // если есть наследники то передаём узел данного дерева?>
        <ul>
            <?=$this->getMenuHtml($category['childs'], $tab . '-')?>
        </ul>
<?php endif;?>