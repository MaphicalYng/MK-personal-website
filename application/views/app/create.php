<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 下午 5:12
 */?>

<?php echo validation_errors();?>

<?php echo form_open('app/create');?>

    <h5>标题：</h5>
    <input type="text" name="item" value="">

    <h5>内容：</h5>
    <textarea name="content" ></textarea>

    <br/><br/>

    <input type="submit" value="提交">

</form>

<?php echo anchor('app/log-in', '返回');?>

<br/>