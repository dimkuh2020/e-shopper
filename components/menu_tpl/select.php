<option value="<?= $category['id']?>" 
    <?php if($category['id'] == $this->model->parent_id) echo 'selected'?>
    <?php if($category['id'] == $this->model->id) echo 'disabled'?>
    ><?=$tab . $category['name']?></option>
<?php if (isset($category['childs'])) : // если есть наследники то передаём узел данного дерева?>
        <ul>
            <?=$this->getMenuHtml($category['childs'], $tab . '-')?>
        </ul>
<?php endif;?>

