<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 5:12
 */?>

<?php echo form_open('app/create');?>

    <h5>标题：</h5>
    <?php echo form_error('item');?>
    <input type="text" name="item" value="<?php echo set_value('item');?>">

    <h5>内容：</h5>
    <?php echo form_error('content');?>
    <textarea name="content" cols="60" rows="6"></textarea>

    <br/><br/>

    <input type="submit" value="提交">

</form>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/log-in');?>" role="button">返回</a>
</p>

<br/>
