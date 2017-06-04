<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 上午 10:37
 */?>

<?php echo form_open('app/log-in');?>

    <h5>用户名</h5>
    <?php echo form_error('id');?>
    <input type="text" name="id" value="<?php echo set_value('id');?>">

    <h5>密码</h5>
    <?php echo form_error('password');?>
    <input type="text" name="password" value="<?php echo set_value('password');?>">

    <br/><br/>

    <input type="submit" value="登录">

</form>

<br/>
<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/index-d');?>" role="button">返回主页</a>
</p>


<br/>
