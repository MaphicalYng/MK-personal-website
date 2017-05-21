<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/20
 * Time: 下午 7:47
 */?>

<?php echo validation_errors();?>

<?php echo form_open('app/change_password');?>

    <h5>用户名</h5>
    <input type="text" name="id" value="">

    <h5>原密码</h5>
    <input type="text" name="old_password" value="">

    <h5>新密码</h5>
    <input type="text" name="new_password" value="">

    <br/><br/>

    <input type="submit" value="提交">

</form>

<p><?php echo anchor('app/log-in', '返回');?> <?php echo anchor('app', '退出');?></p>

<br/>
