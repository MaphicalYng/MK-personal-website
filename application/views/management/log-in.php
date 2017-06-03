<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/1
 * Time: 下午 7:42
 */

echo validation_errors();?>

<?php echo form_open('management/index');?>

    <h5>密码</h5>
    <input type="text" name="password" value="<?php echo set_value('password');?>">

    <br/><br/>

    <input type="submit" value="登录">

</form>

<br/>
<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/index');?>" role="button">网站主页</a>
</p>


<br/>
