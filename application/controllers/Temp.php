<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 9:53
 */
class Temp extends CI_Controller
{




    public function __construct()
    {
        parent::__construct();
        $this->load->model('temp_model');
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
}
