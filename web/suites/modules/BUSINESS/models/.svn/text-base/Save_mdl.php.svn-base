<?php
/**
 * 订单
 *
 *
 */
class Save_mdl extends CI_Model
{

 
	function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */	
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('save',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------

    /**
	 * 添加订单
	 *
	 *
	 */	
    function create($data)
    {   
		$datetime = date('Y-m-d H:i:s');


        $this->db->trans_start();
     
		foreach($data["order_item"] as $item)
		{
			//print_r($item);
			//保存数据
			//先查询是新增还是UPDATE
			$this->db->where(array('productid' => $item["product_id"],"userid"=>$data["userid"]));
			$this->db->from('save');
			$result = $this->db->get()->row_array();
			if($result)
			{
				//update
				$this->db->where(array('productid'=>$item["product_id"],"userid"=>$data["userid"]))->set("quantity","`quantity`+".$item["quantity"],false)->update($this->db->dbprefix('save'));
				//echo $this->db->last_query();	
			}
			else
			{
				//save
				$savedata = array("productid"=>$item["product_id"],"userid"=>$data["userid"],"quantity"=>$item["quantity"],"createdate"=>$datetime);
				$i = $this->db->insert($this->db->dbprefix('save'), $savedata);
			}
			
			//写log
			 $logdata = array("from_userid"=>0,"to_userid"=>$data["userid"],"productid"=>$item["product_id"],"quantity"=>$item["quantity"],"transferdate"=>$datetime,"flowaction"=>$data["action"]);
			 $this->db->insert($this->db->dbprefix('transfer'), $logdata);
		}
		
        if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return false;
		}
		else
		{
		    $this->db->trans_commit();
		    
		    return true;
		}


            
        //return $this->db->insert('order');
    }
    
	// --------------------------------------------------------------------
    
    public function getSaveList($userid)
    {
    	$this->db->select("a.*,b.name,b.goods_thumb");
    	$this->db->from("save as a ");
		$this->db->join("product as b","a.productid = b.id");
		$this->db->where("a.userid",$userid);
		$this->db->where("quantity >",0);
		
		
		 
		$query = $this->db->get();
		 if ($row = $query->result_array()){
		 	//echo $this->db->last_query();
           return $row;
        }
    	
    	
        return array();
    }
    
    
    public function getUserList($userid)
    {
    	$this->db->select("a.productid,b.name,b.goods_thumb");
    	$this->db->from("transfer as a ");
		$this->db->join("product as b","a.productid = b.id");
		$this->db->order_by("a.id desc");
		$this->db->where(array("a.from_userid"=>$userid,"flowaction"=>0));
		

		$query = $this->db->get();
		 if ($row = $query->result_array()){
           return $row;
        }
    	
    	
        return array();
    }
    
    public function getGiftList($userid)
    {
    	$this->db->select("a.*,b.name,b.goods_thumb,d.name as username",false);
    	$this->db->from("transfer as a ");
		$this->db->join("product as b","a.productid = b.id");
		$this->db->join("customer as d","a.to_userid = d.id");
		//$this->db->order_by("a.id desc");
		$this->db->where(array("a.from_userid"=>$userid,"flowaction"=>1));
		

		$query = $this->db->get();
		//echo $this->db->last_query();
		 if ($row = $query->result_array()){
		 	
		 	
           return $row;
        }
    	
    	
        return array();
    }
    
    public function getTotal($userid)
    {
    	$this->db->select("sum(quantity) as saveqty");
    	$this->db->from("save as a ");
		$this->db->where("a.userid",$userid);
		
		$data["saveqty"] = 0;
		
		$query = $this->db->get();
		 if ($row = $query->result_array()){
			$data["saveqty"] = $row[0]["saveqty"];
        }
        
        $this->db->select("count(*) as useqty");
    	$this->db->from("transfer");
		$this->db->where(array("from_userid"=>$userid,"flowaction"=>0));
		
		$data["useqty"] = 0;
		
		$query = $this->db->get();
		 if ($row = $query->result_array()){
			$data["useqty"] = $row[0]["useqty"];
        }
        
        $this->db->select("count(*) as giftqty");
    	$this->db->from("transfer");
		$this->db->where(array("from_userid"=>$userid,"flowaction"=>1));
		
		$data["giftqty"] = 0;
		
		$query = $this->db->get();
		 if ($row = $query->result_array()){
			$data["giftqty"] = $row[0]["giftqty"];
        }
        
        return $data;
    	
    }
    
   public   function getSave_by_condition($where=array(),$select='')
	{
		
		if(!empty($select))
			$this->db->select($select);
		$this->db->where($where);
		$this->db->from("save");
		
		$details = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $details;
	}
	
	public function giveSave($data)
	{
		
		$datetime = date('Y-m-d H:i:s');


        $this->db->trans_start();
     
		$this->db->where(array('productid'=>$data["product_id"],"userid"=>$data["fromuserid"],"quantity >="=>$data["quantity"]))->set("quantity","`quantity`-".$data["quantity"],false)->update($this->db->dbprefix('save'));
		
		$this->db->where(array('productid' => $data["product_id"],"userid"=>$data["touserid"]));
		$this->db->from('save');
		$result = $this->db->get()->row_array();
		if($result)
		{
			//update
			$this->db->where(array('productid'=>$data["product_id"],"userid"=>$data["touserid"]))->set("quantity","`quantity`+".$data["quantity"],false)->update($this->db->dbprefix('save'));
			//echo $this->db->last_query();	
		}
		else
		{
			//save
			$savedata = array("productid"=>$data["product_id"],"userid"=>$data["touserid"],"quantity"=>$data["quantity"],"createdate"=>$datetime);
			$i = $this->db->insert($this->db->dbprefix('save'), $savedata);
		}
			
		//写log
		$logdata = array("from_userid"=>$data["fromuserid"],"to_userid"=>$data["touserid"],"productid"=>$data["product_id"],"quantity"=>$data["quantity"],"transferdate"=>$datetime,"flowaction"=>$data["action"]);
		$this->db->insert($this->db->dbprefix('transfer'), $logdata);

		
        if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return false;
		}
		else
		{
		    $this->db->trans_commit();
		    
		    return true;
		}
	}
  

}