<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/2
 * Time: 下午 1:35
 */?>

<br/>

<h4><b>查询</b></h4>

<hr>

<?php echo form_open('management/database-index/query');?>

    <h5>数据表</h5>
    <?php echo form_error('table_query');?>
    <input type="text" name="table_query" value="<?php echo set_value('table_query');?>">

    <h5>域名</h5>
    <?php echo form_error('field_query');?>
    <input type="text" name="field_query" value="<?php echo set_value('field_query');?>">

    <h5>条件</h5>
    <?php echo form_error('where_query');?>
    <input type="text" name="where_query" value="<?php echo set_value('where_query');?>">

<br/><br/>

    <input type="submit" value="查询">

</form>

<br/>

<h4><b>插入</b></h4>

<hr>

<?php echo form_open('management/database-index/insert');?>

    <h5>数据表</h5>
    <?php echo form_error('table_insert');?>
    <input type="text" name="table_insert" value="<?php echo set_value('table_insert');?>">

    <h5>值</h5>
    <?php echo form_error('value_insert');?>
    <input type="text" name="value_insert" value="<?php echo set_value('value_insert');?>">

<br/><br/>

    <input type="submit" value="插入">

</form>

<br/>

<h4><b>修改</b></h4>

<hr>

<?php echo form_open('management/database-index/modify');?>

    <h5>数据表</h5>
    <?php echo form_error('table_modify');?>
    <input type="text" name="table_modify" value="<?php echo set_value('table_modify');?>">

    <h5>欲修改域名</h5>
    <?php echo form_error('field_modify');?>
    <input type="text" name="field_modify" value="<?php echo set_value('field_modify');?>">

    <h5>条件</h5>
    <?php echo form_error('where_modify');?>
    <input type="text" name="where_modify" value="<?php echo set_value('where_modify');?>">

    <h5>新值</h5>
    <?php echo form_error('value_modify');?>
    <input type="text" name="value_modify" value="<?php echo set_value('value_modify');?>">

<br/><br/>

    <input type="submit" value="修改">

</form>

<br/>

<h4><b>删除</b></h4>

<hr>

<?php echo form_open('management/database-index/delete');?>

    <h5>数据表</h5>
    <?php echo form_error('table_delete');?>
    <input type="text" name="table_delete" value="<?php echo set_value('table_delete');?>">

    <h5>条件</h5>
    <?php echo form_error('where_delete');?>
    <input type="text" name="where_delete" value="<?php echo set_value('where_delete');?>">

<br/><br/>

    <input type="submit" value="删除">

</form>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('management');?>" role="button">返回</a>
</p>
