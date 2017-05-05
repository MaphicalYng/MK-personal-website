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
        $same = $this->db->query('show tables')->result();
        foreach ($same as $item)
        {
            if ($item->Tables_in_test === $id_info['id'])
            {
                return 'already';
            }
        }


        /*
         * 构造查询器创建表。
         * */
        $this->db->query('create table '.$id_info['id'].' (item varchar(128), content text)');


        /*
         * 将密码（加密后）和邮箱存储到数据库中。
         * */
        $this->db->insert($id_info['id'], array(
            'item' => 'password',
            'content' => password_hash($id_info['password'], PASSWORD_DEFAULT)
        ));
        $this->db->insert($id_info['id'], array(
            'item' => 'email',
            'content' => $id_info['email']
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
        $same = $this->db->query('show tables')->result();
        foreach ($same as $item)
        {
            if ($item->Tables_in_test === $id_info['id'])  // 用户名存在。
            {
                $result['exist'] = TRUE;
                $pa = $this->db->query('select content from '.$id_info['id'].' where '.$id_info['id'].'.item="password"')->result();
                $result['password'] = $pa['0']->content;
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
            return 'no data';
        }
        if ((!element('type', $data_info, FALSE)) AND (!element('id', $data_info, FALSE)))
        {
            return 'type id least';
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
            $query = $this->db->query('select * from '.$data_info['id'].' where '.$data_info['id'].'.item!="password" and '.$data_info['id'].'.item!="email"')->result();
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
            $same = $this->db->query('select item from '.$data_info['id'])->result();
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
            $this->db->query('delete from '.$data_info['id'].' where item="'.$data_info['item'].'"');
        }
    }
}