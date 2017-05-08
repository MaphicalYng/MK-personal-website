<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:14
 */
class App_model extends CI_Model
{




    /*
     * 初始化模型并连接数据库。
     * */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }




    /*
     * 创建用户，为新用户创建一个表，并以用户 id 命名。
     * */
    public function new_id($id_info)
    {


        /*
         * 检查是否已有相同用户名存在。
         * */
        $same = $this->db->query('SELECT user FROM user')->result();
        foreach ($same as $item)
        {
            if ($item->user === $id_info['id'])
            {
                return 'already';
            }
        }


        /*
         * 将密码（加密后）和邮箱存储到数据库中。
         * */
        $this->db->insert('user', array(
            'user' => $id_info['id'],
            'password' => password_hash($id_info['password'], PASSWORD_DEFAULT),
            'email' => $id_info['email']
        ));
    }




    /*
     * 登录功能，遍历数据库寻找用户名并返回存在情况，貌似效率太低？
     * */
    public function log_in($id_info)
    {


        /*
         * 检查是否有相同用户名存在。
         * */
        $same = $this->db->query('SELECT user FROM user')->result();
        foreach ($same as $item)
        {
            if ($item->user === $id_info['id'])  // 用户名存在。
            {
                $result['exist'] = TRUE;
                $pa = $this->db->query('SELECT password FROM user WHERE user.user="'.$id_info['id'].'"')->result();
                $result['password'] = $pa['0']->password;
                return $result;  // 返回存在情况和密码。
            }
        }
        $result['exist'] = FALSE;
        $result['password'] = NULL;
        return $result;
    }




    /*
     * 登录后功能的通用模型（插入、提取和删除数据）。
     * */
    public function universal($data_info = FALSE)  // 参数包括：type, id, item, content 。
    {                                               // 按需返回。


        /*
         * 加载数组辅助函数。
         * */
        $this->load->helper('array');


        /*
         * 检查参数防止不完整参数对数据库的影响。
         * */
        if ($data_info === FALSE)
        {
            log_message('error', 'No data get. (FROM App_model/universal);');
            show_error('缺少数据。（App_model/universal）。', 500);
        }
        if ((!element('type', $data_info, FALSE))
            OR (!element('id', $data_info, FALSE)))
        {
            log_message('error', 'Data format error. (FROM App_model/universal);');
            show_error('数据格式错误（App_model/universal）。', 500);
        }



        /*
         * 插入操作。
         * */
        if ($data_info['type'] === 'insert')
        {
            $data = array(
                'item' => $data_info['item'],
                'content' => $data_info['content']
            );
            $this->db->insert($data_info['id'], $data);
        }


        /*
         * 提取操作。
         * */
        if ($data_info['type'] === 'query')
        {
            $query = $this->db->query('SELECT * FROM '.$data_info['id'].
                ' WHERE '.$data_info['id'].'.item!="password" AND '.$data_info['id'].'.item!="email"')->result();
            return $query;
        }


        /*
         * 删除数据。
         * */
        if ($data_info['type'] === 'delete')
        {


            /*
             * 查询是否有此记录。
             * */
            $flag = FALSE;
            $same = $this->db->query('SELECT item FROM '.$data_info['id'])->result();
            foreach ($same as $item)
            {
                if ($item->item === $data_info['item'])  // 条目存在。
                {
                    $flag = TRUE;
                }
            }
            if (!$flag)
            {
                return 'not-found';
            }


            /*
             * 删除操作。
             * */
            $this->db->query('DELETE FROM '.$data_info['id'].
                ' WHERE item="'.$data_info['item'].'"');
        }
    }
}
