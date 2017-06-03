<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/1
 * Time: 下午 7:39
 */
class Management_model extends CI_Model
{
    /**
     * Management_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $password
     * @return bool
     */
    public function verify($password)
    {

        // 从数据库获取密码。
        $query = $this->db->query('SELECT * FROM administrator')->result()[0];
        if (password_verify($password, $query->password))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * @param null $db
     * @return string
     */
    public function database($db = NULL)
    {
        if ($db === NULL)
        {
            return 'no-data';
        }

        // 查询特定数据。
        if ($db['type'] === 'query')
        {
            if ($db['field'] === '') $db['field'] = '*';            // 没有选择域，默认为所有域。
            if ($db['where'] === '')                                // 没有附加条件。
            {
                $write = 'SELECT '.$db['field'].' FROM '.$db['table'];
                return $this->db->query($write);
            }
            else                                                    // 有附加条件。
            {
                $write = 'SELECT '.$db['field'].' FROM '.$db['table'].' WHERE '.$db['where'];
                return $this->db->query($write);
            }

        }

        // 插入数据。
        if ($db['type'] === 'insert')
        {
            $write = 'INSERT INTO '.$db['table'].' VALUE ('.$db['value'].')';
            $this->db->query($write);
        }

        // 修改数据。
        if ($db['type'] === 'modify')
        {
            $write = 'UPDATE '.$db['table'].' SET '.$db['field'].'="'.$db['value'].'"'.' WHERE '.$db['where'];
            $this->db->query($write);
        }

        // 删除数据。
        if ($db['type'] === 'delete')
        {
            if ($db['where'] === '')                                // 没有附加条件。
            {
                $write = 'DELETE FROM '.$db['table'];
                $this->db->query($write);
            }
            else                                                    // 有附加条件。
            {
                $write = 'DELETE FROM '.$db['table'].' WHERE '.$db['where'];
                $this->db->query($write);
            }

        }
    }

    /**
     * initialize the database.
     */
    public function init()
    {
        $pswd = password_hash('Iloveyou152', PASSWORD_DEFAULT);
        $this->db->insert('administrator',array(
            'password' => $pswd
        ));
    }

    /**
     * @param $table_name
     * @return bool
     */
    public function check_table($table_name)
    {
        if ($table_name === 'administrator')
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}