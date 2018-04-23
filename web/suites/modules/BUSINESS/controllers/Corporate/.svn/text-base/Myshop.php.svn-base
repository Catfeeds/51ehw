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
class Myshop extends Front_Controller
{
    
    // --------------------------------------------------------------------
    
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $this->load->model('customer_mdl');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 获取列表
     * 我的店铺
     */
    public function get_shop($type = 0)
    {
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/myshop/get_shop,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        $user_id = $this->session->userdata['user_id'];
        
        $this->load->model('corporation_mdl');
        // 获取企业资料
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $data ['detail'] = $this->corporation_mdl->load_corp_info ( $corporation_id );
//         $data['detail'] = $this->corporation_mdl->load($user_id);
        
        // 企业性质
        $data['cor_type'] = $this->corporation_mdl->corporation_type();
        // 企业行业
        $data['cor_ind'] = $this->corporation_mdl->cor_ind_info();
        $data['title'] = '我的店铺';
        
        $data['types'] = $type;
        
        // print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/shop_detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 修改认证图片
     */
    function authenticate_img($type = 0)
    {
        try {
            if (! empty($_FILES)) {
                $this->load->helper("ps_helper");
                
                $customer_id = $this->session->userdata('user_id');
                $corporation_id = $this->session->userdata['corporation_id'];
                switch ($type) {
                    case 1: // 新营业照
                        $save_path = 'myshop/' . $corporation_id . '/new/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'charter' . '_' . $corporation_id . '_newcharter';
                        $config['upload_path'] = $path;
                        break;
                    case 2: // 旧营业照
                        $save_path = 'myshop/' . $corporation_id . '/old/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'charter' . '_' . $corporation_id . '_old1charter';
                        $config['upload_path'] = $path;
                        break;
                    case 3: // 旧营业照税务登记证
                        $save_path = 'myshop/' . $corporation_id . '/old/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'charter' . '_' . $corporation_id . '_old2charter';
                        $config['upload_path'] = $path;
                        break;
                    case 4: // 旧营业照组织机构代码证
                        $save_path = 'myshop/' . $corporation_id . '/old/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'charter' . '_' . $corporation_id . '_old3charter';
                        $config['upload_path'] = $path;
                        break;
                    case 5: // 身份证正
                        $save_path = 'myshop/' . $corporation_id . '/idcard/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'idcard' . '_' . $corporation_id . '_idcard';
                        $config['upload_path'] = $path;
                        break;
                    case 6: // 身份证反
                        $save_path = 'myshop/' . $corporation_id . '/idcard/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'idcard' . '_' . $corporation_id . 'idcardback';
                        $config['upload_path'] = $path;
                        break;
                    case 7: // 委托书
                        $save_path = 'myshop/' . $corporation_id . '/wts/';
                        $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                        $config['file_name'] = 'proexy' . '_' . $corporation_id . '_wts';
                        $config['upload_path'] = $path;
                        break;
                }
                
                if (! file_exists($path)) {
                    mkdirsByPath($path);
                }
                
                $p = $path . $config['file_name'] . '.jpg';
                
                if (file_exists($p)) {
                    
                    unlink($p);
                }
                
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['max_filename'] = '50';
                $this->load->library('upload');
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        switch ($type) {
                            case 1: // 新营业照
                                $this->session->set_userdata("busimage", $images);
                                $this->session->set_userdata("busimage1");
                                $this->session->set_userdata("busimage2");
                                $this->session->set_userdata("busimage3");
                                break;
                            case 2: // 旧营业照
                                $this->session->set_userdata("busimage1", $images);
                                $this->session->set_userdata("busimage");
                                break;
                            case 3: // 旧营业照税务登记证
                                $this->session->set_userdata("busimage2", $images);
                                $this->session->set_userdata("busimage");
                                break;
                            case 4: // 旧营业照组织机构代码证
                                $this->session->set_userdata("busimage3", $images);
                                $this->session->set_userdata("busimage");
                                break;
                            case 5: // 身份证正
                                $this->session->set_userdata("idcardimage", $images);
                                break;
                            case 6: // 身份证反
                                $this->session->set_userdata("idcardbackimage", $images);
                                break;
                            case 7: // 委托书
                                $this->session->set_userdata("proxy_img", $images);
                                break;
                        }
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }

    /**
     * 认证保存
     */
    public function authenticate_save()
    {
        $this->load->model("corporation_detail_mdl", "cd");
        $this->load->model("corporation_mdl");
        
        $new = $this->session->userdata('busimage');
        $old = $this->session->userdata('busimage1');
        $old2 = $this->session->userdata('busimage2');
        $old3 = $this->session->userdata('busimage3');
        $idcard = $this->session->userdata('idcardimage');
        $idcardback = $this->session->userdata('idcardbackimage');
        $proxy = $this->session->userdata('proxy_img');
        $corporation_id = $this->session->userdata['corporation_id'];
        
        if ($new == "") {
            $bus_licence_img = $old . ";" . $old2 . ";" . $old3;
        } else {
            $bus_licence_img = $new;
        }
        
        $idcard_img = $idcard . ";" . $idcardback;
        
        $this->cd->bus_licence_img = $bus_licence_img;
        $this->cd->idcard_img = $idcard_img;
        $this->cd->proxy_img = $proxy;
        $this->cd->corporation_id = $corporation_id;
        
        $res = $this->cd->update();
        if ($res) {
            $this->session->set_userdata("busimage");
            $this->session->set_userdata("busimage1");
            $this->session->set_userdata("busimage2");
            $this->session->set_userdata("busimage3");
            $this->session->set_userdata("idcardimage");
            $this->session->set_userdata("idcardbackimage");
            $this->session->set_userdata("proxy_img");
            
            $this->corporation_mdl->approval_status = 1;
            $this->corporation_mdl->corporation_id = $corporation_id;
            $result = $this->corporation_mdl->update();
            if ($result) {
                redirect('corporate/myshop/get_shop/10');
            }
        } else {
            $data['type'] = true;
            $data['auto'] = true;
            $data['msg'] = '保存失败！';
            $data['goto'] = site_url('corporate/myshop/ad_admin');
            return $this->load->view('message', $data);
            // error_log ( "上传文件失败，原因：" . $this->upload->display_errors ( '<p>', '</p>' ) );
        }
    }

    /**
     * 修改店铺资料
     */
    public function save_shop()
    {
        $cd = $this->input->post();
        $this->load->model('corporation_mdl', 'cus_cor');
        $this->load->model('corporation_detail_mdl', 'cd');
        
        // 修改店铺corporation
        $this->cus_cor->contact_name = $cd['contact_name'];
        $this->cus_cor->address = $cd['address'];
        $this->cus_cor->province_id = ! empty($cd['province_id']) ? $cd['province_id'] : 0;
        $this->cus_cor->city_id = ! empty($cd['city_id']) ? $cd['city_id'] : 0;
        $this->cus_cor->district_id = ! empty($cd['district_id']) ? $cd['district_id'] : 0;
        $this->cus_cor->postcode = $cd['postcode'];
        $this->cus_cor->email = $cd['email'];
        $this->cus_cor->contact_mobile = $cd['contact_mobile'];
        $this->cus_cor->corporation_id = $cd['id'];
        $this->cus_cor->auto_order_amount = ! empty($cd['auto_order_amount']) ? $cd['auto_order_amount'] : "0.00";
        
        $res = $this->cus_cor->update();
        
        // 修改店铺详情corporation_detail
        $this->cd->nature = $cd['nature'];
        $this->cd->Industrial_Info = $cd['Industrial_Info'];
        $this->cd->entry_requirements = $cd['entry_requirements'];
        $this->cd->company_size = $cd['company_size'];
        $this->cd->company_wechat = $cd['company_wechat'];
        $this->cd->company_web = $cd['company_web'];
        $this->cd->Registered_Capital = $cd['Registered_Capital'];
        $this->cd->company_establish = $cd['company_establish'];
        $this->cd->corporation_id = $cd['id'];
        
        $result = $this->cd->update();
        
        if ($res && $result) {
            redirect('corporate/myshop/get_shop/11');
        } else {
            $data['type'] = true;
            $data['auto'] = true;
            $data['msg'] = '修改失败！';
            $data['goto'] = site_url('corporate/myshop/get_shop');
            return $this->load->view('message', $data);
        }
    }

    /**
     * 图片上传方法
     *
     * @param int $id            
     */
    public function file_upload()
    {
        $this->load->model('corporation_mdl', 'cus_cor');
        
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $cor_id = $this->session->userdata['corporation_id'];
            
            // 图片
            if (! empty($_FILES)) {
                
                $save_path = 'shop/' . $cor_id . '/'; // 'product/' . $id . '/';
                                                      // $path = UPLOADS.$save_path;
                $path = FCPATH . UPLOAD_PATH . "uploads/" . $save_path;
                if (! file_exists($path)) {
                    mkdirsByPath($path);
                }
                $config['file_name'] = $customer_id . '_' . date("His");
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['max_filename'] = '50';
                $this->load->library('upload');
                // 删除原来的图片
                $condition = $this->cus_cor->load($customer_id);
                if (isset($condition['img_url']) && $condition['img_url'] !== '') {
                    
                    if (file_exists(FCPATH . UPLOAD_PATH . $condition['img_url'])) {
                        
                        $result = unlink(FCPATH . UPLOAD_PATH . $condition['img_url']);
                    }
                }
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file')) {
                    
                    $uploaded = $this->upload->data();
                    $cd['databases_img_url'] = "./uploads/" . $save_path . $uploaded['file_name'];
                    $cd['img_url'] = IMAGE_URL."./uploads/" . $save_path . $uploaded['file_name'];
                    $this->cus_cor->img_url = $cd['databases_img_url'];
                    $res = $this->cus_cor->save_img($customer_id);
                    if (isset($condition['QR_code']) && $condition['QR_code'] !== '') {
                        
                        if (file_exists(FCPATH . UPLOAD_PATH . $condition['QR_code'])) {
                            
                            $result = unlink(FCPATH . UPLOAD_PATH . $condition['QR_code']);
                        }
                    }
                    $cd['QR_code'] = $this->make_QR_code($cor_id);
                    $cd['QR_code'] = '.' . $cd['QR_code'];
                    $this->cus_cor->QR_code = $cd['QR_code'];
                    $result = $this->cus_cor->save_img($customer_id);
                    
                    echo json_encode($cd);
                } else {
                    error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                }
            } else {
                error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
            }
        } catch (Exception $e) {
            error($e);
        }
    }

    /**
     * 二维码生成图
     */
    public function make_QR_code($corporation_id)
    {
        $this->load->model('corporation_mdl');
        $corporation = $this->corporation_mdl->load_id($corporation_id);
        $data = site_url('home/GoToShop/' . $corporation_id);
        $size = '400x400';
        $logo = dirname(BASEPATH) . substr($corporation['img_url'], 1);
        
        include dirname(BASEPATH) . "/phpqrcode/qrlib.php"; // 引入生成二维码文件
        $errorCorrectionLevel = "L"; // 二维码容错级别
        $matrixPointSize = "6"; // 二维码大小
        
        $file = '/uploads/shop/' . $corporation_id . '/QR_code_' . $corporation_id . '_' . date('His') . '.png';
        
        QRcode::png($data, dirname(BASEPATH) . $file, $errorCorrectionLevel, $matrixPointSize, 1);
        
        $QR = imagecreatefromstring(file_get_contents("." . $file));
        
        if ($logo !== FALSE) {
            $logo = imagecreatefromstring(file_get_contents($logo));
            
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            
            $logo_qr_width = $QR_width / 4;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        
        imagepng($QR, FCPATH . UPLOAD_PATH . '/uploads/shop/' . $corporation_id . '/QR_code_' . $corporation_id . '_' . date('His') . '.png');
        
        imagedestroy($QR);
        
        return $file;
    }

    /**
     * 广告管理
     */
    public function ad_admin()
    {
        $cus_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('ad_mdl');
        $data['ad'] = $this->ad_mdl->getlist($cus_id);
        
        $data['title'] = '我的店铺';
        
        // print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/ad_detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 添加广告
     */
    /*
     * public function add_ad(){
     *
     * $this->edit_ad();
     *
     * }
     */
    
    /**
     * 编辑广告
     */
    public function edit_ad($id = '')
    {
        $this->load->model('ad_mdl');
        
        if ($id) {
            $data['ad'] = $this->ad_mdl->load($id);
            $data['title'] = '我的店铺--广告编辑';
        } else {
            $data['title'] = '我的店铺--广告添加';
        }
        $data['po'] = $this->ad_mdl->get_adpo();
        
        // print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/ad_edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 保存广告
     */
    public function save_ad()
    {
        $cd = $this->input->post();
        
        $app_id = $this->session->userdata('app_info')['id'];
        
        $cus_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('ad_mdl');
        $this->ad_mdl->corporation_id = $cus_id;
        $this->ad_mdl->app_id = $app_id;
        if (isset($cd['po_id'])) {
            $this->ad_mdl->po_id = $cd['po_id'];
        }
        if (isset($cd['title'])) {
            $this->ad_mdl->title = $cd['title'];
        }
        $this->ad_mdl->url = $cd['url'];
        $this->ad_mdl->sort_order = $cd['sort_order'];
        
        if (isset($cd['ad_id']) && $cd['ad_id'] > 0) {
            $this->ad_mdl->ad_id = $cd['ad_id'];
            // echo 123;exit;
            $res = $this->ad_mdl->save();
        } else {
            // echo 456;exit;
            $res = $this->ad_mdl->create();
        }
        
        echo $res;
    }

    /**
     * 上传广告图片
     */
    public function img_url($id = '')
    {
        $cd = $this->input->post();
        $this->load->model('ad_mdl');
        
        if (is_array($cd)) {
            $app_id = $this->session->userdata('app_info')['id'];
            
            $cus_id = $this->session->userdata['corporation_id'];
            
            $this->ad_mdl->corporation_id = $cus_id;
            $this->ad_mdl->app_id = $app_id;
            if (isset($cd['po_id'])) {
                $this->ad_mdl->po_id = $cd['po_id'];
            }
            if (isset($cd['title'])) {
                $this->ad_mdl->title = $cd['title'];
            }
            $this->ad_mdl->url = $cd['url'];
            $this->ad_mdl->sort_order = $cd['sort_order'];
            
            $this->ad_mdl->ad_id = $id;
            $res = $this->ad_mdl->save();
        }
        
        $this->load->library('upload');
        if (! empty($_FILES)) {
            
            $path = FCPATH . UPLOAD_PATH . "./uploads/ad/" . date('Y-m-d') . '/';
            $save_path = "./uploads/ad/" . date('Y-m-d') . '/';
            try {
                
                if (! file_exists($path)) {
                    
                    mkdir($path, 0777, true);
                }
            } catch (Exception $e) {
                log_message($e);
            }
            
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['file_name'] = date("YmdHis");
            /*
             * $config['width'] = 50;
             * $config['height'] = 50;
             */
            // $this->load->library('image_lib',$config);
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('img_url')) {
                // 替换原图
                if (isset($id) && $id > 0) {
                    
                    $condition = $this->ad_mdl->load($id);
                    
                    if (isset($condition['img_url']) && $condition['img_url'] !== '') {
                        
                        if (file_exists(FCPATH . UPLOAD_PATH . $condition['img_url'])) {
                            $result = unlink(FCPATH . UPLOAD_PATH . $condition['img_url']);
                        }
                    }
                }
                
                $uploaded = $this->upload->data();
                $data['img_url'] = $save_path . $uploaded['file_name'];
                // 修改数据库
                
                if (isset($id) && $id > 0) {
                    $this->ad_mdl->img_url = $data['img_url'];
                    $data['success'] = $this->ad_mdl->save_imgurl($id);
                }
            }
        }
        // 返回
        if (isset($res) || isset($data['success'])) {
            // return show_message2('上传成功!', 'employee');
            
            redirect('corporate/myshop/edit_ad/' . $id);
        } else {
            $data['type'] = true;
            $data['auto'] = true;
            $data['msg'] = '上传失败！图片大小超出2M，请上传2M以下的图片！';
            $data['goto'] = site_url('corporate/myshop/ad_admin');
            return $this->load->view('message', $data);
            // error_log ( "上传文件失败，原因：" . $this->upload->display_errors ( '<p>', '</p>' ) );
        }
    }

    /**
     * 删除广告
     */
    public function deleted()
    {
        $img_url = $this->input->post('img_url');
        $id = $this->input->post('id');
        $this->load->model('ad_mdl');
        $this->ad_mdl->ad_id = $id;
        $res = $this->ad_mdl->deleted();
        if (isset($img_url) && $img_url != '') {
            if (file_exists(FCPATH . UPLOAD_PATH . $img_url)) {
                
                $result = unlink(FCPATH . UPLOAD_PATH . $img_url);
            }
        }
        if ($res == TRUE || (isset($result) && $result == TRUE)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * 批量删除广告
     */
    public function batch_del()
    {
        $cd = $this->input->post();
        // print_r($cd);exit;
        $this->load->model('ad_mdl');
        
        for ($i = 0; $i < count($cd['checkbox']); $i ++) {
            
            $cd['img_url'] = $this->ad_mdl->load($cd['checkbox'][$i])['img_url'];
            
            if (isset($cd['img_url']) && $cd['img_url'] != '') {
                if (file_exists(FCPATH . UPLOAD_PATH . $cd['img_url'])) {
                    
                    $result = unlink(FCPATH . UPLOAD_PATH . $cd['img_url']);
                }
            }
            $this->ad_mdl->ad_id = $cd['checkbox'][$i];
            $res = $this->ad_mdl->deleted();
        }
        if ($res == TRUE || (isset($result) && $result == TRUE)) {
            redirect('corporate/myshop/ad_admin');
        } else {
            $data['type'] = true;
            $data['auto'] = true;
            $data['msg'] = '删除失败！';
            $data['goto'] = site_url('corporate/myshop/ad_admin');
            return $this->load->view('message', $data);
        }
    }

    /**
     * 角色管理
     */
    public function role()
    {
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('role_mdl');
        
        $data['list'] = $this->role_mdl->getList($app_id);
        
        $data['title'] = '我的店铺--角色管理';
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/role_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 增加角色
     */
    /*
     * public function add_role(){
     *
     * $this->edit_role();
     * }
     *
     * public function edit_role($id = ''){
     *
     * if(isset($id) && $id>0){
     * $this->load->model('role_mdl');
     *
     * $data['dt'] = $this->role_mdl->load($id);
     * }
     *
     * $data['title'] = '我的店铺--角色管理';
     * //print_r($data);exit;
     * $this->load->view ( 'head', $data );
     * $this->load->view ( '_header', $data );
     * $this->load->view ( 'corporate/shop/role_edit', $data );
     * $this->load->view ( '_footer', $data );
     * $this->load->view ( 'foot', $data );
     * }
     *
     * /**
     * 菜单管理
     */
    public function menu_list()
    {
        $customer_id = $this->session->userdata['user_id'];
        $this->load->model('customer_menu_mdl', 'menu');
        $data['list'] = $this->menu->getList($customer_id);
        
        $data['title'] = '我的店铺--菜单管理';
        // print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/menu_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * *
     * 添加菜单
     */
    public function add_menu()
    {
        $this->edit_menu();
    }

    /**
     * 编辑菜单
     */
    public function edit_menu($id = '')
    {
        if (isset($id) && $id > 0) {
            $this->load->model('customer_menu_mdl', 'menu');
            $data['dt'] = $this->menu->load($id);
        }
        
        $data['title'] = '我的店铺--菜单管理';
        // print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/menu_edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 保存菜单
     */
    public function save_menu()
    {
        $cd = $this->input->post();
        
        $app_id = $this->session->userdata('app_info')['id'];
        
        $cus_id = $this->session->userdata['user_id'];
        
        $this->load->model('customer_menu_mdl', 'menu');
        $this->menu->customer_id = $cus_id;
        $this->menu->app_id = $app_id;
        $this->menu->sequence = $cd['sequence'];
        $this->menu->url = $cd['url'];
        $this->menu->menu_name = $cd['menu_name'];
        
        if (isset($cd['id']) && $cd['id'] > 0) {
            
            // echo 123;exit;
            $res = $this->menu->save($cd['id']);
            if ($res == 1) {
                echo 'success';
            }
        } else {
            // echo 456;exit;
            $res = $this->menu->create();
            
            echo $res;
        }
    }

    /**
     * 菜单删除
     */
    public function menu_del()
    {
        $id = $this->input->post('id');
        $this->load->model('customer_menu_mdl', 'menu');
        $this->menu->id = $id;
        $res = $this->menu->deleted();
        
        if ($res == TRUE) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * 批量删除菜单
     */
    public function batch_menu_del()
    {
        $cd = $this->input->post();
        // print_r($cd);exit;
        $this->load->model('customer_menu_mdl', 'menu');
        
        for ($i = 0; $i < count($cd['checkbox']); $i ++) {
            
            $this->menu->id = $cd['checkbox'][$i];
            $res = $this->menu->deleted();
        }
        if ($res == TRUE || (isset($result) && $result == TRUE)) {
            redirect('corporate/myshop/menu_list');
        } else {
            $data['type'] = true;
            $data['auto'] = true;
            $data['msg'] = '删除失败！';
            $data['goto'] = site_url('corporate/myshop/menu_list');
            return $this->load->view('message', $data);
        }
    }

    /**
     * 账号管理
     */
    public function user()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
//         }

        $corporation_id = $this->session->userdata['corporation_id'];
        $this->load->model('corporation_staff_mdl');
        $config['per_page'] = 10;
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $config['per_page'];
        $this->load->library('pagination');
        $config['base_url'] = site_url('corporate/myshop/user/?');
        $config['total_rows'] = $this->corporation_staff_mdl->get_corporation_staff_list($corporation_id,true);
        $config['per_page'] = $config['per_page'];
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        
        if ($config['total_rows'] != null){
            $data['pagination'] = $this->pagination->create_links();
        }
        $data['list'] = $this->corporation_staff_mdl->get_corporation_staff_list($corporation_id,false,$config['per_page'],$offset);//查询店铺员工

        //查询全部职位
        $data["role_list"] = $this->corporation_staff_mdl->load_role();


        $data['title'] = '我的店铺--账号管理';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/user_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 添加企业员工
     */
    public function user_add()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo json_encode(array("status"=>"error"));exit;
//         }
        
        $mobile = $this->input->post('mobile');//手机号码
        $role_id = $this->input->post('role_id');//角色id
        $corporation_id = $this->session->userdata("corporation_id");//店铺id
        
        if(preg_match("/^1[34578]{1}\d{9}$/",$mobile) && $role_id){
            $this->load->model('customer_mdl');
            $this->load->model('corporation_staff_mdl');
            //查询判断用户是否存在
            $customer = $this->customer_mdl->load_by_name($mobile);
            if($customer){
                $customer_id = $customer['id'];
                //判断是否企业用户
                $this->load->model("corporation_mdl");
                $is_corp = $this->corporation_mdl->load_corporation_info($customer_id);
                if(!$is_corp){
                    //查询判断职位是否存在
                    $is_role = $this->corporation_staff_mdl->load_role($role_id);
                    if($is_role){
                        //查询判断此用户是否本店员工
                        $is_staff = $this->corporation_staff_mdl->get_corp_staff($customer_id,$corporation_id);
                        if(!$is_staff){//添加员工
                            $row = $this->corporation_staff_mdl->add_staff($customer_id,$role_id,$corporation_id);//添加员工
                            if($row){
                                echo json_encode(array("status"=>"success"));exit;//成功
                            }else{
                                echo json_encode(array("status"=>"fail"));exit;//失败
                            }
                        }else{
                            echo json_encode(array("status"=>"exist"));exit;//已经存在
                        }
                    }else{
                       echo json_encode(array("status"=>"error"));exit;//非法操作
                    }
                }else{
                    echo json_encode(array("status"=>"crop_exist"));exit;//企业用户
                }
            }else{
                echo json_encode(array("status"=>"not_user"));exit;//用户不存在
            }

        }else{
            echo json_encode(array("status"=>"error_mobile"));exit;//手机号码错误
            
        }
    }
    
    //-------------------------------------------------------------------------------
    
    /**
     * 修改员工状态
     */
    public function save_status(){
        $id = $this->input->post("staff_id");//id
        $status = $this->input->post("status");//状态
        $corporation_id = $this->session->userdata("corporation_id");//店铺id
        if($id && $status && $corporation_id){
            $this->load->model('corporation_staff_mdl');
            $row = $this->corporation_staff_mdl->save_status($id,$corporation_id,$status);
            if($row){
                echo "成功";
            }else{
                echo "失败";
            }
        }else{
            echo "数据有问题";exit;
        }
    }
    
    //-------------------------------------------------------------------------------
    
    /**
     * 查询待邀请的人员
     */
    public function invitation_list()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//              echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
//         }
        
        $corporation_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('corporation_staff_mdl');
        $config['per_page'] = 10;
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $config['per_page'];
        $this->load->library('pagination');
        $config['base_url'] = site_url('corporate/myshop/user/?');
        $config['total_rows'] = $this->corporation_staff_mdl->get_corporation_staff_list($corporation_id,true,NULL,NULL,NULL,0);
        $config['per_page'] = $config['per_page'];
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        if ($config['total_rows'] != null){
            $data['pagination'] = $this->pagination->create_links();
        }
        $data['list'] = $this->corporation_staff_mdl->get_corporation_staff_list($corporation_id,false,$config['per_page'],$offset,NULL,0);//查询店铺员工
        //查询全部职位
        $data["role_list"] = $this->corporation_staff_mdl->load_role();
        
        $data['title'] = '我的店铺--账号管理';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/user_add', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);

    }
    

    /**
     * 邀请用户
     */
    public function invitation()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo 0;exit;
//         }
        
        $id = $this->input->post('id');
        $corporation_id = $this->session->userdata['corporation_id'];
        $this->load->model('corporation_staff_mdl');
        $res = $this->corporation_staff_mdl->save_status($id,$corporation_id,2);
        echo $res;
    }

    /**
     * 编辑账号
     */
    public function user_edit($id)
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
//         }
        
        $corporation_id = $this->session->userdata("corporation_id");
        $this->load->model('corporation_staff_mdl');
        //根据id查询店铺员工
        $data['dt'] = $this->corporation_staff_mdl->get_corporation_staff_list($corporation_id,FALSE,NULL,NULL,$id);
        //查询全部职位
        $data["role_list"] = $this->corporation_staff_mdl->load_role();

        
        $data['title'] = '我的店铺--账号管理';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/user_edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 保存账号
     */
    public function user_save()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
//         }
        
        
        $id = $this->input->post("id");//staff_id
        $status = $this->input->post("status");//状态
        if($status !=1 && $status !=2 && $status !=3){
            echo "<script>alert('修改失败');history.back(-1);</script>";exit();
        }
        $role_id = $this->input->post("role_id");//职位id
        $remark = $this->input->post("remark");//备注
        $corporation_id = $this->session->userdata("corporation_id");
        $this->load->model('corporation_staff_mdl');
        $this->corporation_staff_mdl->status = $status;
        $this->corporation_staff_mdl->corp_role_id = $role_id;
        $this->corporation_staff_mdl->remark = $remark;

        //更新
        $row = $this->corporation_staff_mdl->save($id);

        if ($row){
            redirect('corporate/myshop/user');
        }else{
            echo "<script>alert('修改失败');history.back(-1);</script>";return;
        }

    }

    /**
     * 删除员工,不能删除自己
     */
    public function nobind()
    {
//         //验证权限
//         $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         $power = $this->session->userdata("power");//权限
//         $customer_id = $this->session->userdata("user_id");//用户id
//         if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
//             echo false;exit;
//         }
        
        $id = $this->input->post("id");
        $corporation_id = $this->session->userdata("corporation_id");
        
        $this->load->model('corporation_staff_mdl');
        $res = $this->corporation_staff_mdl->del($id,$corporation_id,$customer_id);
        if($res){
            echo true;
        }else{
            echo false;
        }
    }

//     /**
//      * 解冻账号
//      */
//     public function is_freeze()
//     {
//         $cd = $this->input->post();
        
//         $this->load->model('customer_mdl');
//         for ($i = 0; $i < count($cd['id']); $i ++) {
//             $this->customer_mdl->corporation_status = $cd['freeze'];
            
//             $res = $this->customer_mdl->cor_user_save($cd['id'][$i]);
//         }
//         if ($res == TRUE) {
//             redirect('corporate/myshop/user');
//         } else {
//             $data['type'] = true;
//             $data['auto'] = true;
//             $data['msg'] = '解冻失败！';
//             $data['goto'] = site_url('corporate/myshop/user');
//             return $this->load->view('message', $data);
//         }
//     }

    public function renovate()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $this->load->model('template_mdl', 'tp');
        $data['banner'] = $this->tp->load($cor_id, 'banner_1');
        $data['le_1'] = $this->tp->load($cor_id, 'level_1');
        $data['level'] = $this->tp->get_list($cor_id, 'banner', 1);
        $this->load->model('corporation_mdl', 'cp');
        $data['corporate'] = $this->cp->load_id($cor_id);
        
        $data['title'] = '店铺模板';
        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('corporate/shop/view/store_templateSingle', $data);
    }

    /**
     * 版块处理
     */
    public function upload_1()
    {
        $link_path = $this->input->post('link_path');
        $banner = $this->input->post('banner_1');
        $cor_id = $this->session->userdata['corporation_id'];
        $id = $this->input->post('id');
        $this->load->library('upload');
        
        $this->load->model('template_mdl', 'tp');
        
        $this->load->helper('ps_helper');
        
        // var_dump($_FILES);exit;
        try {
            if (! empty($_FILES)) {
                $path = FCPATH . UPLOAD_PATH . "./uploads/corporation_template/C_" . $cor_id . '/images/';
                $save_path = "./uploads/corporation_template/C_" . $cor_id . '/images/';
                
                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                    // mkdirsByPath($path);
                }
                
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['file_name'] = date('His');
                
                $cd = $this->tp->load($cor_id, 'banner_1', 1);
                
                if (isset($cd['id'])) {
                    $p = $cd['img_path'];
                    
                    if (file_exists(FCPATH . UPLOAD_PATH . $p)) {
                        
                        unlink(FCPATH . UPLOAD_PATH . $p);
                    }
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file')) {
                    
                    $uploaded = $this->upload->data();
                    $data['img_path'] = $save_path . $uploaded['file_name'];
                    // 修改数据库
                    if ($id) {
                        
                        $this->tp->corporation_id = $cor_id;
                        $this->tp->template_id = 1;
                        $this->tp->temp_key = $banner;
                        $this->tp->img_path = $data['img_path'];
                        if (isset($link_path))
                            $this->tp->link_path = $link_path;
                        $res = $this->tp->update($id);
                        $data['id'] = $id;
                        
                        if ($res) {
                            $data['img_path'] = IMAGE_URL . $data['img_path'];
                            echo json_encode($data);
                        }
                    } else {
                        $this->tp->corporation_id = $cor_id;
                        $this->tp->template_id = 1;
                        $this->tp->temp_key = $banner;
                        $this->tp->img_path = $data['img_path'];
                        $this->tp->link_path = $link_path;
                        
                        $res = $this->tp->create();
                        $data['id'] = $res;
                        if ($res) {
                            $data['img_path'] = IMAGE_URL . $data['img_path'];
                            echo json_encode($data);
                        }
                    }
                } else {
                    echo json_encode('上传失败');
                }
            }
        } catch (Exception $e) {
            log_message($e);
        }
    }
    
    // $corporation_id 店铺ID
    // $template_id 模板ID
    public function Template($template_id = '1')
    {
        $corporation_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('corporation_template_set_mdl');
        $result = $this->corporation_template_set_mdl->select_template($corporation_id, $template_id);
        
        $text = file_get_contents(SUITEPATH . SUITE . "/views/default/corporation_template/store_templateSingle.txt");
        
        $body = substr($text, strpos($text, "<#page_body_begin#>") + 19, strpos($text, "<#page_body_end#>") - 38 - strpos($text, "<#page_body_begin#>") + 19);
        
        $str = '';
        $banner = '';
        foreach ($result as $k => $v) {
            if ($v['temp_key'] == 'banner') {
                
                $banner = '<img src="' . IMAGE_URL . $v['img_path'] . '" width="1920" height="100" alt=""/>';
            } else 
                if ($v['temp_key'] == 'level') {
                    
                    $str .= $body;
                    $str = str_replace('<#body_content#>', '<a href="' . $v['link_path'] . '"><img src="' . IMAGE_URL . $v['img_path'] . '" alt=""/></a>', $str);
                }
        }
        
        $save_path = FCPATH . UPLOAD_PATH . './uploads/corporation_template/C_' . $corporation_id . '';
        // 测试时删除文件所有的代码。
        // $fh = fopen($save_path.'/index.php', 'w') or die("can't open file");
        // fclose($fh);
        
        // unlink($save_path.'/index.php');
        // rmdir($save_path);
        // exit;
        
        if (! file_exists($save_path)) {
            mkdir($save_path, 0777);
        }
        
        $html = str_replace('<#banner_1#>', $banner, $text);
        $html = str_replace('<!--s', '', $html);
        $html = str_replace('s-->', '', $html);
        $body = substr($text, strpos($text, "<#page_body_begin#>"), strpos($text, "<#page_body_end#>") - strpos($text, "<#page_body_begin#>") + 19);
        
        $html = str_replace($body, $str, $html);
        $html = file_put_contents($save_path . '/index.php', $html);
        
        // 更新企业表的模板字段
        $this->load->model('customer_corporation_mdl');
        $this->customer_corporation_mdl->updateTemplate($corporation_id, $template_id, $save_path);
        if ($html) {
            echo '发布成功';
        }
    }

    public function TemplatePreview($template_id = '1')
    {
        $corporation_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('corporation_template_set_mdl');
        $result = $this->corporation_template_set_mdl->select_template($corporation_id, $template_id);
        $i = 0;
        $data["levelList"] = array();
        foreach ($result as $k => $v) {
            if ($v['temp_key'] == 'banner') {
                $data['banner_url'] = $v['link_path'];
                $data['banner_img'] = $v['img_path'];
            } else 
                if ($v['temp_key'] == 'level') {
                    
                    $data["levelList"][$i] = $v;
                    $i ++;
                }
        }
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporation_template/store_templateSingle_preview', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    function ResetTemplate($template_id = '1')
    {
        $corporation_id = $this->session->userdata['corporation_id'];
        $user_id = $this->session->userdata['user_id'];
        $path = FCPATH . UPLOAD_PATH . "./uploads/corporation_template/C_" . $corporation_id . '/images/';
        $this->load->model('corporation_template_set_mdl');
        $result = $this->corporation_template_set_mdl->select_template($corporation_id, $template_id);
        foreach ($result as $k => $v) {
            if ($v["img_path"] != '' && file_exists(FCPATH . UPLOAD_PATH . $v["img_path"])) {
                
                unlink(FCPATH . UPLOAD_PATH . $v["img_path"]);
            }
        }
        $this->corporation_template_set_mdl->DeleteByTemplateID($corporation_id, $template_id);
        $this->load->model('customer_corporation_mdl');
        $data = $this->customer_corporation_mdl->load($user_id);
        
        switch ($template_id) {
            case 1:
                $url = 'renovate';
                break;
            case 2:
                $url = 'select_goods_temp';
                break;
            case 3:
                $url = 'select_three_temp';
                break;
            case 5:
                $url = 'flagship_two_temp';
                break;
            case 6:
                $url = 'flagship_three_temp';
        }
        
        if ($data['template_type'] == $template_id) {
            
            $this->customer_corporation_mdl->updateTemplate($corporation_id, null, null);
        }
        if ($template_id < 4) {
            redirect("corporate/myshop/" . $url);
        } else {
            redirect("flagship/" . $url);
        }
    }

    function upload_head()
    {
        $link_path = $this->input->post('link_path');
        $level = $this->input->post('level');
        $cor_id = $this->session->userdata['corporation_id'];
        $id = $this->input->post('id');
        $this->load->library('upload');
        $color = $this->input->post('color');
        $this->load->model('template_mdl', 'tp');
        
        // var_dump($_FILES);exit;
        try {
            if (! empty($_FILES)) {
                $path = FCPATH . UPLOAD_PATH . "./uploads/corporation_template/C_" . $cor_id . '/images/';
                $save_path = "./uploads/corporation_template/C_" . $cor_id . '/images/';
                
                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                    // mkdirsByPath($path);
                }
                
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['file_name'] = date('His');
                
                $cd = $this->tp->load($cor_id, $level, 1);
                if (isset($cd['id'])) {
                    $p = $cd['img_path'];
                    
                    if (file_exists(FCPATH . UPLOAD_PATH . $p)) {
                        
                        unlink(FCPATH . UPLOAD_PATH . $p);
                    }
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file2')) {
                    $uploaded = $this->upload->data();
                    $data['img_path'] = $save_path . $uploaded['file_name'];
                    // 修改数据库
                    if ($id) {
                        $this->tp->corporation_id = $cor_id;
                        $this->tp->template_id = 1;
                        $this->tp->temp_key = $level;
                        $this->tp->img_path = $data['img_path'];
                        $this->tp->desc = $color;
                        if (isset($link_path))
                            $this->tp->link_path = $link_path;
                        $res = $this->tp->update($id);
                        $data['color'] = $color;
                        if ($res) {
                            $data['img_path'] = IMAGE_URL . $data['img_path'];
                            echo json_encode($data);
                        }
                    } else {
                        $this->tp->corporation_id = $cor_id;
                        $this->tp->template_id = 1;
                        $this->tp->temp_key = $level;
                        $this->tp->img_path = $data['img_path'];
                        $this->tp->desc = $color;
                        if (isset($link_path))
                            $this->tp->link_path = $link_path;
                        
                        $res = $this->tp->create();
                        $data['id'] = $res;
                        $data['color'] = $color;
                        if ($res) {
                            $data['img_path'] = IMAGE_URL . $data['img_path'];
                            echo json_encode($data);
                        }
                    }
                } else {
                    echo json_encode('上传失败');
                }
            }
        } catch (Exception $e) {
            log_message($e);
        }
    }

    function add_template()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $level = $this->input->post('level');
        $this->load->model('template_mdl', 'tp');
        $this->tp->corporation_id = $cor_id;
        $this->tp->template_id = 1;
        // $this->tp->temp_key = $level;
        
        $res = $this->tp->create();
        // $data['id'] = $res;
        // $data['level'] = $level;
        if ($res) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    function upload_level()
    {
        $link_path = $this->input->post('link_path');
        $level = $this->input->post('level');
        $cor_id = $this->session->userdata['corporation_id'];
        $id = $this->input->post('id');
        $color = $this->input->post('color');
        $this->load->library('upload');
        
        $this->load->model('template_mdl', 'tp');
        
        // var_dump($_FILES);exit;
        try {
            if (! empty($_FILES)) {
                $path = FCPATH . UPLOAD_PATH . "./uploads/corporation_template/C_" . $cor_id . '/images/';
                $save_path = "./uploads/corporation_template/C_" . $cor_id . '/images/';
                
                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                    // mkdirsByPath($path);
                }
                
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['file_name'] = date('His');
                
                $cd = $this->tp->load($cor_id, $level, 1);
                if (isset($cd['id'])) {
                    $p = $cd['img_path'];
                    
                    if (file_exists(FCPATH . UPLOAD_PATH . $p)) {
                        
                        unlink(FCPATH . UPLOAD_PATH . $p);
                    }
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file')) {
                    
                    $uploaded = $this->upload->data();
                    $data['img_path'] = $save_path . $uploaded['file_name'];
                    // 修改数据库
                    if ($id) {
                        $this->tp->link_path = $link_path;
                        $this->tp->img_path = $data['img_path'];
                        $this->tp->temp_key = $level;
                        $this->tp->desc = $color;
                        $res = $this->tp->update($id);
                        $data['id'] = $id;
                        $data['color'] = $color;
                        if ($res) {
                            $data['img_path'] = IMAGE_URL . $data['img_path'];
                            echo json_encode($data);
                        }
                    }
                } else {
                    echo json_encode('上传失败');
                }
            }
        } catch (Exception $e) {
            log_message($e);
        }
    }

    function deleted_temp()
    {
        $id = $this->input->post('id');
        $cor_id = $this->session->userdata['corporation_id'];
        $this->load->model('template_mdl', 'tp');
        
        $cd = $this->tp->loader($id);
        
        if ($cd['corporation_id'] != $cor_id) {
            return false;
        }
        $p = $cd['img_path'];
        if($p){
            if (file_exists(FCPATH . UPLOAD_PATH . $p)) {
            
                unlink(FCPATH . UPLOAD_PATH . $p);
            }
        }
        
        $res = $this->tp->delete($id);
        
        if ($res) {
            echo $id;
        } else {
            echo 0;
        }
    }
    
    // function temp_select(){
    
    // $this->load->view ( 'corporate/shop/view/store_templateSingle',$data);
    // }
    
    /**
     * 显示编辑店铺模板2
     */
    function select_goods_temp()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($cor_id);
        $data['corporate'] = $corporate;
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $cor_id;
            $data['product_fav'] = $this->product->hot_product();
            $data['product_sales'] = $this->product->sales_product();
            
            $data['menu_list'] = $this->section->shop_classify_list($cor_id, true, $app_id);
            $data['list'] = $this->tp->select_goods_temp($cor_id, '2');
            $this->load->view('corporate/shop/view/store_templateLess', $data);
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 更改商品的模板2&3&4&5
     */
    function upload_goods_top()
    {
        $link_path = $this->input->post('link_path');
        $temp_key = $this->input->post('temp_key');
        $desc = $this->input->post('desc');
        $pic = $this->input->post('pic');
        $tem_id = $this->input->post('tem');
        $brief_statement = $this->input->post('desc_name');
        
        $cor_id = $this->session->userdata['corporation_id'];
        
        $this->load->library('upload');
        $this->load->model('corporation_mdl', 'cp');
        $this->load->model('template_mdl', 'tp');
        $corporate = $this->cp->load_id($cor_id);
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            
            $cd = $this->tp->load($cor_id, $temp_key, $tem_id);
            $this->tp->link_path = $link_path;
            $this->tp->temp_key = $temp_key;
            $this->tp->corporation_id = $cor_id;
            $this->tp->desc = $desc;
            $this->tp->pic = $pic;
            $this->tp->template_id = $tem_id;
            $this->tp->brief_statement = $brief_statement;
            
            try {
                if ($_FILES['file']['name'] != '') {
                    $path = FCPATH . UPLOAD_PATH . "./uploads/corporation_template/C_" . $cor_id . '/images/';
                    $save_path = "./uploads/corporation_template/C_" . $cor_id . '/images/';
                    // echo json_encode($path);exit;
                    // $path ="/Users/js-php-01/Html/";
                    // $save_path = "/Users/js-php-01/Html/";
                    if ($tem_id == 2) {
                        $img_name = '_tem_2';
                    } else 
                        if ($tem_id == 3) {
                            $img_name = '_tem_3';
                        } else 
                            if ($tem_id == 4) {
                                $img_name = '_tem_4'; // 旗舰店一
                            } else 
                                if ($tem_id == 5) {
                                    $img_name = '_tem_5'; // 旗舰店二
                                } else {
                                    $img_name = '_tem_6'; // 旗舰三
                                }
                    
                    if (! file_exists($path)) {
                        mkdir($path, 0777, true);
                        // mkdirsByPath($path);
                    }
                    
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = '2000';
                    $config['file_name'] = date('His') . $img_name;
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        $uploaded = $this->upload->data();
                        $data['img_path'] = $save_path . $uploaded['file_name'];
                        
                        $this->tp->img_path = $data['img_path'];
                        
                        if (isset($cd['id'])) {
                            $p = $cd['img_path'];
                            
                            if (file_exists(FCPATH . UPLOAD_PATH . $p)) {
                                
                                unlink(FCPATH . UPLOAD_PATH . $p);
                            }
                            // 如果存在改图片，修改，将原图删除
                            $res = $this->tp->update($cd['id']);
                        } else {
                            // 否则则插入。
                            $res = $this->tp->create();
                        }
                        $data['img_path'] = IMAGE_URL . $data['img_path'];
                        echo json_encode($data);
                    } else {
                        echo json_encode('上传失败');
                    }
                } else {
                    if ($cd) {
                        $res = $this->tp->update($cd['id']);
                    } else {
                        
                        $res = $this->tp->create();
                    }
                    if ($res)
                        echo json_encode(true);
                }
            } catch (Exception $e) {
                log_message($e);
            }
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 更改店铺上中下标题
     */
    function edit_temp_title()
    {
        $temp_key = $this->input->post('temp_key');
        $desc = $this->input->post('desc');
        $tem_id = $this->input->post('tem');
        $cor_id = $this->session->userdata['corporation_id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($cor_id);
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $cd = $this->tp->load($cor_id, $temp_key, $tem_id);
            $this->tp->desc = $desc;
            $this->tp->temp_key = $temp_key;
            $this->tp->template_id = $tem_id;
            if ($cd) {
                $result = $this->tp->update($cd['id']);
            } else {
                $this->tp->corporation_id = $cor_id;
                $result = $this->tp->create();
            }
            
            echo json_encode($result);
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 显示店铺商品模板2
     */
    public function select_shop()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($cor_id);
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $cor_id;
            $data['product_fav'] = $this->product->hot_product();
            $data['product_sales'] = $this->product->sales_product();
            
            $data['seo_title'] = '模板预览';
            $data['list'] = $this->tp->select_shop($cor_id, '2');
            $data['menu_list'] = $this->section->shop_classify_list($cor_id, true, $app_id);
            
            // echo '<pre>';
            // var_Dump($data['menu_list']);
            // exit;
            $this->load->view('head');
            $this->load->view('corporation_template/store_templateLess', $data);
            $this->load->view('_footer');
            $this->load->view('foot');
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 显示店铺模板3
     */
    public function select_three_shop()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($cor_id);
        $data['corporate'] = $corporate;
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $cor_id;
            $data['product_fav'] = $this->product->hot_product();
            $data['product_sales'] = $this->product->sales_product();
            
            $data['list'] = $this->tp->select_shop($cor_id, '3');
            $data['menu_list'] = $this->section->shop_classify_list($cor_id, true, $app_id);
            // echo'<pre>';
            // var_Dump($data['list']);
            $this->load->view('head');
            $this->load->view('corporation_template/store_templateMore', $data);
            $this->load->view('_footer');
            $this->load->view('foot');
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 发布模板2
     */
    public function issue_tem_two()
    {
        $corporation_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($corporation_id);
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $corporation_id;
            $product_fav = $this->product->hot_product();
            $product_sales = $this->product->sales_product();
            
            $menu_list = $this->section->shop_classify_list($corporation_id, true, $app_id);
            $data = $this->tp->select_shop($corporation_id, '2');
            
            /**
             * 排行榜-收藏量
             * site_url('goods/detail/'.$v['id'])
             * if(!empty($v['img_goods'] ) ) $v['img_goods']; else 'images/rankingList_pic1.png'
             */
            $fav_list = '';
            if (count($product_fav) > 0) {
                $fav_list .= "<ul>";
                foreach ($product_fav as $v) {
                    // echo $v['goods_img'];exit;
                    if (! empty($v['goods_img'])) {
                        $img = $v['goods_img'];
                    } else {
                        $img = 'images/rankingList_pic01.png';
                    }
                    $fav_list .= "<li>
                        	<a href='" . site_url('goods/detail/' . $v['id']) . "' class='rankingList_img'><img src='" . IMAGE_URL . $img . "' width='60' height='60' alt=''/></a>
                            <span class='rankingList_title'><a href='" . site_url('goods/detail/' . $v['id']) . "'>" . $v['name'] . "</a></span><br>
                            <span class='rankingList_price'><a href='" . site_url('goods/detail/' . $v['id']) . "'>M " . $v['vip_price'] . "</a></span><br>
                            <span class='rankingList_number'>已售出<i> " . $v['sales_count'] . " </i>笔</span>
                        </li>";
                }
                $fav_list .= "</ul>";
            }
            /**
             * 排行榜-销售量
             */
            $sales_list = '';
            if (count($product_sales) > 0) {
                $sales_list .= "<ul>";
                foreach ($product_sales as $v) {
                    // echo $v['goods_img'];exit;
                    if (! empty($v['goods_img'])) {
                        $img_1 = $v['goods_img'];
                    } else {
                        $img_1 = 'images/rankingList_pic01.png';
                    }
                    $sales_list .= "<li>
                        	<a href='" . site_url('goods/detail/' . $v['id']) . "' class='rankingList_img'><img src='" . IMAGE_URL . $img_1 . "' width='60' height='60' alt=''/></a>
                            <span class='rankingList_title'><a href='" . site_url('goods/detail/' . $v['id']) . "'>" . $v['name'] . "</a></span><br>
                            <span class='rankingList_price'><a href='" . site_url('goods/detail/' . $v['id']) . "'>M " . $v['vip_price'] . "</a></span><br>
                            <span class='rankingList_number'>已售出<i> " . $v['sales_count'] . " </i>笔</span>
                        </li>";
                }
                $sales_list .= "</ul>";
            }
            
            /**
             * 全部分类
             */
            $menu_all = '';
            if (isset($menu_list) && count($menu_list) > 0) {
                foreach ($menu_list as $v) {
                    $menu_all .= '<li class="macth_xvitem" data-bind="attr:{data-submenu-id:$data.id}" data-submenu-id="speedMenu517">';
                    $menu_all .= '<h3>
                                       <span></span><span class="macth_xvh3_a"><a href="' . site_url('goods/shop_class/' . $v['id']) . '/' . $corporation_id . '/2' . '" data-bind="text:$data.title" class="">' . $v['section_name'] . '</a></span><s style="display: block;"></s>
                                   </h3></li>';
                }
            }
            
            /**
             * 导航栏
             */
            $railing_title = '';
            if (isset($data['railing-title'])) {
                $railing_title .= '<li class="macth_liactive"><a href="' . site_url('home/GoToShop/' . $corporation_id) . '">首页</a></li>';
                foreach ($data['railing-title'] as $v) {
                    $railing_title .= "<li><a href='" . site_url('goods/shop_class/' . $v['link_path']) . '/' . $corporation_id . '/2' . "'>" . $v['desc'] . "</a></li>";
                }
            }
            
            /**
             * 头部
             */
            $top = '';
            if (isset($data['top']) && count($data['top']) > 0) {
                
                $top = "<div class='store_top storeLess_top' style='background:#fff;margin:0;'>
            	           <div class='store_top_con'><img src=" . IMAGE_URL . $data['top'][0]['img_path'] . " width='1920' height='100' alt=''/></div>
        	           </div>";
            }
            /**
             * 轮播图
             */
            $lunbo = '';
            if (isset($data['carousel-img'])) {
                $lunbo .= "<div class='bd'>";
                $lunbo .= "<ul class='imageslist'>";
                foreach ($data['carousel-img'] as $v) {
                    $lunbo .= "<li><a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "'/></a></li>";
                }
                $lunbo .= '</ul>';
                $lunbo .= '</div>';
            } else {
                $lunbo = '';
                $lunbo .= "<div class='bd'>";
                $lunbo .= "<ul class='imageslist'>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                </ul>";
                $lunbo .= '</div>';
            }
            
            /**
             * 轮播图的灯
             */
            $deng = '';
            if (isset($data['carousel-img'])) {
                $deng .= "<div class='num'>";
                for ($i = 0; $i < count($data['carousel-img']); $i ++) {
                    $class = '';
                    if ($i == 0) {
                        $class = "class='cur';";
                    }
                    $deng .= "<span $class></span>";
                }
                
                $deng .= "</div>";
            } else {
                $deng = '';
                $deng = "<div class='num'>
                            <span class='cur'></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>";
            }
            /**
             * 第一个标题
             */
            $top_title = isset($data['t'][0]['desc']) ? $data['t'][0]['desc'] : '';
            
            /**
             * 左边第一个边框
             */
            $tejiatop = '';
            if (isset($data['tejiatop']) && count($data['tejiatop'] > 0)) {
                
                foreach ($data['tejiatop'] as $v) {
                    $tejiatop = " <div class='specialCommodity_left'>
                            	<ul>
                                	<li>
                                    	<a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' alt=''/></a>
                                        <p class='specialCommodity_title'><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></p>
                                        <span class='specialCommodity_price'>" . $v['vip_price'] . "</span>
                                    </li>
    
                                </ul>
                            </div>";
                }
            }
            /**
             * 右边四个
             */
            $tejia = '';
            if (isset($data['tejia']) && count($data['tejia'] > 0)) {
                $tejia .= '<div class="specialCommodity_right">';
                $tejia .= '<ul>';
                foreach ($data['tejia'] as $v) {
                    $tejia .= "<li>
                                   <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' alt=''/></a>
                                   <p class='specialCommodity_title'><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></p>
                                   <span class='specialCommodity_price'>M " . $v['vip_price'] . "</span>
                               </li>";
                }
                $tejia .= '</ul>';
                $tejia .= '</div>';
            }
            
            /**
             * 搜索栏
             */
            $search = '';
            if (isset($data['search'])) {
                $search = '<div class="store_storesearch">
                    	<span>本店搜索：</span>
                        <div class="storesearch_input01_bg">
                        	<input class="storesearch_input01" type="text" placeholder="输入关键字">
                        </div>
                        <div class="storesearch_input02_bg">
                        	<input class="storesearch_input02" type="text" placeholder="¥">
                        </div>
                        <span class="storesearch_span">—</span>
                        <div class="storesearch_input02_bg">
                        	<input class="storesearch_input02" type="text" placeholder="¥">
                        </div>
                        <div class="storesearch_btn"><a href="">搜索</a></div>
                    </div>';
            }
            /**
             * 第二个标题
             */
            $two_title = isset($data['m'][0]['desc']) ? $data['m'][0]['desc'] : '';
            
            /**
             * 中间整块有上下滑动的
             */
            $mid_body = '';
            if (isset($data['tuijian']) && count($data['tuijian']) > 0) {
                /**
                 * 左边3个
                 */
                $mid_body .= "<div class='rankingTop_left'>";
                $mid_body .= '<ul>';
                
                for ($i = 0; $i < 3; $i ++) {
                    $url = isset($data['tuijian'][$i]['link_path']) ? $data['tuijian'][$i]['link_path'] : 'javascript:';
                    $img = isset($data['tuijian'][$i]['img_path']) ? $data['tuijian'][$i]['img_path'] : 'images/RankingTop_x01.png';
                    $mid_body .= "<li><a href='" . $url . "' order='" . $i . "'><img width=278; height=228; src='" . IMAGE_URL . $img . "' alt=''/></a></li>";
                }
                $mid_body .= '</ul>';
                $mid_body .= '</div>';
                
                /**
                 * 中间轮播
                 */
                $mid_body .= "<div class='rankingTop_mid'>";
                $mid_body .= "<ul>";
                
                foreach ($data['tuijian'] as $v) {
                    $mid_body .= "<li>
                                    <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' alt=''/></a>
                                    <p class='rankingTop_title'><a href=''>" . $v['desc'] . "</a></p>
                                    <div class='rankingTop_btn'>
                                        <div class='rankingTop_priceBtn'><a href='" . $v['link_path'] . "'>M " . $v['vip_price'] . "</a></div>
                                        <div class='rankingTop_buyBtn'><a href='" . $v['link_path'] . "'>立即购买</a></div>
                                    </div>
                                 </li>";
                }
                $mid_body .= "</ul>";
                $mid_body .= "</div>";
                
                /**
                 * 右边三个
                 */
                $mid_body .= '<div class="rankingTop_right">';
                $mid_body .= '<ul>';
                for ($i = 3; $i < 6; $i ++) {
                    $url_2 = isset($data['tuijian'][$i]['link_path']) ? $data['tuijian'][$i]['link_path'] : 'javascript:';
                    $img_2 = isset($data['tuijian'][$i]['img_path']) ? $data['tuijian'][$i]['img_path'] : 'images/RankingTop_x01.png';
                    $mid_body .= "<li><a href='" . $url_2 . "' order='" . $i . "'><img width=278; height=228; src='" . IMAGE_URL . $img_2 . "' alt=''/></a></li>";
                }
                $mid_body .= '</ul>';
                $mid_body .= '</div>';
            }
            /**
             * 中间横幅图片
             */
            $mid = '';
            if (isset($data['mid']) && count($data['mid']) > 0) {
                $mid = "<div class='store_midBanner storeLess_midBanner'>
                	<div class='store_midBanner_con'><a href='" . $data['mid'][0]['link_path'] . "'><img src='" . IMAGE_URL . $data['mid'][0]['img_path'] . "' width='1920' height='190' alt=''/></a></div>
              	</div>";
            }
            
            /**
             * 左边推荐栏
             */
            $left = '';
            if (isset($data['left']) && count($data['left'] > 0)) {
                $left .= '<div class="recommend_con">';
                $left .= '<ul>';
                foreach ($data['left'] as $v) {
                    $left .= "<li>
                                      <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='200' height='172' alt=''/></a>
                                      <span class='rankingList_title'><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></span><br>
                                      <span class='rankingList_price'><a href='" . $v['link_path'] . "'>M " . $v['vip_price'] . "</a></span>
                                    </li>";
                }
                
                $left .= '</ul>';
                
                $left .= '</div>';
            }
            
            /**
             * 第三个标题
             */
            $three_title = isset($list['e'][0]['desc']) ? $list['e'][0]['desc'] : '';
            
            /**
             * 最后面12个
             */
            $hotsell = '';
            if (isset($data['hotsell']) && count($data['hotsell'] > 0)) {
                $hotsell .= '<ul>';
                foreach ($data['hotsell'] as $k => $v) {
                    $class_1 = '';
                    if ($k == 2 || $k == 5 || $k == 8 || $k == 11) {
                        $class_1 = "style = 'margin-right:0'; ";
                    }
                    $hotsell .= "<li $class_1>
                    		<a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='304' height='304' alt=''/></a>
                            <span class='hotSale_title'><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></span><br>
                            <span class='hotSale_price'><a href='" . $v['link_path'] . "'>M " . $v['vip_price'] . "</a></span>
                        </li>";
                }
                $hotsell .= '</ul>';
            }
            
            $end = '';
            if (isset($data['end']) && count($data['end']) > 0) {
                $end .= "<div class='store_endBanner'>
                	<div class='store_endBanner_con'><a href='" . $data['end'][0]['link_path'] . "'><img src='" . IMAGE_URL . $data['end'][0]['img_path'] . "' width='1920' height='250' alt=''/></a></div>
                </div>";
            }
            
            $text = file_get_contents(SUITEPATH . SUITE . "/views/default/corporation_template/store_templateLess.txt");
            $save_path = FCPATH . UPLOAD_PATH . './uploads/corporation_template/C_' . $corporation_id . '';
            
            if (! file_exists($save_path)) {
                mkdir($save_path, 0777, true);
            }
            $html = str_replace('<#top#>', $top, $text);
            $html = str_replace('<#lunbo#>', $lunbo, $html);
            $html = str_replace('<#deng#>', $deng, $html);
            $html = str_replace('<#top_title#>', $top_title, $html);
            $html = str_replace('<#tejiatop#>', $tejiatop, $html);
            $html = str_replace('<#tejia#>', $tejia, $html);
            $html = str_replace('<#search#>', $search, $html);
            $html = str_replace('<#two_title#>', $two_title, $html);
            $html = str_replace('<#mid_body#>', $mid_body, $html);
            $html = str_replace('<#mid#>', $mid, $html);
            $html = str_replace('<#left#>', $left, $html);
            $html = str_replace('<#three_title#>', $three_title, $html);
            $html = str_replace('<#hotsell#>', $hotsell, $html);
            $html = str_replace('<#end#>', $end, $html);
            $html = str_replace('<#menu_all#>', $menu_all, $html);
            $html = str_replace('<#railing_title#>', $railing_title, $html);
            $html = str_replace('<#product_fav#>', $fav_list, $html);
            $html = str_replace('<#product_sales#>', $sales_list, $html);
            $html = file_put_contents($save_path . '/index.php', $html);
            
            $this->load->model('customer_corporation_mdl');
            $this->customer_corporation_mdl->updateTemplate($corporation_id, '2', $save_path);
            if ($html) {
                echo 'ok';
            }
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 发布模板三
     */
    public function issue_tem_three()
    {
        $corporation_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($corporation_id);
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $corporation_id;
            $product_fav = $this->product->hot_product();
            $product_sales = $this->product->sales_product();
            $menu_list = $this->section->shop_classify_list($corporation_id, true, $app_id);
            $data = $this->tp->select_shop($corporation_id, '3');
            // echo '<pre>';
            // var_dump($menu_list);exit;
            /**
             * 排行榜-收藏量
             * site_url('goods/detail/'.$v['id'])
             * if(!empty($v['img_goods'] ) ) $v['img_goods']; else 'images/rankingList_pic1.png'
             */
            $fav_list = '';
            if (count($product_fav) > 0) {
                $fav_list .= "<ul>";
                foreach ($product_fav as $v) {
                    
                    if (! empty($v['goods_img'])) {
                        $img = $v['goods_img'];
                    } else {
                        $img = 'images/rankingList_pic01.png';
                    }
                    $fav_list .= "<li>
                        	<a href='" . site_url('goods/detail/' . $v['id']) . "' class='rankingList_img'><img src='" . IMAGE_URL . $img . "' width='60' height='60' alt=''/></a>
                            <span class='rankingList_title'><a href='" . site_url('goods/detail/' . $v['id']) . "'>" . $v['name'] . "</a></span><br>
                            <span class='rankingList_price'><a href='" . site_url('goods/detail/' . $v['id']) . "'>M " . $v['vip_price'] . "</a></span><br>
                            <span class='rankingList_number'>已售出<i> " . $v['sales_count'] . " </i>笔</span>
                        </li>";
                }
                $fav_list .= "</ul>";
            }
            /**
             * 排行榜-销售量
             */
            $sales_list = '';
            if (count($product_sales) > 0) {
                $sales_list .= "<ul>";
                foreach ($product_sales as $v) {
                    
                    if (! empty($v['goods_img'])) {
                        $img_1 = $v['goods_img'];
                    } else {
                        $img_1 = 'images/rankingList_pic01.png';
                    }
                    $sales_list .= "<li>
                        	<a href='" . site_url('goods/detail/' . $v['id']) . "' class='rankingList_img'><img src='" . IMAGE_URL . $img_1 . "' width='60' height='60' alt=''/></a>
                            <span class='rankingList_title'><a href='" . site_url('goods/detail/' . $v['id']) . "'>" . $v['name'] . "</a></span><br>
                            <span class='rankingList_price'><a href='" . site_url('goods/detail/' . $v['id']) . "'>M " . $v['vip_price'] . "</a></span><br>
                            <span class='rankingList_number'>已售出<i> " . $v['sales_count'] . " </i>笔</span>
                        </li>";
                }
                $sales_list .= "</ul>";
            }
            
            /**
             * 导航栏
             */
            $railing_title = '';
            if (isset($data['railing-title'])) {
                $railing_title .= '<li class="macth_liactive"><a href="' . site_url('home/GoToShop/' . $corporation_id) . '">首页</a></li>';
                foreach ($data['railing-title'] as $v) {
                    $railing_title .= "<li><a href='" . site_url('goods/shop_class/' . $v['link_path']) . '/' . $corporation_id . '/3' . "'>" . $v['desc'] . "</a></li>";
                }
            }
            
            /**
             * 全部分类
             */
            $menu_all = '';
            if (isset($menu_list) && count($menu_list) > 0) {
                foreach ($menu_list as $v) {
                    $menu_all .= '<li class="macth_xvitem" data-bind="attr:{data-submenu-id:$data.id}" data-submenu-id="speedMenu517">';
                    $menu_all .= '  <h3>
                                       <span></span><span class="macth_xvh3_a"><a href="' . site_url('goods/shop_class/' . $v['id']) . '/' . $corporation_id . '/3' . '" data-bind="text:$data.title" class="">' . $v['section_name'] . '</a></span><s style="display: block;"></s>
                                    </h3>
                                  </li>';
                }
            }
            
            /**
             * 头部
             */
            $top = '';
            if (isset($data['top']) && count($data['top']) > 0) {
                
                $top = "<div class='store_top storeLess_top' style='background:#fff;margin:0;'>
            	           <div class='store_top_con'><img src=" . IMAGE_URL . $data['top'][0]['img_path'] . " width='1920' height='100' alt=''/></div>
        	           </div>";
            }
            
            /**
             * 轮播图
             */
            $lunbo = '';
            if (isset($data['carousel-img'])) {
                $lunbo .= "<div class='bd'>";
                $lunbo .= "<ul class='imageslist'>";
                foreach ($data['carousel-img'] as $v) {
                    $lunbo .= "<li><a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "'/></a></li>";
                }
                $lunbo .= '</ul>';
                $lunbo .= '</div>';
            } else {
                $lunbo = '';
                $lunbo .= "<div class='bd'>";
                $lunbo .= "<ul class='imageslist'>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                    <li><a href='#'><img src='images/store_banner.png' /></a></li>
                </ul>";
                $lunbo .= "</div>";
            }
            
            /**
             * 轮播图的灯
             */
            $deng = '';
            if (isset($data['carousel-img'])) {
                $deng .= "<div class='num'>";
                for ($i = 0; $i < count($data['carousel-img']); $i ++) {
                    $class = '';
                    if ($i == 0) {
                        $class = "class='cur';";
                    }
                    $deng .= "<span $class></span>";
                }
                
                $deng .= "</div>";
            } else {
                $deng = '';
                $deng = "<div class='num'>
                            <span class='cur'></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>";
            }
            
            /**
             * 第一个标题
             */
            $top_title = isset($data['one'][0]['desc']) ? $data['one'][0]['desc'] : '';
            
            /**
             * 一。左边2个
             */
            $one_left_menu = '';
            if (isset($data['one-left-menu']) && count($data['one-left-menu'] > 0)) {
                $one_left_menu .= "<div class='hotzone_left'>
                    <ul>";
                foreach ($data['one-left-menu'] as $v) {
                    $one_left_menu .= "<li><a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='328' height='478' alt=''/></a></li>";
                }
                $one_left_menu .= "</ul>
                    </div>";
            }
            
            /**
             * 一。右边2个
             */
            $one_right_menu = '';
            if (isset($data['one-right-menu']) && count($data['one-right-menu'] > 0)) {
                $one_right_menu .= "<div class='hotzone_right'>
                    <ul>";
                foreach ($data['one-right-menu'] as $v) {
                    $one_right_menu .= "<li><a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='516' height='232' alt=''/></a></li>";
                }
                $one_right_menu .= "</ul>
                    </div>";
            }
            
            /**
             * 第二个标题
             */
            $two_title = isset($data['two'][0]['desc']) ? $data['two'][0]['desc'] : '';
            
            /**
             * 第二排菜单栏
             */
            $two_menu = '';
            if (isset($data['two-menu']) && count($data['two-menu'] > 0)) {
                $two_menu .= "<ul>";
                foreach ($data['two-menu'] as $k => $v) {
                    $class = '';
                    if ($k == 3 || $k == 7) {
                        $class = "style = 'margin-right:0'; ";
                    }
                    $two_menu .= "<li $class>
                        	<a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='283' height='283' alt=''/></a>
                          <p><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></p>
                      	  <span>M " . $v['vip_price'] . "</span>
                        </li>";
                }
                $two_menu .= "</ul>";
            }
            
            /**
             * 中间的横幅图
             */
            $mid = '';
            if (isset($data['mid']) && count($data['mid']) > 0) {
                $mid .= "<div class='store_midBanner'>
                	<div class='store_midBanner_con'><a href='" . $data['mid'][0]['link_path'] . "'><img src='" . IMAGE_URL . $data['mid'][0]['img_path'] . "' width='1920' height='190' alt=''/></a></div>
              	</div>";
            }
            
            /**
             * 搜索栏
             */
            $search = '';
            if (isset($data['search'])) {
                $search = '<div class="store_storesearch">
                    	<span>本店搜索：</span>
                        <div class="storesearch_input01_bg">
                        	<input class="storesearch_input01" type="text" placeholder="输入关键字">
                        </div>
                        <div class="storesearch_input02_bg">
                        	<input class="storesearch_input02" type="text" placeholder="¥">
                        </div>
                        <span class="storesearch_span">—</span>
                        <div class="storesearch_input02_bg">
                        	<input class="storesearch_input02" type="text" placeholder="¥">
                        </div>
                        <div class="storesearch_btn"><a href="">搜索</a></div>
                    </div>';
            }
            
            /**
             * 左边推荐
             */
            $left_menu = '';
            if (isset($data['left-menu']) && count($data['left-menu'] > 0)) {
                $left_menu .= '<ul>';
                foreach ($data['left-menu'] as $v) {
                    $left_menu .= "<li>
                            <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='200' height='172' alt=''/></a>
                            <span class='rankingList_title'><a href='" . $v['link_path'] . "'>" . $v['desc'] . "</a></span><br>
                            <span class='rankingList_price'><a href='" . $v['link_path'] . "'>M " . $v['vip_price'] . "</a></span>
                        </li>";
                }
                $left_menu .= '</ul>';
            }
            
            /**
             * 第三个标题
             */
            $three_title = isset($data['three'][0]['desc']) ? $data['three'][0]['desc'] : '';
            
            /**
             * 第三排菜单栏
             */
            $three_menu = '';
            if (isset($data['three-menu']) && count($data['three-menu'] > 0)) {
                foreach ($data['three-menu'] as $k => $v) {
                    $class_1 = '';
                    if ($k == 2 || $k == 5) {
                        $class_1 = "style = 'margin-right:0'; ";
                    }
                    $three_menu .= "<li $class_1>
                    	<a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='304' height='304' alt=''/></a>
                        <span class='hotSale_title'><a href=''>" . $v['desc'] . "</a></span><br>
                        <span class='hotSale_price'><a href=''>M " . $v['vip_price'] . "</a></span>
                    </li>";
                }
            }
            
            /**
             * 第四个标题
             */
            $four_title = isset($data['four'][0]['desc']) ? $data['four'][0]['desc'] : '';
            
            /**
             * 第四排菜单
             */
            $four_menu = '';
            if (isset($data['four-menu']) && count($data['four-menu'] > 0)) {
                $four_menu .= "<ul>";
                foreach ($data['four-menu'] as $k => $v) {
                    $class_2 = '';
                    if ($k == 2 || $k == 5) {
                        $class_2 = "style = 'margin-right:0'; ";
                    }
                    $four_menu .= "<li $class_2>
                                <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='304' height='304' alt=''/></a>
                                <span class='hotSale_title'><a href=''>" . $v['desc'] . "</a></span><br>
                                <span class='hotSale_price'><a href=''>M " . $v['vip_price'] . "</a></span>
                            </li>";
                }
                $four_menu .= "</ul>";
            }
            
            /**
             * 第五个标题
             */
            $five_title = isset($data['five'][0]['desc']) ? $data['five'][0]['desc'] : '';
            
            /**
             * 第五排菜单
             */
            $five_menu = '';
            if (isset($data['five-menu']) && count($data['five-menu'] > 0)) {
                $five_menu .= "<ul>";
                foreach ($data['five-menu'] as $k => $v) {
                    $class_3 = '';
                    if ($k == 2 || $k == 5) {
                        $class_3 = "style = 'margin-right:0'; ";
                    }
                    $five_menu .= "<li $class_3 >
                    <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='304' height='304' alt=''/></a>
                                <span class='hotSale_title'><a href=''>" . $v['desc'] . "</a></span><br>
                                <span class='hotSale_price'><a href=''>M " . $v['vip_price'] . "</a></span>
                            </li>";
                }
                $five_menu .= "</ul>";
            }
            
            /**
             * 第六个标题
             */
            $six_title = isset($data['six'][0]['desc']) ? $data['six'][0]['desc'] : '';
            
            /**
             * 第六排菜单
             */
            $six_menu = '';
            if (isset($data['six-menu']) && count($data['six-menu'] > 0)) {
                $six_menu .= "<ul>";
                foreach ($data['six-menu'] as $k => $v) {
                    $class_4 = '';
                    if ($k == 2 || $k == 5) {
                        $class_4 = "style = 'margin-right:0'; ";
                    }
                    $six_menu .= "<li $class_4 >
                    <a href='" . $v['link_path'] . "'><img src='" . IMAGE_URL . $v['img_path'] . "' width='304' height='304' alt=''/></a>
                                <span class='hotSale_title'><a href=''>" . $v['desc'] . "</a></span><br>
                                <span class='hotSale_price'><a href=''>M " . $v['vip_price'] . "</a></span>
                            </li>";
                }
                $six_menu .= "</ul>";
            }
            
            /**
             * 第三个横幅图
             */
            $end = '';
            if (isset($data['end']) && count($data['end']) > 0) {
                $end .= "<div class='store_endBanner'>
                    	<div class='store_endBanner_con'><a href='" . $data['end'][0]['link_path'] . "'><img src='" . IMAGE_URL . $data['end'][0]['img_path'] . "' width='1920' height='190' alt=''/></a></div>
                    </div>";
            }
            
            $text = file_get_contents(SUITEPATH . SUITE . "/views/default/corporation_template/store_templateMore.txt");
            $save_path = FCPATH . UPLOAD_PATH . './uploads/corporation_template/C_' . $corporation_id . '';
            
            if (! file_exists($save_path)) {
                mkdir($save_path, 0777, true);
            }
            $html = str_replace('<#top#>', $top, $text);
            $html = str_replace('<#lunbo#>', $lunbo, $html);
            $html = str_replace('<#deng#>', $deng, $html);
            $html = str_replace('<#top_title#>', $top_title, $html);
            $html = str_replace('<#one_left_menu#>', $one_left_menu, $html);
            $html = str_replace('<#one_right_menu#>', $one_right_menu, $html);
            $html = str_replace('<#two_title#>', $two_title, $html);
            $html = str_replace('<#two_menu#>', $two_menu, $html);
            $html = str_replace('<#mid#>', $mid, $html);
            $html = str_replace('<#search#>', $search, $html);
            $html = str_replace('<#left_menu#>', $left_menu, $html);
            $html = str_replace('<#three_title#>', $three_title, $html);
            $html = str_replace('<#three_menu#>', $three_menu, $html);
            $html = str_replace('<#four_title#>', $four_title, $html);
            $html = str_replace('<#four_menu#>', $four_menu, $html);
            $html = str_replace('<#five_title#>', $five_title, $html);
            $html = str_replace('<#five_menu#>', $five_menu, $html);
            $html = str_replace('<#six_title#>', $six_title, $html);
            $html = str_replace('<#end#>', $end, $html);
            $html = str_replace('<#menu_all#>', $menu_all, $html);
            $html = str_replace('<#railing_title#>', $railing_title, $html);
            $html = str_replace('<#product_fav#>', $fav_list, $html);
            $html = str_replace('<#product_sales#>', $sales_list, $html);
            $html = file_put_contents($save_path . '/index.php', $html);
            $this->load->model('customer_corporation_mdl');
            $this->customer_corporation_mdl->updateTemplate($corporation_id, '3', $save_path);
            if ($html) {
                echo 'ok';
            }
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 隐藏或者显示栏目
     */
    public function hidden_menu()
    {
        $temp_key = $this->input->post('key');
        $status = $this->input->post('status');
        $tem_id = $this->input->post('tem');
        $id = $this->input->post('id');
        $cor_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('template_mdl', 'tp');
        if ($status == 'show') {
            $this->tp->temp_key = $temp_key;
            $this->tp->template_id = $tem_id;
            $this->tp->corporation_id = $cor_id;
            $result = $this->tp->create();
            if ($result)
                $data = array(
                    '0' => $status,
                    '1' => $result
                );
            
            echo json_encode($data);
        } elseif ($status == 'hide') {
            $result = $this->tp->delete($id, $temp_key, $cor_id, $tem_id);
            if ($result)
                $data = array(
                    '0' => $status
                );
            echo json_encode($data);
        }
    }

    /**
     * 模板三编辑
     */
    public function select_three_temp()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->load->model('corporation_mdl', 'cp');
        $corporate = $this->cp->load_id($cor_id);
        $data['corporate'] = $corporate;
        if ($corporate != null && isset($corporate['grade']) && $corporate['grade'] > 1) {
            $this->load->model('template_mdl', 'tp');
            $this->load->model('section_mdl', 'section');
            $this->load->model('product_mdl', 'product');
            $this->product->corporation_id = $cor_id;
            $data['product_fav'] = $this->product->hot_product();
            $data['product_sales'] = $this->product->sales_product();
            
            $data['menu_list'] = $this->section->shop_classify_list($cor_id, true, $app_id);
            $data['list'] = $this->tp->select_goods_temp($cor_id, '3');
            
            $this->load->view('corporate/shop/view/store_templateMore', $data);
        } else {
            $data['message'] = '无权访问';
            $data['url'] = site_url('corporate/myshop/renovate');
            
            $this->load->view("redirect_view", $data);
            return;
        }
    }

    /**
     * 添加菜单
     */
    public function add_menu_list()
    {
        $cor_id = $this->session->userdata['corporation_id'];
        $post = $this->input->post();
        $tem_id = $this->input->post('tem');
        
        $this->load->model('template_mdl', 'tp');
        $arr = array();
        foreach ($post['array'] as $k => $v) {
            $list = explode(';', $v);
            
            $arr['id'] = $list[0];
            $arr['key'] = $list[1];
            $arr['desc'] = $list[2];
            $this->tp->link_path = $arr['id'];
            $this->tp->temp_key = $arr['key'];
            $this->tp->corporation_id = $cor_id;
            $this->tp->desc = $arr['desc'];
            $this->tp->template_id = $tem_id;
            $cd = $this->tp->load($cor_id, $arr['key'], $tem_id);
            if (isset($cd['temp_key']) == $arr['key']) {
                $res = $this->tp->update($cd['id']);
            } else {
                $res = $this->tp->create();
            }
        }
        echo $res;
    }
}