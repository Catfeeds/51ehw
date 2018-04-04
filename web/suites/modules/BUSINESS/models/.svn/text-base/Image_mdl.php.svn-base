<?php
/**
 * 
 *
 */
class Image_mdl extends CI_Model
{

    var $product_id;
    
	var $image_name;

	var $file;

	var $file_ext;
    
    var $file_mime;

	var $width;

	var $height;

	var $file_size;

	var $is_base = 0;

	var $sort_order = 0;
	
	var $original_name;


	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 * @param int $id 图片ID
	 */	
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('product_image',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

	// --------------------------------------------------------------------

    /**
	 * 创建
	 *
	 *
	 */	
    function create($data)
    { 
		$datetime = date('Y-m-d H:i:s');
//         $this->db->set('product_id', $this->product_id);
// 		$this->db->set('image_name', $this->image_name);
// 		$this->db->set('file', $this->file);
// 		$this->db->set('file_ext', $this->file_ext);
// 		$this->db->set('file_mime', $this->file_mime);
//         $this->db->set('width', $this->width);
//         $this->db->set('height', $this->height);
//         $this->db->set('file_size', $this->file_size);
//         $this->db->set('is_base', $this->is_base);
// 		$this->db->set('created_at', $datetime);
// 		$this->db->set('updated_at', $datetime);
// 		$this->db->set('original_name', $this->original_name);
        $this->db->set($data);
        $this->db->insert('product_image');
        return $this->db->insert_id();
		 //error_log($this->db->last_query());
    }
    /**
     * 检查产品是否已经设置默认图片了
     * @param Product_id  商品ID
     */
    public function check_prodcut_default($Product_id){
        $this->db->where("product_id",$Product_id);
        $this->db->where("is_base",1);
        $this->db->from("product_image");
        $query = $this->db->get()->row_array();
        return $query;
    }
    
	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_images()
	{
        $query = $this->db->get('product_image');
        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[$row['id']] = $row;
        }
        return $rows;
	}
 
	/**
	 * 结果集
	 *
	 *
	 */	
    function findProductImages($id)
	{
		$this->db->from('product_image');
		$this->db->where("product_id",$id);
        $this->db->order_by("sort_order,id");
        $query =  $this->db->get();
        return $query->result_array();

	}

    // --------------------------------------------------------------------

    /**
	 * 设置主图
	 * @param int 图片id
	 */	
    function update_is_base($id)
    {
		//获取图片对应产品ID
		$image = $this->load($id);
		
    	
		//撤销非当前主图状态
		$this->db->set('is_base', 0);
		$this->db->where('product_id', $image['product_id']);
		$this->db->update('product_image');
		
		//设置当前为主图
    	$this->db->set('is_base', 1);
        $this->db->where('id', $id);
        $this->db->update('product_image');
        
        //写进产品缩略图
        $goods_thumb = $image['image_name'].'_270'.$image['file_ext'];
        $this->db->set('goods_thumb', $goods_thumb);
        $this->db->set('goods_img', $image['image_name']."_670".$image['file_ext']);
        $this->db->where('id',$image['product_id']);
        return $this->db->update('product');
        //return $this->db->update('product_image');
    }
    
    
//     function set_thumb($id)
//     {
//     	$this->db->set('goods_thumb', 0);
//     	$this->db->where('id',$id);
//     	return $this->db->update('product');
//     }
	// --------------------------------------------------------------------

    /**
	 * 设置图片排序
	 *
	 *
	 */	
	function update_sort_order($id,$sort_order)
    {
		$this->db->set('sort_order', $sort_order);
        $this->db->where('id', $id);
        return $this->db->update('product_image');
    }
	
	// --------------------------------------------------------------------

    /**
	 * 总数
	 *
	 *
	 */	
	function total_rows()
    {
        return $this->db->count_all_results('product_image');
    }

    // --------------------------------------------------------------------

    /**
	 * 删除
	 *
	 */	
    function delete($id)
    {        
		$this->db->where('id', $id);

        return $this->db->delete('product_image'); 
    }

    // --------------------------------------------------------------------

    /**
	 * 获取最新添加的数据
	 *
	 *
	 */
	function get_newly_one()
    {
        $this->db->from('product_image');
        $this->db->order_by("id", "desc");
        $this->db->limit('1');
        $query =  $this->db->get();
        return $query->row_array();
    }
    
}