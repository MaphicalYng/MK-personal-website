<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/2
 * Time: 下午 8:50
 */?>


<table border="1" style="background-color: lightgrey;">

    <tr>

    <?php foreach ($data[0] as $field0 => $content0):?>

            <th><?php echo $field0;?></th>

    <?php endforeach;?>

    </tr>

    <?php foreach ($data as $row):?>

    <tr>

    <?php foreach ($row as $content):?>

            <td><?php echo $content;?></td>

    <?php endforeach;?>

    </tr>

    <?php endforeach;?>

</table>

<br/>

<p>
    <a class="btn btn-primary" href="<?php echo site_url('management/database-index');?>" role="button">返回</a>
</p>
