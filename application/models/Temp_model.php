<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:03
 */
class Temp_model extends CI_Model
{




    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }




    public function initialize_db()
    {
        $same = $this->db->query('select item from archibald')->result();
        return $same;
    }
}