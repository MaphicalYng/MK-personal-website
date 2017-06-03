<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/2
 * Time: 下午 11:21
 */?>

<br/>

<?php echo form_open('management/features-index/valued');?>

    <h5>数据库选择（默认为原值）</h5>
    <input type="text" name="database" value="<?php echo html_escape($database);?>" size="50px">

    <h5>默认路由（默认为原值）</h5>
    <input type="text" name="route" value="<?php echo html_escape($route);?>" size="50px">

    <h5>基本地址（默认为原值）</h5>
    <input type="text" name="address" value="<?php echo html_escape($address);?>" size="50px">

    <h5>会话文件路径（默认为原值）</h5>
    <input type="text" name="session_path" value="<?php echo html_escape($session_path);?>" size="50px">

    <h5>会话持续秒数（默认为原值）</h5>
    <input type="text" name="session_lasting" value="<?php echo html_escape($session_lasting);?>" size="50px">

    <h5>日志功能（1/0，默认为原值）</h5>
    <input type="text" name="log_on" value="<?php echo html_escape($log_on);?>" size="50px">

    <h5>访问日志路径（默认为原值）</h5>
    <input type="text" name="log_path" value="<?php echo html_escape($log_path);?>" size="50px">

<br/><br/>

    <input type="submit" value="提交">

</form>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('management');?>" role="button">返回</a>
</p>
