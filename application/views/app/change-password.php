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
<br/>
<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/log-in');?>" role="button">返回</a>
</p>

<br/>
