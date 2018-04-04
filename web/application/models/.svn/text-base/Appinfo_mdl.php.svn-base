<?php

/**
 * 公司信息内容
 *
 *
 */
class Appinfo_mdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //-------------------------------------------------------------

    /**
     * 获取公司数量
     */
    function count_app_info(){
        $query = $this->db->get("app_info");
        return $query->num_rows();
    }

    //-------------------------------------------------------------

    /**
     * 根据网站地址获取公司信息
     *
     * @param unknown $app_url
     * @return unknown
     */
    function get_all($select = "", $app_flag = -1, $orderby = "")
    {
        if ($app_flag != - 1) {
            $this->db->where("app_flag", $app_flag);
        }
        if ($select != "") {
            $this->db->select($select);
        }
        if ($orderby != "") {
            $this->db->order_by($orderby);
        }
        $this->db->from("app_info");

        $query = $this->db->get();
        $arr = $query->result_array();
        return $arr;
    }

    //-------------------------------------------------------------

    /**
     * 根据路径获取其中一个公司信息
     * @param unknown $app_url
     * @return unknown
     */
    function get_app_info($app_url)
    {
        $query = $this->db->get_where('app_info', array(
            'site_url' => $app_url
        ));
        $arr = $query->row_array();
        return $arr;
    }

    // --------------------------------------------------------------------

    /**
     * 根据ID获取公司信息
     * @param unknown $app_id
     * @return unknown
     */
    function load($app_id)
    {
        $query = $this->db->get_where('app_info', array(
            'id' => $app_id
        ));
        // echo $this->db->last_query();
        $arr = $query->row_array();
        return $arr;
    }

    // --------------------------------------------------------------------

    /**
     * 设置微信jsapi的ticket
     * @param unknown $ticket
     * @param unknown $expire_time
     */
    public function set_jsapi_ticket($ticket, $expire_time)
    {
        $app_id = $this->session->userdata('app_info')['id'];
        $this->db->set('wechat_jsapi_ticket', $ticket);
        $this->db->set('wechat_jsapi_timestamp', $expire_time);
        $this->db->where('id', $app_id);
        $this->db->update('app_info');
    }

    // --------------------------------------------------------------------

    /**
     * 设置微信access_token的时间戳
     * @param unknown $token
     * @param unknown $expire_time
     */
    public function set_access_token($token, $expire_time)
    {
        $app_id = $this->session->userdata('app_info')['id'];
        $this->db->set('wechat_access_token', $token);
        $this->db->set('wechat_token_timestamp', $expire_time);
        $this->db->where('id', $app_id);
        $this->db->update('app_info');
    }

    /**
     * 更新单个公司的access_token
     *
     * @param unknown $app_id
     * @param unknown $token
     * @param unknown $timestamp
     */
    function update_access_token($app_id, $token, $timestamp)
    {
        $this->db->where('id', $app_id);
        $this->db->update('app_info', array(
            'wechat_access_token' => $token,
            'wechat_token_timestamp' => $timestamp
        ));
    }
}