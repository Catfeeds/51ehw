<?php
/**
 * 商品
 *
 *
 */
class Product_sku_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }


    // --------------------------------------------------------------------

    /**
	 * 查询
	 *
	 *
	 */
	function getSKUByProductid($product_id)
    {
		$return_val = array();
		$this->db->select('a.*,b.stock,b.price,b.m_price,b.mix_m_price,b.mix_rmb_price,b.plus_no,b.special_offer');
        $this->db->from('product_sku as a');
		$this->db->join('product_sku_value as b','a.val_id=b.id','left');
		$this->db->where('a.product_id',$product_id);
        $this->db->order_by("val_id,attr_id,sku_id");//改了选一个就出表格，所以不能排序。
        $result =  $this->db->get()->result_array();
// 		echo $this->db->last_query();
        if($result)
		{
			$val_id = -1;
			$sku_key = "";
			$detail = array();
			$skulist = array();
// 			echo '<pre>';
// 			print_r($result);exit;
			foreach($result as $res)
			{
// 				print_r($res);

				//echo $val_id."8888".$res["val_id"]."<br/>";
				if($val_id>-1 && $val_id != $res["val_id"])
				{
					//echo $res["sku_id"];

					if(strlen($detail["sku_key"])>1)
					{
						//echo "ddgg";
						$detail["sku_key"] = substr($detail["sku_key"],0,strlen($detail["sku_key"])-1);
					}
					array_push($return_val,$detail);
					$detail = array();
					$sku_key = $res["attr_id"]."-".$res["sku_id"]."_";
					$val_id = $res["val_id"];
					$detail['sku_id'] = $res['id'];
					$detail["sku_key"] = $sku_key;
					$detail["store"] = $res["stock"]==""?0:$res["stock"];
					$detail["price"] = $res["price"]==""?0:$res["price"];
					$detail['m_price'] = $res['m_price']==""?0:$res["m_price"];
					$detail['mix_m_price'] = $res['mix_m_price']==""?0:$res["mix_m_price"];
					$detail['special_offer'] = $res['special_offer']==""?0:$res["special_offer"];
					$detail['mix_rmb_price'] = $res['mix_rmb_price']==""?0:$res["mix_rmb_price"];
					$detail["plus_no"] = $res["plus_no"];
					$detail["val_id"] = $res["val_id"];
				}
				else
				{

					$sku_key = $sku_key.$res["attr_id"]."-".$res["sku_id"]."_";
					//print_r($sku_key."<br/>");
					$detail['sku_id'] = $res['id'];
					$detail["sku_key"] = $sku_key;
					$detail["store"] = $res["stock"];
					$detail["price"] = $res["price"];
					$detail['m_price'] = $res['m_price'];
					$detail['mix_m_price'] = $res['mix_m_price'];
					$detail['special_offer'] = $res['special_offer'];
					$detail['mix_rmb_price'] = $res['mix_rmb_price'];
					$detail["plus_no"] = $res["plus_no"];
					$detail["val_id"] = $res["val_id"];
					if($val_id ==-1){
						$val_id = $res["val_id"];
					}
					//echo "^^^^^";
					//print_r($detail);
				}


			}

			//print_r($detail);

			if(count($result)>=1 && !empty($detail))
			{

				if(strlen($detail["sku_key"])>1)
				{
					$detail["sku_key"] = substr($detail["sku_key"],0,strlen($detail["sku_key"])-1);

				}
				array_push($return_val,$detail);
			}

// 			print_r($return_val);
		}

		$this->db->select('a.attr_id,a.sku_id,a.sku_name,b.attr_name');
		$this->db->from('product_sku as a');
		$this->db->join('product_attr as b','a.attr_id=b.id','left');
		$this->db->where('a.product_id',$product_id);
        $this->db->group_by('a.attr_id,a.sku_id,a.sku_name,b.attr_name');
		$this->db->order_by("attr_id,sku_id");

		$skuitem =$this->db->get()->result_array();
// 		echo $this->db->last_query();
//         print_r($skuitem);
//exit();
		return array("skulist"=>$return_val,"skuinfo"=>$result,"skuitem"=>$skuitem);

    }

	function getSKUByValID($val_id)
	{
	    $this->db->select('a.*,b.attr_name');
	    $this->db->from('product_sku as a');
	    $this->db->join('product_attr as b','b.id = a.attr_id','left');
		$this->db->where_in("val_id",$val_id);

		return $this->db->get()->result_array();
	}

	function getSKUValue($val_id)
	{
		$this->db->where("id",$val_id);
		$this->db->from('product_sku_value');

		return $this->db->get()->row_array();
	}


	function updateSKUValue($val_id,$data)
	{
// 	    echo '<pre>';
// 	    var_dump($data);exit;
		return $this->db->where('id',$val_id)->update("product_sku_value",$data);
	}

	function create_value($data){

	    $this->db->set($data);
	    $this->db->insert('product_sku_value');

	    return $this->db->insert_id();
	}

	function update_value_stock($data){

	    $this->db->set("stock","stock -".$data["qty"],false);
	    $this->db->where("id",$data["id"]);
	    $this->db->where("stock >=",$data["qty"]);
	    $this->db->update('product_sku_value');

	    return $this->db->affected_rows();
	}

	function create($data){

	    $this->db->set($data);
	    $this->db->insert('product_sku');

	    return $this->db->insert_id();
	}
	
	//---------------将B端产品复制到C端-------
	function createsku_c($data){
	    $this->db->set($data);
	    $this->db->insert('product_sku');
	    return $this->db->insert_id();
	}
	// --------------------------------------------------------------------
	
    function deleteByValID($val_id){ 
        $this->db->where('val_id', $val_id);
        $this->db->delete('product_sku');
        return $this->db->affected_rows();
    }
    
    function deleteSkuVal($id){ 
        $this->db->where('id', $id);
        $this->db->delete('product_sku_value');
        return $this->db->affected_rows();
    }
    
    function update_sku($data){ 
        $this->db->set('sku_name',$data['sku_name']);
        $this->db->where('sku_id',$data['sku_id']);
        $this->db->where('attr_id',$data['attr_id']);
        $this->db->where('product_id',$data['product_id']);
        $this->db->update("product_sku");
        return $this->db->affected_rows();
    }
    
    /**
     * 查询SKU_VALUE & SKU_NAME
     */
    public function load_sku( $sku_val_id,$product_id )
    {
        $this->db->select("psv.*,group_concat(pa.attr_name,':',ps.`sku_name`) as sku_name");
        $this->db->from('product_sku_value as psv');
        $this->db->join('product_sku as ps','psv.id = ps.val_id','left');
        $this->db->join('product_attr as pa','pa.id = ps.attr_id','left');
        $this->db->where('ps.product_id',$product_id);
        $this->db->where('psv.id',$sku_val_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}