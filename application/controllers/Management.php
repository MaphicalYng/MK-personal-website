<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/6/1
 * Time: 下午 7:30
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Management extends CI_Controller
{

    /**
     * management constructor.
     * load something in need.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('management_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'session'));
        $this->form_validation->set_error_delimiters('<h5 style="color: red">', '</h5>');
    }

    /**
     * index method.
     * to get logged in.
     */
    public function index()
    {

        if (isset($_SESSION['admin']))
        {
            goto success;
        }

        // 对访问记录日志。
        if (MaphicalYng__log_feature)
        {
            $handle = fopen(MaphicalYng__log_path, 'ab');
            if (!$handle) {
                log_message('info', 'The log file is not able to open!');
                goto log_fail;
            }
            date_default_timezone_set('Asia/Shanghai');
            $write = 'Management: ' . date(DATE_COOKIE) . ' ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
            fwrite($handle, $write);
            fclose($handle);
            log_fail:
        }

        // 设置规则。
        $this->form_validation->set_rules('password', '密码', 'required', array(
            'required' => '需要%s。'
        ));

        // 运行规则。
        if ($this->form_validation->run() === FALSE) {

            // 没有密码。
            // 显示登陆页面。
            $data['title'] = '管理员登录';
            $this->load->view('templates/header', $data);
            $this->load->view('management/log-in');
            $this->load->view('templates/footer');
        } else {

            // 填写了密码。获取数据。
            $password = $this->input->post('password');

            // 验证密码。
            $query = $this->management_model->verify($password);

            if ($query)
            {
                $_SESSION['admin'] = 'administrator';
                success:
                // 密码正确。显示成功页面。
                $data['title'] = '管理页面';
                $this->load->view('templates/header', $data);
                $this->load->view('management/log-in-success');
                $this->load->view('templates/footer');
            } else {

                // 密码错误。
                $data['title'] = '密码错误';
                $this->load->view('templates/header', $data);
                $this->load->view('management/log-in');
                $this->load->view('templates/footer');
            }
        }
    }

    /**
     * to destroy the session for quiting.
     */
    public function index_d()
    {
        if (isset($_SESSION['admin']))
        {
            session_destroy();
        }

        // 显示登陆页面。
        $data['title'] = '管理员登录';
        $this->load->view('templates/header', $data);
        $this->load->view('management/log-in');
        $this->load->view('templates/footer');
    }

    /**
     * database operations.
     */
    public function database_index($type = NULL)
    {

        if ( ! isset($_SESSION['admin']))
        {
            $data['title'] = '请先登录';
            $data['error_info'] = '先登陆才能查看内容。';
            $this->load->view('templates/header', $data);
            $this->load->view('management/error', $data);
            $this->load->view('templates/footer');
            return;
        }

        // 设置验证规则。
        switch ($type)
        {
            case 'query':
                $this->form_validation->set_rules('table_query', '数据表', array(
                    'required',
                    array(
                        'check_table',
                        array(
                            $this->management_model,
                            'check_table')
                    )
                ), array(
                    'required' => '%s为必填选项。',
                    'check_table' => '%s不能为管理员相关表。'
                ));
                break;

            case 'insert':
                $this->form_validation->set_rules('table_insert', '数据表', array(
                    'required',
                    array(
                        'check_table',
                        array(
                            $this->management_model,
                            'check_table')
                    )
                ), array(
                    'required' => '%s为必填选项。',
                    'check_table' => '%s不能为管理员相关表。'
                ));
                $this->form_validation->set_rules('value_insert', '值', 'required', array(
                    'required' => '%s不能为空。'
                ));
                break;

            case 'modify':
                $this->form_validation->set_rules('table_modify', '数据表', array(
                    'required',
                    array(
                        'check_table',
                        array(
                            $this->management_model,
                            'check_table')
                    )
                ), array(
                    'required' => '%s为必填选项。',
                    'check_table' => '%s不能为管理员相关表。'
                ));
                $this->form_validation->set_rules('field_modify', '欲修改域名', 'required', array(
                    'required' => '%s不能为空。'
                ));
                $this->form_validation->set_rules('where_modify', '条件', 'required', array(
                    'required' => '%s不能为空。'
                ));
                $this->form_validation->set_rules('value_modify', '新值', 'required', array(
                    'required' => '%s不能为空。'
                ));
                break;

            case 'delete':
                $this->form_validation->set_rules('table_delete', '数据表', array(
                    'required',
                    array(
                        'check_table',
                        array(
                            $this->management_model,
                            'check_table')
                    )
                ), array(
                    'required' => '%s为必填选项。',
                    'check_table' => '%s不能为管理员相关表。'
                ));
                break;
        }


        if ($type === NULL OR $this->form_validation->run() === FALSE)
        {
            // 默认显示功能页面。
            $data['title'] = '数据库';
            $this->load->view('templates/header', $data);
            $this->load->view('management/database-index');
            $this->load->view('templates/footer');
        }
        else
        {
            $db['type'] = $type;
            // 接收数据。
            switch ($type)
            {
                case 'query':
                    $db['table'] = $this->input->post('table_query');
                    $db['field'] = $this->input->post('field_query');
                    $db['where'] = $this->input->post('where_query');
                    break;

                case 'insert':
                    $db['table'] = $this->input->post('table_insert');
                    $db['value'] = $this->input->post('value_insert');
                    break;

                case 'modify':
                    $db['table'] = $this->input->post('table_modify');
                    $db['field'] = $this->input->post('field_modify');
                    $db['where'] = $this->input->post('where_modify');
                    $db['value'] = $this->input->post('value_modify');
                    break;

                case 'delete':
                    $db['table'] = $this->input->post('table_delete');
                    $db['where'] = $this->input->post('where_delete');
                    break;
            }

            // 调用模型。
            $result = $this->management_model->database($db);

            // 处理结果。
            if ($db['type'] === 'query')
            {
                if ($result->num_rows() > 0)  // 有结果，显示数据页面。
                {
                    $data['title'] = '查询结果';
                    $data['data'] =  $result->result();  // 对象数组。
                    $this->load->view('templates/header', $data);
                    $this->load->view('management/database-query', $data);
                    $this->load->view('templates/footer');
                }
                else                            // 无数据。
                {
                    $data['title'] = '查询结果';
                    $this->load->view('templates/header', $data);
                    $this->load->view('management/database-query-empty');
                    $this->load->view('templates/footer');
                }
            }
            else
            {
                $data['title'] = '操作已提交';
                $data['error_info'] = '是否操作成功请自行查询。';
                $this->load->view('templates/header', $data);
                $this->load->view('management/database-upd-del');
                $this->load->view('templates/footer');
            }
        }

    }

    /**
     * features adjust.
     */
    public function features_index($valued = NULL)
    {

        if ( ! isset($_SESSION['admin']))
        {
            $data['title'] = '请先登录';
            $data['error_info'] = '先登陆才能查看内容。';
            $this->load->view('templates/header', $data);
            $this->load->view('management/error', $data);
            $this->load->view('templates/footer');
            return;
        }

        if ($valued === NULL)
        {

            // 默认数据。
            $features_default['database'] = 'newapp';
            $features_default['route'] = 'app';
            $features_default['address'] = 'http://127.0.0.1/app-notes-e-uk/';
            $features_default['session_path'] = "C:\\\\xampp\\\\ci_sessions\\\\";
            $features_default['session_lasting'] = 7200;
            $features_default['log_on'] = TRUE;
            $features_default['log_path'] = "C:\\\\xampp\\\\htdocs\\\\app-notes-e-uk\\\\view.log";

            // 显示功能页面。
            $features_default['title'] = '功能页面';
            $this->load->view('templates/header', $features_default);
            $this->load->view('management/features-index', $features_default);
            $this->load->view('templates/footer');
        }
        else
        {

            // 获取数据。
            $features['database'] = trim($this->input->post('database'));
            $features['route'] = trim($this->input->post('route'));
            $features['address'] = trim($this->input->post('address'));
            $features['session_path'] = trim($this->input->post('session_path'));
            $features['session_lasting'] = trim($this->input->post('session_lasting'));
            $features['log_on'] = trim($this->input->post('log_on'));
            $features['log_path'] = trim($this->input->post('log_path'));

            // 重组数据。
            $string = '<?php'."\n";
            foreach ($features as $key => $value)
            {
                switch ($key)
                {
                    case 'database':
                        $string .= 'define("MaphicalYng__database_in_use", "'.$value.'");'."\n";
                        break;

                    case 'route':
                        $string .= 'define("MaphicalYng__default_route", "'.$value.'");'."\n";
                        break;

                    case 'address':
                        $string .= 'define("MaphicalYng__website_address", "'.$value.'");'."\n";
                        break;

                    case 'session_path':
                        $string .= 'define("MaphicalYng__sessions_path", "'.$value.'");'."\n";
                        break;

                    case 'session_lasting':
                        $string .= 'define("MaphicalYng__sessions_time", "'.$value.'");'."\n";
                        break;

                    case 'log_on':
                        $string .= 'define("MaphicalYng__log_feature", "'.$value.'");'."\n";
                        break;

                    case 'log_path':
                        $string .= 'define("MaphicalYng__log_path", "'.$value.'");'."\n";
                        break;
                }
            }
            unset($key);
            unset($value);

            // 写入数据。
            $handle = fopen(MaphicalYng__features_file_path, 'wb');
            if ( ! $handle)
            {

                // 文件打开错误，显示错误页面。
                $data['title'] = '文件打开错误';
                $data['error_info'] = '请检查文件位置进行调试。';
                $this->load->view('templates/header', $data);
                $this->load->view('management/error', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                fwrite($handle, $string);
                fclose($handle);

                // 显示成功页面。
                $data['title'] = '修改成功';
                $this->load->view('templates/header', $data);
                $this->load->view('management/features-success');
                $this->load->view('templates/footer');
            }

        }
    }
}