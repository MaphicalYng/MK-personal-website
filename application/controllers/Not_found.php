<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/5
 * Time: 下午 11:11
 */
class Not_found extends CI_Controller
{

    /**
     * Not_found constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 显示 404 错误页面。
     */
    public function index()
    {


        $this->load->helper('url');


        $data['title'] = '404错误';
        $data['error_info'] = '没有找到您所请求的页面，请检查您的链接拼写。';
        $this->load->view('templates/header', $data);
        $this->load->view('app/error', $data);
        $this->load->view('templates/footer');
    }
}