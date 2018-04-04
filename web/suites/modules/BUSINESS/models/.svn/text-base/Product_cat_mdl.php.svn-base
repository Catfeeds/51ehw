<?php
/**
 * 商品分类
 *
 *
 */
class Product_cat_mdl extends CI_Model {

	function __construct() {
		parent::__construct ();
	}
	
	/*
	 * load by parent_id
	 * */
	public function load_name( $cat_name = array()){
	    $query = $this->db->from ('product_cat')->where_in('name',$cat_name)->get();
	    $row = $query->result_array();
	    return $row;
	}
	
	/*
	 * 首页获取楼层
	 * */
	public function loadFromJson(){
	    
	    //首页显示类目
	    $filename = base_url("data/category.json");
	    $json_str = file_get_contents($filename);
	    $json_str = str_replace(' ','',$json_str);
	    $json_str = str_replace('\n','',$json_str);
	    $_json = json_decode($json_str,true);
// 	    $hotel_id = $_json["navData"][2]['id'];
// 	    $painting_id = $_json["navData"][6]['id'];
// 	    $ad_id = $_json["navData"][7]['id'];
	    $name = array("酒店住宿","广告","书画");
	    $img = array("images/home_hotel.png","images/home_painting.png","images/home_ad.png");
// 	    $list = array($hotel_id,$ad_id,$painting_id);
	    $id = array(3931,22,100000);
	    for($i=0;$i<3;$i++){
	        $return[$i]["id"] = $id[$i];
	        $return[$i]["name"] = $name[$i];
	        $return[$i]["cate_img"] = $img[$i];
	    }
	    
	    return $return;
	}
	
	/*
	 * 分类页
	 * */
	public function getSectionList($type = '')
	{	
	    if(!$type){
		$filename = base_url("data/".SUITE."/category_app.json");
	    $json_str = file_get_contents($filename);
	    $json_str = str_replace(' ','',$json_str);
	    $json_str = str_replace('\n','',$json_str);
	    $_img_url = "uploads/classify/new_classify_icon";
	    $_json = json_decode($json_str,true);
	    $_json_list = $_json["navData"];
        $_list=0;
        for($i=0;$i<count($_json_list);$i++){
            $return['data'][$_list]['id']=$_json_list[$i]['ids'];
            $return['data'][$_list]['title']=$_json_list[$i]['title'];
            $return['data'][$_list]['isparent']=$_json_list[$i]['isparent'];
            $return['data'][$_list]['url']=isset($_json_list[$i]['url'])?$_json_list[$i]['url']:null;
            $lite = $_list + 1;
            if ($_list < 9) {
                $return['data'][$_list]['img'] = $_img_url . "0" . $lite . ".png";
            } else {
                $return['data'][$_list]['img'] = $_img_url . $lite . ".png";
            }
            $_list+=1;
        }
	    return $return;
	     }else{//新版分类页
	         $app_id = $this->session->userdata("app_info")["id"];
	         $this->db->where("app_id",0);
// 	         $this->db->where("app_id",$app_id);
	         $this->db->where("is_show",1);
	         $this->db->order_by("id");
	         $query = $this->db->get("app_category")->result_array();
	         if($query){
	            return $query;
	         }else{
	             return array();
	         }
	     }
	}
	/*
	 * 分类页
	 * 
	 * id  parent_id
	 * */
	public function getSectionListByID($id)
	{
	    $app_id = $this->session->userdata("app_info")["id"];
	    $this->db->where("app_id",0);
// 	    $this->db->where("app_id",$app_id);
	    $this->db->where('parent_id',$id);
	    $this->db->where("is_show",1);
	    $this->db->order_by("id");
	    $query = $this->db->get("app_category")->result_array();
	    if($query){
	        return $query;
	    }else{
	        return array();
	    }
	}
	// ---------------------------------------------------------------
	
    /**
     * 查询顶级分类
     */
	public function get_top_cat($path){ 
	    $query = $this->db->query("select * from 9thleaf_product_cat where id in ($path)  and parent_id = '0' and level = 1");
	    return $query->row_array();
	}
	
	// ---------------------------------------------------------------
	
	/**
	 * 查询顶级分类id
	 */
	public function get_top_catids(){
	    $query = $this->db->query("select * from 9thleaf_product_cat where parent_id = '0' and level = 1");
	    return $query->result_array();
	}
	
	/**
	 * 查询分类
	 * @param 分类id
	 */
	public function get_cate($cateid){
	    $query = $this->db->where('id',$cateid)->get('product_cat');
	    return $query->row_array();
	}
	
	
	/**
	 * 查询店铺商品分类
	 */
	public function getStoreclassification(){
	    $this->db->select("a.*");
	    $this->db->from("product_cat as a");
	    $this->db->join("product as b","a.id=b.cat_id");
	    $this->db->where("b.corporation_id",$this->session->userdata("corporation_id"));
	    $this->db->where("b.is_delete",0);
	    $this->db->group_by("a.id");
	    $query = $this->db->get();
	    $result = $query->result_array();
	    return $result;
	}
	
    
	 
	 
}