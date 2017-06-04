<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:27
 */?>

<?php echo form_open('app/new-id');?>

    <h5>用户名</h5>
    <?php echo form_error('id');?>
    <input type="text" name="id" value="<?php echo set_value('id');?>">

    <h5>密码</h5>
    <?php echo form_error('password');?>
    <input type="text" name="password" value="<?php echo set_value('password');?>">

    <h5>确认密码</h5>
    <?php echo form_error('c_password');?>
    <input type="text" name="c_password" value="<?php echo set_value('c_password');?>">

    <h5>邮箱</h5>
    <?php echo form_error('email');?>
    <input type="text" name="email" value="<?php echo set_value('email');?>">

    <br/><br/>

    <input type="submit" value="提交">

</form>
<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/index_d');?>" role="button">返回主页</a>
</p>

<br/>
