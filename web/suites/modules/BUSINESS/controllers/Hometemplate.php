<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 店铺管理控制器
 *
 * 查看会员列表
 *
 * @author Clark So
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Hometemplate extends Front_Controller
{

    // --------------------------------------------------------------------

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

    }

    // --------------------------------------------------------------------
    
    public function homeTemplatepreview(){
        
        $this->load->model('home_template_set_mdl','hometemp');
        $temp = $this->hometemp->load_Floor();
        $floor = $this->hometemp->load_level();
        $index = $this->hometemp->load_index();
        $data['temp'] = $temp;
        $data['floor'] = $floor;
        $data['index'] = $index;

//         print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('homepreview', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }


}