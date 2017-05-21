<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 5:01
 */?>
<h3>您的所有条目</h3>

<dl>

<?php foreach ($data as $item):?>
<hr/>
    <dt><?php echo $item->item;?></dt>
    <dd><?php echo $item->content;?></dd>
<hr/>
<?php endforeach;?>

</dl>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/log-in');?>" role="button">返回</a>
    <a class="btn btn-primary" href="<?php echo site_url('app/delete');?>" role="button">删除条目</a>
</p>

