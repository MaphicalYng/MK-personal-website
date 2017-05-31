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
        show_error('test', 500);
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
