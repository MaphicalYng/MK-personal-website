<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 1:01
 */?>

<h3>您可以使用以下功能</h3>

<p><?php echo anchor('app/create', '创建新条目');?>  <?php echo anchor('app/view', '已有条目');?></p>

<p><?php echo anchor('app', '返回主页（退出）');?></p>

<p><i>注：当您退回到主页，您将默认为退出状态。</i></p>