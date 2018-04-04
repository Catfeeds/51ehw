<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * B-C端的广告接口-调用数据
 *
 */
class Customer extends Account_Controller
{

    
    public function __construct()
    {
        parent::__construct();
       
    }
   
    //---------------------------------------------------------------------------------------------------

    
    /**
     * 忘记密码
     */
    function forget_password()
    { 
        $name = $this->input->post('mobile');
        $password = $this->input->post('password');
        
        $result['status'] = '-253';
        $result['message'] = '缺少参数';
        
        if( $name && $password)
        {
            $this->load->model('customer_mdl');
            $cus = $this->customer_mdl->load_by_mobile($name);
            
            if( $cus )
            { 
                //修改密码
                $row = $this->customer_mdl->update_pwd($cus['id'],$password);
                
                if($row){
                    
                    $result['status'] = '1';
                    $result['message'] = '修改成功';
                    
                }else{
                    
                    $result['status'] = '-1';
                    $result['message'] = '修改失败';
                }
                
            }else{ 
                
                $result['status'] = '-4';
                $result['message'] = '用户不存在';
                
            }
        }
        
        echo json_encode($result);
    }
    
    
 
    
    //---------------------------------------------------------------------------------------------------
  
}
   
?>