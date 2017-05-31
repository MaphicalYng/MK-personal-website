<?php
/**
 * Created by PhpStorm.
 * User: Shuolin Yang
 * Date: 17/5/6
 * Time: 下午 7:49
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class CLITools extends CI_Controller
{
    /**
     * Tools constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $to
     */
    public function message($to = 'World')
    {
        echo "Hello {$to}!".PHP_EOL;
    }
    public function hash($str)
    {
	    echo hash("md5", $str);
    }
}
