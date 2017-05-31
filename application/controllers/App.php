<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:13
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class App extends CI_Controller
{




    /*
     * 构造类并加载模型和类库。
     * */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->library(array('session', 'form_validation'));
	$this->load->helper(array('url', 'form'));
    }




    /*
     * 网站欢迎页面和介绍信息。
     * */
    public function index()
    {


        /*
         * 需要表单验证库、表单和路径辅助函数。
         * */
        // 对访问记录日志。
        $handle = fopen(MaphicalYng__log_path, 'ab');
        if ( ! $handle)
        {
            log_message('info', 'The log file is not able to open!');
            goto log_fail;
        }
        date_default_timezone_set('Asia/Shanghai');
        $write = 'View: '.date(DATE_COOKIE)."\r\n";
        fwrite($handle, $write);
        fclose($handle);
        log_fail:


        /*
         * 若已经登陆则转到操作页面。
         * */
        if (isset($_SESSION['id']))
        {
            $this->log_in();
            return;
        }


        /*
         * 显示信息界面。
         * */
        $data['title'] = '欢迎来到备忘录';
        $this->load->view('templates/header', $data);
        $this->load->view('app/welcome');
        $this->load->view('templates/footer');
    }




    /*
     * 销毁会话（用户主动点击回主页）。
     * */
    public function index_d()
    {


        /*
         * 销毁会话。
         * */
        if (isset($_SESSION['id']))
        {
            session_destroy();
        }


        /*
         * 进入主页。
         * */
        /*
         * 显示信息界面。
         * */
        $data['title'] = '欢迎来到备忘录';
        $this->load->view('templates/header', $data);
        $this->load->view('app/welcome');
        $this->load->view('templates/footer');
    }




    /*
     * 创建新用户。
     * */
    public function new_id()
    {


        /*
         * 需要表单验证库、表单和路径辅助函数。
         * */




        /*
         * 为表单验证设置规则。
         * */
        $this->form_validation->set_rules('id', '用户名', 'required', array(
            'required' => '请填写%s。'
        ));
        $this->form_validation->set_rules('password', '密码', 'required', array(
            'required' => '请填写%s。'
        ));
        $this->form_validation->set_rules('email', '邮箱', 'required', array(
            'required' => '请填写%s，当升级完成时，您可使用邮箱备忘录提醒功能。'
        ));


        /*
         * 运行验证规则，并显示不同的结果。
         * */
        if ($this->form_validation->run() === FALSE)
        {


            /*
             * 准备数据并显示表单视图。
             * */
            $data['title'] = '创建新用户';
            $this->load->view('templates/header', $data);
            $this->load->view('app/new-id');
            $this->load->view('templates/footer');
        }
        else
        {


            /*
             * 接受并预处理用户填写的数据。
             * */
            $id_info['id'] = $this->input->post('id');
            $id_info['password'] = $this->input->post('password');
            $id_info['email'] = $this->input->post('email');


            /*
             * 创建数据表。
             * */
            $judge = $this->app_model->new_id($id_info);
            if ($judge === 'already')
            {
                $data['title'] = '用户名已经存在';
                $this->load->view('templates/header', $data);
                $this->load->view('app/new-id');
                $this->load->view('templates/footer');
            }
            else
            {


                /*
                * 显示成功页面。
                * */
                $data['title'] = '创建成功';
                $this->load->view('templates/header', $data);
                $this->load->view('app/new-id-success');
                $this->load->view('templates/footer');
            }
        }
    }




    /*
     * 修改密码。
     * */
    public function change_password()
    {


        /*
         * 需要表单验证函数和路径辅助函数，验证库。
         * */


        /*
         * 判断是否登录。
         * */
        if ( ! isset($_SESSION['id']))
        {


            /*
             * 显示错误信息。
             * */
            $data['title'] = '请您登录';
            $data['error_info'] = '点击下面的链接注册或登录。';
            $this->load->view('templates/header', $data);
            $this->load->view('app/error', $data);
            $this->load->view('templates/footer');
            return;
        }


        /*
         * 已经登陆，设置验证规则。
         * */
        $this->form_validation->set_rules('id', '用户名', 'required', array(
            'required' => '请填写%s。'
        ));
        $this->form_validation->set_rules('old_password', '原密码', 'required', array(
            'required' => '请填写%s。'
        ));
        $this->form_validation->set_rules('new_password', '新密码', 'required', array(
            'required' => '请填写%s。'
        ));


        /*
         * 运行规则。
         * */
        if ($this->form_validation->run() === FALSE)
        {


            /*
             * 数据错误或者第一次显示。
             * */
            $data['title'] = '修改密码';
            $this->load->view('templates/header', $data);
            $this->load->view('app/change-password', $data);
            $this->load->view('templates/footer');
        }
        else
        {


            /*
             * 格式正确，获取数据。
             * */
            $id_info['id'] = $this->input->post('id');
            $id_info['old_password'] = $this->input->post('old_password');
            $id_info['new_password'] = $this->input->post('new_password');


            /*
             * 更新数据并查询结果。
             * */
            $query = $this->app_model->change_password($id_info); // 返回数组，result true/false。


            /*
             * 成功或失败。
             * */
            if ($query['result'] === FALSE)
            {


                if ($query['error'] === 'no-id')
                {


                    /*
                    * 没用此用户，显示失败页面。
                    * */
                    $data['title'] = '用户不存在';
                    $data['error_info'] = '请检查用户名拼写。点击下面的链接返回。';
                    $this->load->view('templates/header', $data);
                    $this->load->view('app/error', $data);
                    $this->load->view('templates/footer');
                }


                if ($query['error'] === 'wrong-password')
                {


                    /*
                     * 密码错误。
                     * */
                    $data['title'] = '密码错误';
                    $data['error_info'] = '请检查密码。点击下面的链接返回。';
                    $this->load->view('templates/header', $data);
                    $this->load->view('app/error', $data);
                    $this->load->view('templates/footer');
                }
            }
            else
            {


                /*
                 * 成功更新密码。
                 * */
                $data['title'] = '更改密码成功';
                $this->load->view('templates/header', $data);
                $this->load->view('app/change-password-success');
                $this->load->view('templates/footer');
            }
        }
    }




    /*
     * 使用表单获取用户信息并实现登陆功能。
     * */
    public function log_in()
    {


        /*
         * 需要表单验证库、表单和路径辅助函数。
         * */


        /*
         * 判断是否已经登录。
         * */
        if (isset($_SESSION['id']))
        {
            $id_info['id'] = $_SESSION['id'];
            goto success;
        }


        /*
         * 设置表单规则。
         * */
        $this->form_validation->set_rules('id', '用户名', 'required', array(
            'required' => '请填写%s。'
        ));
        $this->form_validation->set_rules('password', '密码', 'required', array(
            'required' => '请填写%s。'
        ));


        /*
         * 运行规则。
         * */
        if ($this->form_validation->run() === FALSE)
        {


            /*
             * 准备数据并显示表单视图。
             * */
            $data['title'] = '登录';
            $this->load->view('templates/header', $data);
            $this->load->view('app/log-in');
            $this->load->view('templates/footer');
        }
        else
        {


            /*
             * 接受用户名和密码。
             * */
            $id_info['id'] = $this->input->post('id');
            $id_info['password'] = $this->input->post('password');


            /*
             * 读取用户名和密码的数据。
             * */
            $query = $this->app_model->log_in($id_info);


            /*
             * 判断用户的存在情况。
             * */
            if (!$query['exist'])
            {


                /*
                 * 用户不存在。
                 * */
                $data['title'] = '用户不存在';
                $data['error_info'] = '点击下面的链接注册或重新登录。';
                $this->load->view('templates/header', $data);
                $this->load->view('app/error', $data);
                $this->load->view('templates/footer');
            }
            else
            {


                /*
                 * 用户存在并判断密码是否正确。
                 * */
                if (password_verify($id_info['password'], $query['password']))  // 密码正确。
                {


                    /*
                     * 添加会话数据。
                     * */
                    $_SESSION['id'] = $id_info['id'];  // 这里可以存储不同的功能选项。


                    /*
                     * 显示登陆成功导航页面。
                     * */
                    success:
                    $data['title'] = '欢迎您，'.$id_info['id'];
                    $this->load->view('templates/header', $data);
                    $this->load->view('app/log-in-success');
                    $this->load->view('templates/footer');
                }
                else
                {


                    /*
                     * 密码错误。
                     * */
                    $data['title'] = '密码错误';
                    $this->load->view('templates/header', $data);
                    $this->load->view('app/log-in');
                    $this->load->view('templates/footer');
                }
            }
        }
    }




    /*
     * 显示已有条目。
     * */
    public function view()
    {


        /*
         * 需要辅助函数。
         * */



        /*
         * 判断是否登录。
         * */
        if ( ! isset($_SESSION['id']))
        {


            /*
             * 显示错误信息。
             * */
            $data['title'] = '请您登录';
            $data['error_info'] = '点击下面的链接注册或登录。';
            $this->load->view('templates/header', $data);
            $this->load->view('app/error', $data);
            $this->load->view('templates/footer');
            return;
        }


        /*
         * 获取所有数据。
         * */
        $result = $this->app_model->universal(array(
            'type' => 'query',
            'id' => $_SESSION['id']
        ));


        /*
         * 显示页面。
         * */
        $data['title'] = '查询结果';
        $data['data'] = $result;  // 对象数组。
        $this->load->view('templates/header', $data);
        $this->load->view('app/query-result', $data);
        $this->load->view('templates/footer');
    }




    /*
     * 用户新建条目。
     * */
    public function create()
    {


        /*
         * 需要辅助函数。
         * */



        /*
         * 判断是否登录。
         * */
        if ( ! isset($_SESSION['id']))
        {


            /*
             * 显示错误信息。
             * */
            $data['title'] = '请您登录';
            $data['error_info'] = '点击下面的链接注册或登录。';
            $this->load->view('templates/header', $data);
            $this->load->view('app/error', $data);
            $this->load->view('templates/footer');
            return;
        }


        /*
         * 设置规则。
         * */
        $this->form_validation->set_rules('item', '标题', 'required', array(
            'required' => '需要一个%s。'
        ));
        $this->form_validation->set_rules('content', '内容', 'required', array(
            'required' => '需要%s。'
        ));


        /*
         * 运行规则。
         * */
        if ($this->form_validation->run() === FALSE)
        {


            /*
             * 重新显示页面。
             * */
            $data['title'] = '创建新条目';
            $this->load->view('templates/header', $data);
            $this->load->view('app/create');
            $this->load->view('templates/footer');
        }
        else
        {


            /*
             * 获取数据并插入数据库。
             * */
            $this->app_model->universal(array(
                'type' => 'insert',
                'id' => $_SESSION['id'],
                'item' => $this->input->post('item'),
                'content' => $this->input->post('content')
            ));


            /*
             * 显示成功页面。
             * */
            $data['title'] = '成功';
            $this->load->view('templates/header', $data);
            $this->load->view('app/create-success');
            $this->load->view('templates/footer');
        }
    }




    /*
     * 删除条目。
     * */
    public function delete()
    {


        /*
         * 需要辅助函数。
         * */



        /*
         * 判断是否登录。
         * */
        if ( ! isset($_SESSION['id']))
        {


            /*
             * 显示错误信息。
             * */
            $data['title'] = '请您登录';
            $data['error_info'] = '点击下面的链接注册或登录。';
            $this->load->view('templates/header', $data);
            $this->load->view('app/error', $data);
            $this->load->view('templates/footer');
            return;
        }


        /*
         * 设置规则。
         * */
        $this->form_validation->set_rules('item', '标题', 'required', array(
            'required' => '需要一个%s。'
        ));


        /*
         * 运行规则。
         * */
        if ($this->form_validation->run() === FALSE)
        {


            /*
         * 显示页面。
         * */
            $data['title'] = '删除';
            $this->load->view('templates/header', $data);
            $this->load->view('app/delete-query');
            $this->load->view('templates/footer');
        }
        else
        {


            /*
             * 删除数据。
             * */
            $query = $this->app_model->universal(array(
                'type' => 'delete',
                'id' => $_SESSION['id'],
                'item' => $this->input->post('item')
            ));


            // 判断是否删除成功。
            if ($query === 'not-found')
            {


                // 显示失败页面。
                $data['title'] = '条目不存在';
                $this->load->view('templates/header', $data);
                $this->load->view('app/delete-fail');
                $this->load->view('templates/footer');
            }
            else
            {


                /*
                 * 返回成功页面。
                 * */
                $data['title'] = '删除成功';
                $this->load->view('templates/header', $data);
                $this->load->view('app/delete-success');
                $this->load->view('templates/footer');
            }
        }
    }
}
