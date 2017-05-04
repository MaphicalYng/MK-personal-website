<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:27
 */?>

<?php echo validation_errors();?>

<?php echo form_open('app/new_id');?>

    <h5>用户名（不支持空格）</h5>
    <input type="text" name="id" value="">

    <h5>密码（不支持空格）</h5>
    <input type="text" name="password" value="">

    <h5>邮箱</h5>
    <input type="text" name="email" value="">

    <br/><br/>

    <input type="submit" value="提交">

</form>

<?php echo anchor('app', '返回主页'); // @todo 或许可以在此使用验证码功能。?>

<br/>