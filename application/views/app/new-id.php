<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:27
 */?>

<?php echo validation_errors();?>

<?php echo form_open('app/new_id');?>

    <h5>用户名</h5>
    <input type="text" name="id" value="">

    <h5>密码</h5>
    <input type="text" name="password" value="">

    <h5>邮箱</h5>
    <input type="text" name="email" value="">

    <br/><br/>

    <input type="submit" value="提交">

</form>
<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('app');?>" role="button">返回主页</a>
</p>

<br/>
