<?php
/**
 * 
 *
 *
 */
class Home_template_set_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}

    function load_Floor(){
        
        $this->db->select('cts.*,ctl.level_name,ctl.level_temp');
        $this->db->from('corporation_template_level ctl');
        $this->db->join('corporation_template_set cts','cts.template_id = ctl.id','left');
        $this->db->like("cts.temp_key","-");
        //$this->db->where('template_id',$template_id);
        $this->db->order_by('ctl.id','ASC');
        $this->db->order_by('cts.temp_key','ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($row = $query->result_array()){
            return $row;
        }
        return NULL;
    }
	
    function load_level(){
        
        $query = $this->db->get("corporation_template_level");
        
        if($row = $query->result_array())
            return $row;
        return NULL;
        
    }
    
    function load_index(){
        $this->db->select('cts.*,ctl.level_name,ctl.level_temp');
        $this->db->from('corporation_template_level ctl');
        $this->db->join('corporation_template_set cts','cts.template_id = ctl.id','left');
        $this->db->not_like("cts.temp_key","-");
        //$this->db->where('template_id',$template_id);
        $this->db->order_by('ctl.id','ASC');
        $this->db->order_by('cts.temp_key','ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($row = $query->result_array()){
            return $row;
        }
        return NULL;
    }

	 public function get_display_list($corporation_id,$app_id)
        {
            $level_table="9thleaf_corporation_template_level";
            $set_table="9thleaf_corporation_template_set";
        
            $this->db->select($level_table.".id as 'level_id',".$level_table.".level_name,".$level_table.".level_morelink,".$level_table.".level_temp,".$set_table.".id,".$set_table.".temp_key,".$set_table.".img_path,".$set_table.".desc,".$set_table.".link_path");
            $this->db->from("9thleaf_corporation_template_level");
            $this->db->order_by("9thleaf_corporation_template_set.id");
            $this->db->where("9thleaf_corporation_template_level.corporation_id",$corporation_id);
			$this->db->where("9thleaf_corporation_template_set.corporation_id",$corporation_id);
            $this->db->where('9thleaf_corporation_template_level.app_id',$app_id);
            $this->db->where('9thleaf_corporation_template_level.is_show',1);
            $this->db->join('9thleaf_corporation_template_set','9thleaf_corporation_template_level.id=9thleaf_corporation_template_set.template_id and 9thleaf_corporation_template_set.is_show=1');
            $query=$this->db->get();
            
            //echo $this->db->last_query();
            
            $result=$query->result_array();
            return $result;
        }

}