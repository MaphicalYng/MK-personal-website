<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 9:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Temp extends CI_Controller
{




    public function __construct()
    {
        parent::__construct();
        $this->load->model('temp_model');
        $this->load->library('email');
    }




    public function initialize_db()
    {

        $same = $this->temp_model->initialize_db();
        foreach ($same as $item)
        {
            if ($item->item === 'title')  // 用户名存在。
            {
                echo 'found';
            }
        }
    }

    /**
     *
     */
    public function temp()
    {
        $prefs['template'] = '
	    {table_open}<table border="1" cellpadding="0" cellspacing="0" style="background-color: grey;">{/table_open}
	    {heading_row_start}<tr>{/heading_row_start}
	    {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
	    {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
	    {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
	    {heading_row_end}</tr>{/heading_row_end}
	    {week_row_start}<tr>{/week_row_start}
	    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
	    {week_row_end}</tr>{/week_row_end}
	    {cal_row_start}<tr>{/cal_row_start}
	    {cal_cell_start}<td>{/cal_cell_start}
	    {cal_cell_start_today}<td>{/cal_cell_start_today}
	    {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}
	    {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
	    {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
	    {cal_cell_no_content}{day}{/cal_cell_no_content}
	    {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
	    {cal_cell_blank}&nbsp;{/cal_cell_blank}
	    {cal_cell_other}{day}{/cal_cel_other}
	    {cal_cell_end}</td>{/cal_cell_end}
	    {cal_cell_end_today}</td>{/cal_cell_end_today}
	    {cal_cell_end_other}</td>{/cal_cell_end_other}
	    {cal_row_end}</tr>{/cal_row_end}
	    {table_close}</table>{/table_close}
	';

	$this->load->library('calendar', $prefs);

	$data = array(
		31 => 'https://www.baidu.com',
	);
	echo $this->calendar->generate(2017,5,$data);
    }

    public function email()
    {
        $config['protocol'] = 'smtp';
        $config['mailpath'] = "C:\\xampp\\sendmail\\";
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('msatarchibald@foxmail.com', 'Test');
        $this->email->to('msatarchibald@foxmail.com');
        $this->email->subject('test');
        $this->email->message('This is a test.');
        if ($this->email->send())
        {
            echo 'ok';
        }
        else
        {
            echo 'no';
        }

    }
}
