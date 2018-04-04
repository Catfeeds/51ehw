<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Show_view extends Front_Controller
{

    // ------------------------------------------------------------
    /**
    */
    public function __construct()
    {
        parent::__construct();
        
    }

    // -----------------------------------------------------------


 

    /**
     * 页面（测试） 
     */
    public function test_view(){ 
        $this->load->view('api_other_test');
    }
    
    public function phpinfo(){
        phpinfo();
    }
    
    function test_errorlog(){
        if(error_log(1111111111)){ 
            echo 'ok';
        }else{ 
            echo 'no';
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */