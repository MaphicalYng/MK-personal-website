<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/1
 * Time: 上午 10:49
 */?>
<p><?php echo $error_info;?></p>

<p><?php echo anchor('app/new-id', '注册');?>  <?php echo anchor('app/log-in', '登录');?></p>

<p><?php echo anchor('app', '返回主页');?></p>
<p>
    <a class="btn btn-primary" href="<?php echo site_url('app/new-id');?>" role="button">创建新条目</a>
    <a class="btn btn-primary" href="<?php echo site_url('app/log-in');?>" role="button">已有条目</a>
    <a class="btn btn-primary" href="<?php echo site_url('app');?>" role="button">修改密码</a>
</p>
