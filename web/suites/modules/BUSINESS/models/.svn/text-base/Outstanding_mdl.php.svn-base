<?php 
/**
* 
*/
class Outstanding_mdl extends CI_Model
{
   

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
    }
    

   /**
    * 杰出商会 = 中间表存在的部落列表。
    * @date:2017年11月22日 下午5:27:38
    * @author: fxm
    * @param: variable
    * @return: 
    */
    public function Load()
    {
        $this->db->select('t.*');
        $this->db->from('outstanding as o ');
        $this->db->join('tribe as t','t.id = o.tribe_id');
        $this->db->group_by('t.id');
        $query = $this->db->get();
        return $query->result_array();
           
    }




}