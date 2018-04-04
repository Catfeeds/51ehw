<?php

/**
 * 订单项
 *
 *
 */
class Package_mdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * 发送红包
     * @param int $user_id 用户id
     * @param array $data 
     */
    function send_package($user_id, $data)
    {
        $create_at = date('Y-m-d H:i:s');
        // 发送红包
        $this->db->set('originator', $user_id);
        $this->db->set('type', $data['status']);
        $this->db->set('num', $data['num']);
        $this->db->set('total', $data['total']);
        $this->db->set('create_at', $create_at);
        $this->db->set('desc', $data['desc']);
        $this->db->insert('red_envelope');
        $r_id = $this->db->insert_id();

        $detail_data = array();
        // 普通货包
        if ($data['status'] == 1) {
            for ($i = 0; $i < $data['num']; $i ++) {
                $temp_data = array(
                    'r_id' => $r_id,
                    'amount' => $data['per_m']
                );
                array_push($detail_data, $temp_data);
            }
            // 随机货包
        } else {
                $total=$data['total'];//红包总金额 
                $num=$data['num'];// 分成10个红包，支持10人随机领取 
                $min=0.01;//每个人最少能收到0.01元 
               
                
                for ($i=1;$i<$num;$i++) //红包算法
                { 
                    $safe_total=($total-($num-$i)*$min)/($num-$i);//随机安全上限
                    @$money=mt_rand($min*100,$safe_total*100)/100;
                    if($money<$min){
                        $money = $min;
                    }
                    $total=$total-$money; 
                    $temp_data = array(
                        'r_id' => $r_id,
                        'amount' => $money
                    );
  
                    $detail_data[] = $temp_data;
                }

                $temp_data = array(
                    'r_id' => $r_id,
                    'amount' => $total
                );
                $detail_data[] = $temp_data;
                shuffle($detail_data);//随机数组
            }

        $this->db->insert_batch('red_envelope_detail', $detail_data);
        return $r_id;
    }
    

    function obtain_package($weachat, $r_id)
    {
        $this->db->from('customer');
        $this->db->where('wechat_account', $weachat);
        $query = $this->db->get();
        $data = $query->row_array();

        if ($data) {
            $this->db->from('red_envelope_detail');
            $where = array(
                'r_id' => $r_id,
                'recipient' => $data['nick_name']
            );
            $this->db->where($where);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result) {
                $query = $this->db->query("SELECT * FROM (`9thleaf_red_envelope_detail`) WHERE `r_id` = $r_id AND `recipient` != ''");
                $result = $query->result_array();
                return $result;
            } else {
                $query = $this->db->query("SELECT * FROM (`9thleaf_red_envelope_detail`) WHERE `r_id` = $r_id AND `recipient` IS NULL or `recipient`=''");
                $result = $query->result_array();
                if (! empty($result)) {
                    $array = array();
                    foreach ($result as $v) {
                        $array[] = $v['id'];
                    }
                    $receive_at = date('Y-m-d H:i:s');
                    $rand_key = array_rand($array);
                    $this->db->set('recipient', $data['nick_name']);
                    $this->db->set('receive_at', $receive_at);
                    $this->db->where('id', $array[$rand_key]);
                    $this->db->update('red_envelope_detail');

                    $query = $this->db->query("SELECT * FROM (`9thleaf_red_envelope_detail`) WHERE `r_id` = $r_id  AND `recipient` != ''");
                    $result = $query->result_array();
                    return $result;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function receive($weachat, $phone, $red_id)
    {
        $this->db->set('phone', $phone);
        $this->db->set('wechat_account', $weachat);
        $this->db->set('password', $phone);
        $this->db->set('nick_name', $phone);
        $a = $this->db->insert('customer');
        $customer_id = $this->db->insert_id();
        if ($a) {
            $result = $this->obtain_package($weachat, $red_id);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        }
    }

    // -------------------------------------------------------------------------------------------

    /**
     * 根据id读取红包
     *
     * @param unknown $id
     */
    function load($id)
    {
        $query = $this->db->get_where('red_envelope', array(
            'id' => $id
        ));

        return $query->row_array();
    }

    // -------------------------------------------------------------------------------------------

    /**
     * 查查自己的红包
     *
     * @param unknown $package_id
     * @param unknown $customer_id
     */
    function get_package($package_id, $customer_id)
    {
        $query = $this->db->get_where('red_envelope_detail', array(
            'customer_id' => $customer_id,
            'r_id' => $package_id
        ));

        return $query->row_array();
    }

    // -------------------------------------------------------------------------------------------

    /**
     * 抽红包
     *
     * @param unknown $package_id
     * @param unknown $customer_id
     */
    function get_one_package($package_id, $customer_id)
    {
        $this->db->limit(1);
        $this->db->set('customer_id', $customer_id);
        $this->db->set('receive_at', date('Y-m-d H:i:s'));
        $this->db->where('customer_id is null', NULL);
        $this->db->where('r_id', $package_id);
        $this->db->update('red_envelope_detail');

        $res = $this->db->affected_rows();
        return $res;
    }

    // -------------------------------------------------------------------------------------------

    /**
     *
     * @param unknown $package_id
     */
    function get_package_list($package_id)
    {
        $this->db->select("red.*, c.img_avatar, c.nick_name,c.wechat_nickname, c.wechat_avatar");
        $this->db->from('red_envelope_detail red');
        $this->db->join('customer c', 'red.customer_id = c.id', 'left');
        $this->db->where('red.r_id', $package_id);
        $this->db->where('red.customer_id != ', '');
        $query = $this->db->get();

        return $query->result_array();
    }

    function is_package_full($package_id)
    {
        $query = $this->db->get_where('red_envelope_detail', array(
            'customer_id is null' => NULL,
            'r_id' => $package_id
        ));
        return $query->num_rows();
    }
    
    /**
     * 查询超过24小时未领取的红包
     */
    public function overdue_redpacket()
    {
        $time = date('Y-m-d H:i:s');
        $this->db->select('count(red.id) as num,re.id,sum(amount) as price,  re.originator as customer_id');
        $this->db->from('red_envelope as re');
        $this->db->join('red_envelope_detail as red','re.id = red.r_id');
        $this->db->where('(red.customer_id is null or red.customer_id = \'\')');
        $this->db->where("'$time' >", 'date_add(re.create_at, INTERVAL 1 day)',false);
        $this->db->group_by('red.r_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    /**
     * 修改超过24小时未领取的红包-默认被系统领取
     */
    public function updates_customer( $r_id_array = array() )
    {
    
        if(!$r_id_array )
        {
            return false;
        }
        $this->db->set('customer_id','-1');
        $this->db->where('(customer_id is null or customer_id = \'\')');
        $this->db->where_in('r_id',$r_id_array);
        $this->db->update('red_envelope_detail');
        return $this->db->affected_rows();
    }
}