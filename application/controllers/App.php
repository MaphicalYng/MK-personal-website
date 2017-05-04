<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/4/30
 * Time: 下午 10:13
 */
class App extends CI_Controller
{




    /*
     * 构造类并加载模型和类库。
     * */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->library('session');
    }




    /*
     * 网站欢迎页面和介绍信息。
     * */
    public function index()
    {


        /*
         * 加载表单验证库、表单和路径辅助函数。
         * */
        $this->load->helper('url');


        /*
         * 销毁会话。
         * */
        session_destroy();


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
         * 加载表单验证库、表单和路径辅助函数。
         * */
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');


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
            $id_info['id'] = trim($this->input->post('id'));
            $id_info['password'] = trim($this->input->post('password'));
            $id_info['email'] = trim($this->input->post('email'));


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
     * 使用表单获取用户信息并实现登陆功能。
     * */
    public function log_in()
    {


        /*
         * 加载表单验证库、表单和路径辅助函数。
         * */
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');


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
            $id_info['id'] = trim($this->input->post('id'));
            $id_info['password'] = trim($this->input->post('password'));


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
                if ($id_info['password'] === $query['password'])  // 密码正确。
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
         * 加载辅助函数。
         * */
        $this->load->helper('url');


        /*
         * 判断是否登录。
         * */
        if (!isset($_SESSION['id']))
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
         * 加载辅助函数。
         * */
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');


        /*
         * 判断是否登录。
         * */
        if (!isset($_SESSION['id']))
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
         * 加载辅助函数。
         * */
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');


        /*
         * 判断是否登录。
         * */
        if (!isset($_SESSION['id']))
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