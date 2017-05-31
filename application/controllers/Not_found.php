<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/5
 * Time: 下午 11:11
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Not_found extends CI_Controller
{

    /**
     * Not_found constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * 显示 404 错误页面。
     */
    public function index()
    {


        $data['title'] = '404错误';
        $data['error_info'] = '没有找到您所请求的页面，请检查您的链接拼写。';
        $this->load->view('templates/header', $data);
        $this->load->view('app/error', $data);
        $this->load->view('templates/footer');
    }
}