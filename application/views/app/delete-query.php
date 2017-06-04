<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 10:40
 */?>

<?php echo form_open('app/delete');?>

    <h5>需要删除的条目标题</h5>
    <?php echo form_error('item');?>
    <input type="text" name="item" value="<?php echo set_value('item');?>">

    <br/><br/>

    <input type="submit" value="提交">

</form>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/view');?>" role="button">返回</a>
</p>
