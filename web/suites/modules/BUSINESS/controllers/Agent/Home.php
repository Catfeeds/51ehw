<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Home extends Front_Controller {
	
	/**
	 */
	public function __construct() {
		parent::__construct ();
		
	}
	
	// --------------------------------------------------------------

    /**
     * 合伙人登陆
     */
	public function login(){
	    $err_msg = $this->input->get_post("err_msg");
	    if( $this->session->userdata('agent_in') )  {
	        redirect('Agent/home/agent_rebate');
	    }
	    
	    $data['head_set'] = 3;
	    $data['foot_set'] = 1;
	    $data ['back'] = 'member/info';
	    $data['title'] = '51易货合伙人';
	    if ($err_msg != 0) {
	        switch ($err_msg) {
	            default:
	                $data['err_msg'] = "用户名密码错误";
	        }
	    } else {
	        $data['err_msg'] = "";
	    }
	    
	    $url = site_url('Agent/home/login');
	    $url2 = site_url('agent/agent/login?err_msg=1');
	    if( isset($_SERVER["HTTP_REFERER"]) && $url != $_SERVER["HTTP_REFERER"]&& $url2 != $_SERVER["HTTP_REFERER"]){
	        $this->session->set_userdata('redir',$_SERVER["HTTP_REFERER"]);
	    }
      
	    $this->load->view('agent/head', $data);
	    $this->load->view('agent/header', $data);
	    $this->load->view('agent/login', $data);
	}

	/**
	 * 检验合伙人登陆
	 */
	public function check_agent(){
	    
	    $agentname = $this->input->get_post("agentname");
	    $password = $this->input->get_post("password");
	    
	    $this->load->model("agent_mdl");
	    $this->agent_mdl->agent_name = $agentname;
	    $this->agent_mdl->password = $password;
	    $_agent = $this->agent_mdl->check_agent();
	    
	    if($_agent!=null){
	        $agent = array(
	            "agent_id" => $_agent["id"],
	            "agent_name" => $_agent["agent_name"],
	            "email" => $_agent["email"],
	            "corp_name" => $_agent["corp_name"],
	            "nick_name" => $_agent["nick_name"],
	            "agent_in" => true
	        );
	        
	        $this->session->set_userdata($agent);
	        
	        $redirect = $this->session->userdata('redir');
	        
	        /*if ($redirect !== NULL) {
	            $this->session->unset_userdata('redir');
	            redirect($redirect);
	        }*/
	        redirect('Agent/home/agent_rebate');
	    }else{
	        redirect("Agent/home/login?err_msg=1");
	    }
	    
	}
	
	/**
	 * 合伙人分成汇总
	 */
	public function agent_rebate($type="",$start="",$end=""){
	    
	    if(!$this->session->userdata("agent_in")){
	        redirect("Agent/home/login");
	    }
	    
	    $desc = $this->input->get_post("theme");
	    $agent_id = $this->session->userdata("agent_id");
	    $condition["start_time"] = $this->input->get("start_time");
	    $condition["end_time"] = $this->input->get("end_time")." 23:59:59";
	    if($type=="excel"){
    	    $condition["start_time"] = $start;
    	    $condition["end_time"] = $end;
	    }
	    if(!(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")))
	    {
	        $condition["type"] = $this->input->get("type");
	        
	        $data["type"] = $condition["type"];
    	    if($condition["start_time"]==null || $condition["start_time"]=="")
    	    {
    	        $condition["start_time"] = date("Y-m")."-01 00:00:00";
    	    }else{
    	        $condition["start_time"] .= " 00:00:00";
    	    }
    	    
    	    if($condition["end_time"]==null || $condition["start_time"]=="" ){
    	        $condition["end_time"] = date('Y-m-d')." 23:59:59";
    	    }else{
    	        $condition["end_time"] .= " 23:59:59";
    	    }
    	    $data["start_time"] = explode(" ",$condition["start_time"])[0];
    	    $data["end_time"] = explode(" ",$condition["end_time"])[0];
    	    $this->load->model("platform_rebate_mdl","pr");
    	    $data['list'] = $this->pr->getList($agent_id,$desc,$condition);
    	    
	    }else{
	        if($condition["start_time"]==null || $condition["start_time"]=="")
	        {
    	        $condition["start_time"] = date("Y-m")."-01 00:00:00";
	        }else{
	            $condition["start_time"] .= " 00:00:00";
	        }
	        if($condition["end_time"]==null || $condition["end_time"]=="" ){
    	        $condition["end_time"] = date('Y-m-d')." 23:59:59";
	        }else{
	            $condition["end_time"] .= " 23:59:59";
	        }
	        $condition["start"] = $this->input->get("start")!=""?$this->input->get("start")." 00:00:00":"";
	        $condition["end"] = $this->input->get("end")!=""?$this->input->get("end")." 23:59:59":"";
	        
	        $data["start"] = explode(" ",$condition["start"])[0];
	        $data["end"] = explode(" ",$condition["end"])[0];
	        
	        $this->load->model("platform_rebate_mdl","pr");
	        $this->load->model("corporation_mdl");
	        $data['list'] = $this->pr->getList($agent_id,$desc,$condition,null,8,0);
	        $data['count_rebate_month'] = $this->pr->getList($agent_id,$desc,$condition,null);
	        $data["mecorporate"] = $this->corporation_mdl->getagentcorporate($agent_id);
	        $data['count_rebate'] = $this->pr->countRebate($agent_id,$desc,$condition);
	    }
	    
	    $app = $this->session->userdata("app_info");
	    
	    $data["app"] = $app;
	    $data["desc"] = $desc;
	    
	    $data["title"] = $this->session->userdata("app_info")["app_name"].'--分成汇总';
	    if($type=="excel"){
	        return $data["list"];
	    }
	    $this->load->view("agent/head",$data);
	    $this->load->view("agent/header",$data);
	    $this->load->view("agent/summary",$data);
	}
	
	public function rebate_detail($type="",$start="",$end=""){
	    
	    if(!$this->session->userdata("agent_in")){
	        redirect("Agent/home/login");
	    }
	    
	    $desc = $this->input->get_post("theme");
	   
	    $agent_id = $this->session->userdata("agent_id");
	    
	    $condition["start_time"] = $this->input->get("start_time");
	    $condition["end_time"] = $this->input->get("end_time");
	    if($type=="excel"){
    	    $condition["start_time"] = $start;
    	    $condition["end_time"] = $end;
	    }
	    $condition["select"] = $this->input->get("select");
	    if($condition["select"]!=null&&$condition["select"]==1){
	       $condition["order_sn"] = $this->input->get("order_sn");
	       $data["order_sn"] = $condition["order_sn"];
	    }
	    if($condition["select"]!=null&&$condition["select"]==2){
	        $condition["corporation_name"] = $this->input->get("corporation_name");
	        $data["corporation_name"] = $condition["corporation_name"];
	    }

	    $data["select"] = $condition["select"];
	    if($condition["start_time"]==null)
	    {
	        $condition["start_time"] = date("Y-m")."-01 00:00:00";
	    }else{
	            $condition["start_time"] .= " 00:00:00";
	    }
	     
	    if($condition["end_time"] == null) {
            $condition["end_time"] = date('Y-m-d') . " 23:59:59";
        } else {
            $condition["end_time"] .= " 23:59:59";
        }
	    $data["start_time"] = explode(" ",$condition["start_time"])[0];
	    $data["end_time"] = explode(" ",$condition["end_time"])[0];
	    $this->load->model("platform_rebate_mdl","pr");
	    $data['list'] = $this->pr->getList($agent_id,$desc,$condition,true);
	    
	    $app = $this->session->userdata("app_info");
	    $data["app"] = $app;
	    $data["desc"] = $desc;
	    
	    $data["title"] = $this->session->userdata("app_info")["app_name"].'--分成明细';
	    if($type=="excel"){
	        return $data["list"];
	    }
	    
	    $this->load->view("agent/head",$data);
	    $this->load->view("agent/header",$data);
	    $this->load->view("agent/detailed",$data);
	}
	
	public function ajax_page(){
	    
	    if(!$this->session->userdata("agent_id")){
	        redirect("Agent/home/login");
	    }
	    
	    $desc = $this->input->get_post("theme");
	    $condition["start_time"] = $this->input->get("start_time");
	    $condition["end_time"] = $this->input->get("end_time");
	    $agent_id = $this->session->userdata("agent_id");
	    //$is_ajax = $this->input->get_post("is_ajax");
	    if($condition["end_time"]==null){
	        $condition["end_time"] = date('Y-m-d')." 23:59:59";
	    }
	    
	    $limit = 8;
	    $page = $this->input->get("page");
	    if(0==$page)
	    {
	       $page = 1;
	    }
	    $offset = ($page-1)*$limit;
	    
	    $this->load->model("platform_rebate_mdl","pr");
	    $data['list'] = $this->pr->getList($agent_id,null,$condition,false,/*$is_ajax,*/$limit,$offset);
	    $count_rebate_month = $this->pr->getList($agent_id,$desc,$condition,null);
	    $data['rebate_month'] = 0;
	    if(count($count_rebate_month)>0)
	    {
	        foreach ($count_rebate_month as $key => $l)
	        {
	            $data['rebate_month'] = $data['rebate_month'] + $l["rebate"];
	        }
	    }
	    $data['rebate_month'] = number_format($data['rebate_month'],2);
	    $data['limit'] = $limit;
	    $data['offset'] = $offset;
        $data['page'] = $page+1;
	    print_r(json_encode($data));
	    
	}
	
	public function excel( $start="", $end=""){
	    
	   $type = $this->input->get('type')!=null?$this->input->get('type'):"";
	   if(!$this->session->userdata("agent_id")){
	       $data["error"] = "非法操作";
	       print_r(json_encode($data));
	       exit();
	   }
	   $filename = "agentrebate_".date("YmdHis").".xls";
	   
	   if(isset($type)&&$type!="")
	   {
	      $content = $this->rebate_detail("excel",$start,$end);
	   }else
	   {
	      $content = $this->agent_rebate("excel",$start,$end);
	   }
	   $this->exportExcel($filename,$content,$type); 
	}


	/**
	 * 导出excel:2016/07/04
	 * @param unknown $filename
	 * @param unknown $content
	 * @param string $type
	 */
	public function exportExcel($filename,$content,$type=""){
	    $data['filename'] = $filename;
	    $data['content'] = $content;
	    $data['type'] = $type;
	    $this->load->view("agent/exportExcel",$data);
	}

	/**
	 * 退出登陆
	 */
	public function loginout(){
	    
	    $this->session->sess_destroy();
	    redirect("Agent/home/login");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */