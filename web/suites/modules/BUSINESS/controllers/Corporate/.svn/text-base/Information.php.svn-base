<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 公司介绍控制器
 *
 *
 * @author Clark So
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Information extends Front_Controller
{

    // --------------------------------------------------------------------

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('corporation_mdl');
    }

    // --------------------------------------------------------------------

    /**
     * 
     */
    public function index($status=0,$corporation_id=0){

        //清除session
        $this->session->unset_userdata("images");
        if(!$corporation_id || !$status){
            // 判断用户是否登录
            if (! $this->session->userdata('corporation_id')) {
                $this->session->set_userdata('redirect','corporate/information');
                redirect('customer/login');
                exit();
            }
            $corporation_id = $this->session->userdata('corporation_id');
        }
        $data['corporation'] = $this->corporation_mdl->load_id($corporation_id);
        //企业不存在
        if(!$data['corporation']){
            echo "<script>history.go(-1)</script>";
            exit;
        }
        //获取图片
        $data['image'] = $this->corporation_mdl->get_images($corporation_id);
        
        $data['status'] = 1;
        $data['title'] = "公司介绍";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        
        if($status){
            //审核不通过
            if(!$data['image']){
                echo "<script>history.go(-1)</script>";
                exit;
            }
            //公告
            $app = $this->session->userdata('app_info');
            $this->load->model('content_mdl');
            $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
            
            $this->load->view('corporate/shop/information_detail', $data);//预览页面
        }else{
            $this->load->view('corporate/shop/information_list', $data);//编辑页面
        }
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 图片上传方法
     *
     * @param int $id
     * @param string $status
     */
    public function file_upload($type)
    {
        try {
            $this->load->helper("ps_helper");
    
            $customer_id = $this->session->userdata('user_id');
    
    
            $save_path = 'information/' . date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 'product/' . $id . '/';
            // $path = UPLOADS.$save_path;
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            error_log($path);
            if (! file_exists($path))
                error_log("mkdir back:".mkdirsByPath($path));
    
    
            $config['file_name'] = $customer_id . '_' . date("YmdHis");
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
    
            //图片
            if (! empty($_FILES))
                $n = count($_FILES['file']['name']);
            else
                $n = 0;
    
    
            if ($n) {
                $images = array();
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
    
                    $uploaded = $this->upload->data();
                    $images['image_name'] = "uploads/" . $save_path . $uploaded['raw_name'];
                    $images['file'] = "uploads/" . $save_path . $uploaded['file_name'];
                    $images['file_ext'] = $uploaded['file_ext'];
                    $images['file_mime'] = $uploaded['file_type'];
                    $images['width'] = $uploaded['image_width'];
                    $images['height'] = $uploaded['image_height'];
                    $images['file_size'] = $uploaded['file_size'];
                    $images['original_name'] = $uploaded['orig_name'];
                    $images['client_name'] = $uploaded['client_name'];
    
                    $corporation_id = $this->session->userdata('corporation_id');
    
                    //把文件路径保存session
                    switch ($type){
                        case 'picture':
                            //如果替换上传图片就把上一次的图片删除
                            $i = 1;
                            $all_images = $this->session->userdata("images");

                            if($all_images){
                                foreach($all_images as $key => $val){
                                    if($val['type']=='picture'){//图片存在更新session
                                        $all_images[$key] = array('type'=>'picture',
                                            'image_name'=>$images['file'],
                                            'corporation_id'=>$corporation_id,
                                            'title'=>null,
                                            'number'=>null
                                        );
                                        $i = 0;
                                    }
                                }
                            }
                            
                            if($i){//图片不存在追加session
                                $all_images[] = array('type'=>'picture',
                                    'image_name'=>$images['file'],
                                    'corporation_id'=>$corporation_id,
                                    'title'=>null,
                                    'number'=>null
                                );
                            }
                            $this->session->set_userdata("images", $all_images);
                            break;
                        case 'ce'://企业实力展示
                            //追加session
                            $all_images = $this->session->userdata("images");
                            $all_images[] = array('type'=>'ce',
                                    'image_name'=>$images['file'],
                                    'corporation_id'=>$corporation_id,
                                    'title'=>null,
                                    'number'=>null
                                );
                
                            $this->session->set_userdata("images", $all_images);
//                             print_r($this->session->userdata('images'));
                            break;
                        case 'solicitude'://领导关怀
                            
                            $i = 1;
                            $number = $this->input->post('number');//图片编号
                            $all_images = $this->session->userdata("images");//session
                            if($all_images){
                                foreach($all_images as $key => $val){
                                    if($val['number']==$number){//图片存在更新session
                                        $all_images[$key] = array('type'=>'solicitude',
                                            'image_name'=>$images['file'],
                                            'corporation_id'=>$corporation_id,
                                            'title'=>$this->input->post('title'),
                                            'number'=>$number
                                        );
                                        $i = 0;
                                    }
                                }
                            }
                            
                            if($i){//图片不存在追加session
                                $all_images[] = array('type'=>'solicitude',
                                                'image_name'=>$images['file'],
                                                'corporation_id'=>$corporation_id,
                                                'title'=>$this->input->post('title'),
                                                'number'=>$number
                                            );
                            }
                            $this->session->set_userdata("images", $all_images); 
                            break;
                    }
                    //输出图片路径
                    echo $images['file'];
                } else {
                    error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    echo "失败";
                }
    
            }
    
        } catch (Exception $e) {
            error_log($e);
        }
    }
    
    
        // --------------------------------------------------------------------
    
        /**
         *编辑页面
         */
        public function edit_view($status=0){
        
            //清除session
            $this->session->unset_userdata("images");

            // 判断用户是否登录
            if (! $this->session->userdata('corporation_id')) {
                $this->session->set_userdata('redirect','corporate/information');
                redirect('customer/login');
                exit();
            }
            $corporation_id = $this->session->userdata('corporation_id');

            //获取企业信息
            $data['corporation'] = $this->corporation_mdl->load_id($corporation_id);
            //企业不存在
            if(!$data['corporation']){
                echo "<script>history.go(-1)</script>";
                exit;
            }
            
            //获取企业介绍审核信息
            $data['image'] = $this->corporation_mdl->get_images_temp($corporation_id);

            if(empty($data['image'])){
                //获取当前企业介绍信息
                $data['image'] = $this->corporation_mdl->get_images($corporation_id);
                
                //把当前企业信息同步企业介绍审核表，编辑的时候只显示审核表信息，主要为了能看见上一次编辑的信息
                $data['image'][] = $array[] = array('corporation_id'=>$corporation_id,
                    'description'=>$data['corporation']['description'],
                    'type'=>'description',
                    'status'=>1
                );
                $this->corporation_mdl->add_images($array);
            }
            
            $data['status'] = 1;
            $data['title'] = "公司介绍";
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            
            //根据状态判断预览还是编辑
            if($status){
                //公告
                $app = $this->session->userdata('app_info');
                $this->load->model('content_mdl');
                $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
            
                $this->load->view('corporate/shop/information_detail', $data);//预览页面
            }else{
                $this->load->view('corporate/shop/information_edit', $data);//编辑页面
            }
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
        // --------------------------------------------------------------------
    
        /**
         * 修改企业介绍
         *
         */
        public function edit()
        {
            // 判断用户是否登录
            if (! $this->session->userdata('corporation_id')) {
                redirect('customer/login');
                exit();
            }
            //更新企业信息
            $corporation_id = $this->corporation_mdl->corporation_id = $this->session->userdata('corporation_id');
            $description = $this->corporation_mdl->description = $this->input->post('description');//获取企业简介
            //企业简介必须大于100少于500字节
            if( $description && mb_strlen($description,'utf-8') > 99 && mb_strlen($description,'utf-8') < 501){
                $up_array = array(
                    "description"=>$description,
                );
                $where = array('type' => 'description');
                $this->corporation_mdl->update_images($up_array,$where);
            }
            
            
            //店铺相关图片
            $add_array = array();
            //获取审核信息
            $image = $this->corporation_mdl->get_images_temp($corporation_id);
            //获取session，上传图片保存session
            $img_session = $this->session->userdata('images');
            $i = 1;
            //如果有修改信息执行
            if($img_session){
                foreach ($img_session as $key => $val){//循环session
                    foreach ($image as $k => $v){
                        if($v['number'] && $val['number'] == $v['number']){//循环判断session的类型和审核表的类型相等，执行update
                            $up_array = array(
                                    "image_name"=>$val['image_name'],
                                    "title"=>$val['title'],
                                );
                            $where = array('type' => 'solicitude', 'number' => $val['number']);
                            $this->corporation_mdl->update_images($up_array,$where);
                            unset($img_session[$key]);//把当前数据从数组删除
                        }
                        

                        if($i && $val['type'] == 'picture'){//循环判断session的类型和审核表的类型相等
                            $up_array = array(
                                        "image_name"=>$val['image_name'],
                                    );
                            $where = array('type' => 'picture');
                            $row = $this->corporation_mdl->update_images($up_array,$where);
                            //如果没用影响行数证明信息不存在，不把当前数据从数组删除
                            if($row){
                                unset($img_session[$key]);
                            }
                            $i=0;
                        }
                    }
                }
                
                //剩余的数据执行insert
                $add_array = $img_session;
                if($add_array){
                    $this->corporation_mdl->add_images($add_array);
                }
                
                //因为有修改信息，把此企业相关的数据统一更改状态申请中
                $up_array = array(
                    "status"=>1,
                );
                $where = array('corporation_id' => $corporation_id);
                $this->corporation_mdl->update_images($up_array,$where);
                
                //删除session数据
                $this->session->unset_userdata("images");
            }
            
            $status = $this->input->post('status');
            redirect('corporate/information/edit_view/'.$status);
        }
        
        /**
         * 删除图片
         */
        public function del_img(){
            $corporation_id = $this->session->userdata('corporation_id');
            $id = $this->input->post('id');
            $type = $this->input->post('type');
            $row = $this->corporation_mdl->del_img($corporation_id,$id,$type);
            if($row){
                echo true;
            }else{
                echo false;
            }
        }
        

        

}