<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 5:01
 */?>
<h3>您的所有条目</h3>

<?php foreach ($data as $item):?>

    <h4><?php echo $item->item;?></h4><p><?php echo $item->content;?></p>

<?php endforeach;?>

<br/>

<p><?php echo anchor('app/log-in', '返回');?>  <?php echo anchor('app/delete', '删除条目');?></p>