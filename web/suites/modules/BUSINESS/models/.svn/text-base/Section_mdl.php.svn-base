<?php
/**
 *
 *
 *
 */
class Section_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function load_root($app_id = 0) {
		$query = $this->db->get_where ( 'section', array (
				'pid' => 0,
				'app_id' => $app_id
		) );

		if ($row = $query->result_array ()) {
			return $row;
		}

		return array ();
	}
	function load($id = 0) {
		if ($id == 0) {
			return array ();
		}

		$query = $this->db->get_where ( 'section', array (
				'id' => (int)$id
		) );

		if ($row = $query->row_array ()) {
			return $row;
		}

		return array ();
	}
	/**
	 * 读树
	 *
	 * @param number $app_id
	 */
	function load_tree($app_id = 0) {
		/*
		 * $sql = "CALL 9thleaf_section_recursive(0, ".$app_id.")";
		 * $query = $this->db->query($sql);
		 * $rows = array();
		 * if ($query->num_rows() > 0) {
		 * $rows = $query->result_array();
		 * }else{
		 * $query = NULL;
		 * }
		 * return $rows;
		 */
		$query = $this->db->order_by ( "fpath" )->get_where ( 'section', array (
				'app_id' => $app_id
		) );

		if ($row = $query->result_array ()) {
			return $row;
		}
	}
	/**
	**
	**
	*/
	function load_tree_for_app($app_id = 0) {
		//取第一級

		$this->db->select("a.*,ifnull(b.section_name,'根目录') as p_section_name",false);
		$this->db->from("section as a");
		$this->db->join("section as b","a.pid = b.id","left");
		$this->db->where("a.app_id",$app_id);
		$this->db->order_by ( "fpath" );
		$query = $this->db->get();
		$result=array();
		$list = $query->result_array ();
		$i = 0;
		/*foreach($list as $key=>$section)
		{
			if($section["pid"] == 0)
			{
				array_push($result,$section);
				foreach($list as $sec2)
				{
					if(strpos($sec2["fpath"],$section["fpath"])>-1 && $sec2["pid"] !=0)
					{
						$flag = true;
						foreach($list as $se)
						{
							if($sec2["id"] == $se["pid"] )
							{
								$flag == false;
								break;
							}
						}
						if($flag)
						{
							$sec2["pid"]=$section["id"];
							$sec2["p_section_name"] = $section["section_name"];
							array_push($result,$sec2);
							//$i++;
						}
					}
					
				}

			}
			//$i++;
		}

*/
	

		//echo $this->db->last_query();
		return $list;
		
		
	}
	function get_tree_list($id = 0, $app_id, $section_type) {
		$query = $this->db->get_where ( 'section', array (
				'app_id' => $app_id
		) );

		if ($row = $query->result_array ()) {
			return $row;
		}
	}

	// ------------------------------------------------------------------------------------

	/**
	 * 获取列表
	 *
	 * @param number $parent_id
	 * @param unknown $app_id
	 * @param number $section_type
	 * @param unknown $customer_id
	 * @return multitype:
	 */
	function get_list($parent_id = 0, $app_id = -1, $section_type = 1, $corporation_id = -1,$sfpath=0,$schildren=0) {
		$this->db->from ( 'section' );
		if ($app_id != - 1) {
			$this->db->where ( 'app_id', $app_id );
		}
		if ($corporation_id != - 1) {
			$this->db->where ( 'corporation_id', $corporation_id );
		}
		if($sfpath>0){
		    $this->db->where('id != ' .$sfpath);
		    $this->db->not_like( 'fpath',','.$sfpath.',' );
		}
		if($parent_id >0)
		    $this->db->like ( 'fpath', ',' . $parent_id . ',');
		if($schildren>0)
		    $this->db->where ( 'pid',$schildren );

		$this->db->where ( 'section_type', $section_type );

		$query = $this->db->get ();
		$rows = array ();
//  echo $this->db->last_query();exit;
		if ($query->num_rows () > 0) {
			$rows = $query->result_array ();
		}
// 		$this->db->close ();
		return $rows;
	}

	// --------------------------------------------------------------------

	/**
	 * 创建
	 */
	function insert($section) {
		$this->db->set ( 'section_name', $section ['section_name'] );
		$this->db->set ( 'pid', $section ['pid'] );
		$this->db->set ( 'app_id', $section ['app_id'] );
		$this->db->set ( 'section_type', $section ['section_type'] );
		$this->db->set ( 'sequence', $section ['sequence'] );
		$this->db->set ( 'fpath', $section ['fpath'] );
		$this->db->set ( 'corporation_id', $section ['corporation_id'] );
		return $this->db->insert ( 'section' );
	}

	// --------------------------------------------------------------------

	/**
	 * 更新
	 */
	function update($id, $section) {
	    if(isset($section ['section_name']))
		  $this->db->set ( 'section_name', $section ['section_name'] );
	    if(isset($section ['pid']))
		  $this->db->set ( 'pid', $section ['pid'] );
	    if(isset($section ['app_id']))
		  $this->db->set ( 'app_id', $section ['app_id'] );
	    if(isset($section ['section_type']))
		  $this->db->set ( 'section_type', $section ['section_type'] );
	    if(isset($section ['sequence']))
		  $this->db->set ( 'sequence', $section ['sequence'] );
	    if(isset($section ['fpath']))
		  $this->db->set ( 'fpath', $section ['fpath'] );

		$this->db->where ( 'id', $id );
		return $this->db->update ( 'section' );
	}

	// --------------------------------------------------------------------

	/**
	 * 删除
	 */
	function delete($id) {
		$this->db->where ( 'id', $id );

		return $this->db->delete ( 'section' );
	}
    
	// --------------------------------------------------------------------

    /**
     * 店铺分类列表
     */
    function shop_classify_list( $corp_id = 0,$pid = null,$app_id=null,$limit=null){ 
        $this->db->from ( 'section' );
        if($corp_id > 0)
            $this->db->where('corporation_id',$corp_id);
            $this->db->where('section_type','0');
        if( !empty($pid) )
            $this->db->where('pid','0');
        if(!empty($app_id) )
            $this->db->where('app_id',$app_id);
        if(!empty($limit) )
            $this->db->limit($limit);
        $this->db->order_by('sequence','asc');
        $query = $this->db->get ();
//                   echo $this->db->last_query();       
        $rows = $query->result_array();

        return $rows;
    }
}