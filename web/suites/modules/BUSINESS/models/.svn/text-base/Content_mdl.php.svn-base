<?php
/**
 * 
 *
 */
class Content_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }

    function get_list($section_id = 0)
    {
    	$this->db->select("c.*,s.section_name,s.app_id");
    	$this->db->from('content c');
    	$this->db->join('section s', 'c.section_id = s.id', 'left');
    	$this->db->where(array('c.section_id' => $section_id));
    	$this->db->order_by('last_updated_time','DESC');
    	$query = $this->db->get();
    	$arr = $query->result_array();
    	return $arr;
    }
    
	// --------------------------------------------------------------------

    function get_detail($content_id = 0)
    {
    	$this->db->select("c.*,s.section_name,s.app_id");
    	$this->db->from('content c');
    	$this->db->join('section s', 'c.section_id = s.id', 'left');
    	$this->db->where(array('c.id' => $content_id));
    	$this->db->order_by('last_updated_time','DESC');
    	$query = $this->db->get();
    	$arr = $query->row_array();
    	return $arr;
    }
    
	// --------------------------------------------------------------------

    public function find_by_title( $words ){
    	$this->db->select("c.*,s.section_name,s.app_id");
    	$this->db->from('content c');
    	$this->db->join('section s', 'c.section_id = s.id', 'left');
    	$word_str = explode(' ', $words);
    	$i = 0;
    	foreach ($word_str as $word){
    		if($i === 0){
    			$this->db->like('c.title',$word);
    		}else{

    			$this->db->or_like('c.title',$word);
    		}
    		$i++;
    	}
    	$this->db->order_by('last_updated_time','DESC');
    	$query = $this->db->get();
    	if($arr = $query->result_array()){
    	
			//error_log ( $this->db->last_query () );
    		return $arr;
    	}else{
    		return array();
    	}
    	
    }
    
    function getList($offset, $num,$app_id =0,$key = '') {
    
        $this->db->select('a.*'); 
        $this->db->from ( 'content as a' );
        $this->db->join ( 'channel as b' , 'a.id_channel = b.id and b.channel_type = 3' , 'left_outer' );
        //仅显示本站点公告
//         if($app_id){
            $this->db->where ( 'a.app_id', $app_id );
//         }
        if ($key != '') {
            $this->db->like ( "concat(a.title,'||',a.content)", $key );
        }
        
        $this->db->order_by("release_time desc");
        $this->db->limit ( $num, $offset );
        
        
        $query = $this->db->get ();
        
        if ($row = $query->result_array ()) {
            return $row;
        }
    
        return array ();
    }
    
    function countList($app_id =0,$key = '') {
    
         
        $this->db->from ( 'content as a' );
        $this->db->join ( 'channel as b' , 'a.id_channel = b.id and b.channel_type = 3' , 'left_outer' );
        $this->db->where ( 'a.app_id', $app_id );
        if ($key != '') {
            $this->db->like ( "concat(a.title,'||',a.content)", $key );
        }
    
//     echo $this->db->last_query();
        return $this->db->count_all_results ();
    }
    
    function load($id){
         
        if(!$id){
            return array();
        }
        $this->db->select('a.*'); 
        $this->db->from ( 'content as a' );
        $this->db->join ( 'channel as b' , 'a.id_channel = b.id and b.channel_type = 3' , 'left_outer' );
        $this->db->where('a.id',$id);
    
        $query = $this->db->get('');
         
        if($row = $query->row_array()){
            return $row;
        }
    
        return array();
    }
    

    /**
     * 手机端帮助页面
     * @return string
     */
    function getApphelp($app_id=0,$type=0){
        
        $this->db->select('a.id,a.title');
        $this->db->from('content a');
        $this->db->join('channel b','a.id_channel = b.id and b.channel_type = '.$type,'left_outer');
        
        if ($app_id !== -1) {
            $this->db->where ( 'a.app_id', $app_id );
        }
        $this->db->limit(10,0);
        $query = $this->db->get('');
//         echo $this->db->last_query();
        if($row = $query->result_array()){
            return $row;
        }
        
        return array();
    }
    
    function save(){
         
    
        $this->db->set('po_id',$this->po_id);
        $this->db->set('title',$this->title);
        $this->db->set('url',$this->url);
        $this->db->set('sort_order',$this->sort_order);
        $this->db->set('corporation_id',$this->corporation_id);
        $this->db->set('app_id',$this->app_id);
        $this->db->where('ad_id',$this->ad_id);
    
        $res = $this->db->update('ad_info');
        if($res){
            return 'success';
        }
    
    
    }

    /**
    *    商家入驻频道
    */
    public function get_channel( $sift = array() )
    {
        if( !empty( $sift['where']['channel_name'] ) )
        { 
            $this->db->where('channel_name',$sift['where']['channel_name'] );
        }
        $res = $this->db->get('channel');
        return $res->row_array();
    }

    /**
    * 商家入驻资讯
    * @param $channel_id 频道id
    */
    public function get_merchant_content($channel_id)
    {
        $this->db->select('c.*, a.id as channel_id');
        $this->db->from("content as c");
        $this->db->join("channel as a", 'c.id_channel = a.id');
        $this->db->where("a.id", $channel_id);
        $res = $this->db->get();
        return $res->result_array();

    }
    

    
}