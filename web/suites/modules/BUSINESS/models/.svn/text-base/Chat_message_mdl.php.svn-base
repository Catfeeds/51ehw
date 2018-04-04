<?php
/**
 *
 * 聊天室模型
 *
 */

class  Chat_message_mdl extends CI_Model {
    
    function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 创建聊天室  
     * @param array $member_id = array('11','2365') 成员ID
     * @param int $tribe_id  部落ID
     */
    public  function createChatChannel($member_id = array(),$tribe_id = 0){
       $member_count = count($member_id);
       if($member_count < 2 ){
           //聊天室成员必须大于等于2个人
            return false;
       }
       $user_id = $this->session->userdata("user_id");
       $this->db->trans_begin(); // 事物执行方法中的MODEL。
       $date = date('Y-m-d H:i:s');// 当前时间
       $this->db->set('customer_id',$user_id);
       $this->db->set('tribe_id',$tribe_id);
       $this->db->set('create_at',$date);
      
       $this->db->insert("chat_channel");
       $Channel_id = $this->db->insert_id();
       
       $aff = false;
       $to_customer_id = 0;
       
       if($Channel_id){
           $data = array();
           foreach ($member_id as $k => $v){
               if($member_count == 2 && $v!=$user_id){
                   $to_customer_id = $v;
               }
               $info['chat_channel_id'] = $Channel_id;
               $info['customer_id'] = $v;
               $info['create_at'] = $date;
               $data[] = $info;
           }
           //给聊天室添加聊天成员
           $aff = $this->db->insert_batch('chat_channel_member',$data);
           if($aff){
               $insert['from_customer_id'] = $user_id;
               $insert['chat_channel_id'] = $Channel_id;
               $insert['is_delete'] = 1;//已删除
               $Msg_id = $this->insertMsg($insert);
               if($Msg_id){
                   $Log['chat_channel_id'] = $Channel_id;
                   $Log['chat_message_id'] = $Msg_id;
                   $Log['customer_id'] = $to_customer_id;
                   $Log['create_at'] = $date;
                   $Read_Log_id = $this->insertRead_Log($Log);
               }
               
               $insert1['from_customer_id'] = $to_customer_id;
               $insert1['chat_channel_id'] = $Channel_id;
               $insert1['is_delete'] = 1;//已删除
               $Msg_id1 = $this->insertMsg($insert1);
               if($Msg_id1){
                   $Log1['chat_channel_id'] = $Channel_id;
                   $Log1['chat_message_id'] = $Msg_id1;
                   $Log1['customer_id'] = $user_id;
                   $Log1['create_at'] = $date;
                   $Read_Log_id = $this->insertRead_Log($Log1);
               }
             
               if($Msg_id && $Msg_id1){
                   $user_List_id  = $this->createList($user_id,$Channel_id);//自己聊天列表显示
                   $to_user_List_id  = $this->createList($to_customer_id,$Channel_id,0);//他人的聊天列表不显示
                   if($to_user_List_id && $to_user_List_id){
                       //创建成功
                       $this->db->trans_commit();
                       return $Channel_id;
                   }else{
                       //创建失败
                       $this->db->trans_rollback();
                       error_log($this->db->last_query());
                       return false;
                   }
               }else{
                   //创建失败
                   $this->db->trans_rollback();
                   error_log($this->db->last_query());
                   return false;
               }
             
           }else{
               //创建失败
               $this->db->trans_rollback();
               error_log($this->db->last_query());
               return false;
           }
       }else{
          //创建失败
           $this->db->trans_commit();
           error_log($this->db->last_query());
           return false;
       }
      
    }
    
    /**
     * 查询聊天室
     */
    public function loadChannelById($chat_channel_id = 0,$tribe_id = 0){
        if(!$chat_channel_id && !$tribe_id){
            return false;
        }
        if($chat_channel_id){
            $this->db->where('id',$chat_channel_id);
        }
        if($tribe_id){
            $this->db->where('tribe_id',$tribe_id);
        }
        $this->db->from("chat_channel");
        $data = $this->db->get()->row_array();
  
        if($data){
            $this->db->where('chat_channel_id',$data['id']);
            $this->db->from("chat_channel_member");
            $member_list = $this->db->get()->result_array();
         
            $data['member_list'] = $member_list;
        }
        return $data;
    }
    
    
    
    /**
     * 检查是否存在某个聊天室
     */
    function getChannelMember($chat_channel_id,$customer_id){
       $this->db->where('customer_id',$customer_id); 
       $this->db->where('chat_channel_id',$chat_channel_id);
       $this->db->from("chat_channel_member");
       $member = $this->db->get()->row_array();
       return $member;
    }
    
    function  getChannelOtherMember($chat_channel_id,$customer_id){
        $this->db->where("customer_id != $customer_id");
        $this->db->where('chat_channel_id',$chat_channel_id);
        $this->db->from("chat_channel_member");
        $member = $this->db->get()->row_array();
        return $member;
    }
    
    function addChannelMember($chat_channel_id,$huanxin_group_id,$customer_id){
        $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set('customer_id',$customer_id);
        $this->db->set('chat_channel_id',$chat_channel_id);
        $this->db->set('huanxin_group_id',$huanxin_group_id);
        $this->db->set('create_at',$date);
        $this->db->insert("chat_channel_member");
        return $this->db->insert_id();
    }
    
    function  delChannelMember($Member_id){
        $this->db->where("id",$Member_id);
        $this->db->delete("chat_channel_member");
        return $this->db->affected_rows();
    }
    
    /**
     * 获取单条聊天记录
     */
    public  function  getSingleChatlog($Msg_id){
        $this->db->select("cm.*,c.real_name,c.nick_name,c.wechat_nickname,c.brief_avatar,c.wechat_avatar,t.id as tribe_id,t.name,t.logo");
        $this->db->where("cm.id",$Msg_id);
        $this->db->from("chat_message as cm");
        $this->db->join("customer as c","c.id = cm.from_customer_id");
        $this->db->join("chat_channel as cc","cc.id = cm.chat_channel_id");
        $this->db->join("tribe as t","t.id = cc.tribe_id","left");
        return $this->db->get()->row_array();
    }
    
    
    /**
     * 获取聊天记录
     */
    public function getChatLog($condition,$limit = 0,$offset = 0){
        $this->db->from("chat_message");
        if(!empty($condition['chat_channel_id'])){
            $this->db->where("chat_channel_id",$condition['chat_channel_id']);
        }
       
        $this->db->where("is_delete",0); 
        
        if($offset){
            $this->db->order_by("create_at","DESC");
            //当聊天室存在聊天记录时则每次进入会把最新5条
            //所以下拉则把前5条给去掉
            if(!empty($condition['hist_ids'])){
                $hist_ids = trim($condition['hist_ids'],',');
                $this->db->where("id not in ({$hist_ids})");
            }
            $this->db->limit($limit,$offset);
            return $this->db->get()->result_array();
        }else if($limit){
            $this->db->order_by("create_at","DESC");
            if($limit == 1){
                $this->db->limit($limit);
                return $this->db->get()->row_array();
            }else{
                $this->db->order_by("create_at","DESC");
                //当聊天室存在聊天记录时则每次进入会把最新5条
                //所以下拉则把前5条给去掉
                if(!empty($condition['hist_ids'])){
                    $hist_ids = trim($condition['hist_ids'],',');
                    $this->db->where("id not in ({$hist_ids})");
                }
                $this->db->limit($limit);
                return $this->db->get()->result_array();
            }
        }
       
    }
    
    /**
     * 获取聊天的对象(适用单聊)
     */
    public function geChatUser($chat_channel_id){
        $user_id = $this->session->userdata("user_id");
        $this->db->select("cm.from_customer_id,c.real_name,c.nick_name,c.wechat_nickname,c.brief_avatar,c.wechat_avatar");
        $this->db->where("cm.chat_channel_id",$chat_channel_id);
        $this->db->where("cm.from_customer_id !=",$user_id);
        $this->db->from("chat_message as cm");
        $this->db->join("customer as c","cm.from_customer_id = c.id");
        return $this->db->get()->row_array();
    }
    
    
    /**
     * 获取所有的聊天的未读数
     */
    public function getAllNotReadCount($list_channel_ids){
        $customer_id = $this->session->userdata("user_id");
        
        //总数量
        $this->db->select("cm.id");
        $this->db->where_in("cm.chat_channel_id",$list_channel_ids);
        $this->db->where("cm.from_customer_id !=",$customer_id);
        $this->db->from("chat_message as cm");
        $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id","left");
        $this->db->where("cm.is_delete",0);//未删除
        $this->db->group_by("cm.id");
        $total = $this->db->get()->num_rows();
        
        //已阅读数量
        $this->db->select("cm.id");
        $this->db->where_in("cm.chat_channel_id",$list_channel_ids);
        $this->db->where("cm.from_customer_id !=",$customer_id);
        $this->db->from("chat_message as cm");
        $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id");
        $this->db->where("cm.is_delete",0);//未删除
        $this->db->group_by("cm.id");
        $read_total = $this->db->get()->num_rows();
        
        //未读数量
        return $total-$read_total;
    }
    
    
    /**
     * 获取未读消息数
     * 查询某个聊天室的未读数  查询某个部落群聊天室的未读数
     */
     public function getNotReadCount($chat_channel_id = 0,$tribe_id = 0){
         $customer_id = $this->session->userdata("user_id");
         if($chat_channel_id){
             //总数量
             $this->db->select("cm.id");
             $this->db->where("cm.chat_channel_id",$chat_channel_id);
             $this->db->where("cm.from_customer_id !=",$customer_id);
             $this->db->from("chat_message as cm");
             $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id","left");
             $this->db->where("cm.is_delete",0);//未删除
             $this->db->group_by("cm.id");
             $total = $this->db->get()->num_rows();
             
             //已阅读数量
             $this->db->select("cm.id");
             $this->db->where("cm.chat_channel_id",$chat_channel_id);
             $this->db->where("cm.from_customer_id !=",$customer_id);
             $this->db->from("chat_message as cm");
             $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id");
             $this->db->where("cm.is_delete",0);//未删除
             $this->db->group_by("cm.id");
             $read_total = $this->db->get()->num_rows();
             
             //未读数量
             return $total-$read_total;
         }else if($tribe_id){
             
             $this->db->select("cm.id");
             $this->db->where("cl.tribe_id",$tribe_id);
             $this->db->from('chat_channel as cl');
             $this->db->join("chat_message as cm","cl.id = cm.chat_channel_id");
             $this->db->where("cm.from_customer_id !=",$customer_id);
             $this->db->where("cm.is_delete",0);//未删除
             $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id","left");
             $this->db->group_by("cm.id");
             $total = $this->db->get()->num_rows();
             
             
             
             $this->db->select("cm.id");
             $this->db->where("cl.tribe_id",$tribe_id);
             $this->db->from('chat_channel as cl');
             $this->db->join("chat_message as cm","cl.id = cm.chat_channel_id");
             $this->db->where("cm.from_customer_id !=",$customer_id);
             $this->db->where("cm.is_delete",0);//未删除
             $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id");
             $this->db->group_by("cm.id");
             $read_total = $this->db->get()->num_rows();
             //              echo '<pre>';
             //              print_r($this->db->last_query());exit;
             //未读数量
             return $total-$read_total;
         }else{
             return 0;
         }
     }
    
     /**
      *获取某个部落下的成员之前的聊天室
      */
     public function getTribeSingleChat($tribe_id){
         $customer_id = $this->session->userdata("user_id");
         $this->db->select("cl.*");
         $this->db->where("cl.customer_id",$customer_id);
         $this->db->from("chat_list as cl");
         $this->db->join("chat_channel as cc","cl.chat_channel_id = cc.id and cc.tribe_id =0");
         $this->db->join("chat_channel_member as ccm","cc.id = ccm.chat_channel_id");
         $this->db->join("tribe_staff as ts","ccm.customer_id = ts.customer_id and ts.tribe_id = {$tribe_id}");
         $this->db->where("ts.status",2);
         $this->db->group_by("cl.id");
         return $this->db->get()->result_array();
     }
     
     /**
      * 获取聊天记录最新的一条
      * $channel_ids  聊天室ID  array
      */
     public function  getLatestLog($channel_ids){
         $this->db->from("chat_message as cm");
         $this->db->where_in("cm.chat_channel_id",$channel_ids);
         $this->db->order_by("cm.create_at DESC");
         $this->db->limit(1);
         return $this->db->get()->row_array();
     } 
     
     
     /**
      * 获取所有聊天列表
      */
     public function getAllList($tribe_id){
         $user_id = $this->session->userdata("user_id");
         $this->db->select("cl.*");
         $this->db->where("cl.customer_id",$user_id);
         $this->db->where("cl.is_show",1);
         $this->db->from("chat_list as cl");
         if($tribe_id){
             $this->db->join("chat_message as cm",'cm.chat_channel_id = cl.chat_channel_id');
             $this->db->join("tribe_staff as ts","ts.customer_id = $user_id");
             $this->db->join("tribe_staff as tss","tss.customer_id = cm.from_customer_id");
             $this->db->where("ts.tribe_id",$tribe_id);
             $this->db->where("tss.tribe_id",$tribe_id);
             $this->db->group_by("cl.id");
         }
         $this->db->order_by("cl.update_at DESC");
         return $this->db->get()->result_array();
     }
     

     /**
      *获取聊天室部落群聊列表
      *@param array $tribe_id
      */
     public function getTribeChatLists($tribe_id){
         $this->db->select("cc.*,t.logo,t.name");
         $this->db->where_in("cc.tribe_id",$tribe_id);
         $this->db->from("chat_channel as cc");
         $this->db->join("tribe as t","t.id = cc.tribe_id");
         return $this->db->get()->result_array();
     }
     
     /**
      *获取聊天室部落群聊列表
      *@param int $tribe_id 
      */
     public function getTribeChatList($tribe_id=0){
         if(!$tribe_id){
             return false;
         }
         $user_id = $this->session->userdata("user_id");
         $this->db->select("cc.*,t.logo,t.name");
         $this->db->where("cc.tribe_id",$tribe_id);
         $this->db->from("chat_channel as cc");
         $this->db->join("tribe as t","t.id = cc.tribe_id");
         return $this->db->get()->row_array();
     }
     
    /**
     *获取聊天室单聊列表 
     */
    public function getChatList($tribe_id=0){
        $user_id = $this->session->userdata("user_id");
        $this->db->select("cl.*");
        $this->db->where("cl.customer_id",$user_id);
        $this->db->where("cl.is_show",1);
        $this->db->from("chat_list as cl");
        if($tribe_id){
            $this->db->join("chat_message as cm",'cm.chat_channel_id = cl.chat_channel_id');
            $this->db->join("tribe_staff as ts","ts.customer_id = $user_id");
            $this->db->join("tribe_staff as tss","tss.customer_id = cm.from_customer_id");
            $this->db->where("ts.tribe_id",$tribe_id);
            $this->db->where("tss.tribe_id",$tribe_id);
            $this->db->group_by("cl.id");
        }
        $this->db->order_by("cl.update_at DESC");
        return $this->db->get()->result_array();
    }
    
    /**
     * 更新聊天室列表
     */
    public function updateList($customer_id,$chat_channel_id,$is_read = 1,$is_show = 1){
        if(!in_array($is_show,array(0,1))){
            return false;
        }
        if(!in_array($is_read,array(0,1))){
            return false;
        }
        $this->db->set("is_show",$is_show);
        $this->db->set("is_read",$is_read);//是否已阅读消息 1表示是，0表示否
        $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set("update_at",$date);
        $this->db->where("customer_id",$customer_id);
        $this->db->where("chat_channel_id",$chat_channel_id);
        $this->db->update('chat_list');
        $affect = $this->db->affected_rows();
        if($affect && $is_read == 1){
            $affect1 =  $this->updateAllReadLog($chat_channel_id,$customer_id);
            return true;
        }
        return $affect;
    }
    
   /**
    * 当进入聊天室 即把所有的不属于自己发的聊天记录都更新为已阅读
    */ 
   public function updateAllReadLog($chat_channel_id,$customer_id){
       $this->db->select("cm.id,crl.id as crl_id");
       $this->db->where("cm.chat_channel_id",$chat_channel_id);
       $this->db->where("cm.from_customer_id !=",$customer_id);
       $this->db->from("chat_message as cm");
       $this->db->where("cm.is_delete",0);//未删除
       $this->db->join("chat_read_log as crl","cm.id = crl.chat_message_id and crl.customer_id = $customer_id","left");
       $aff = $this->db->get()->result_array();
       if($aff){
           $date = date('Y-m-d H:i:s');// 当前时间
           foreach ($aff as $key => $val){
               if(!$val['crl_id']){
                   $info['chat_message_id'] = $val['id'];
                   $info['chat_channel_id'] = $chat_channel_id;
                   $info['customer_id'] = $customer_id;
                   $info['create_at'] = $date;
                   $this->insertRead_Log($info);
               }
           }
       }
       return $aff;
   } 
   
    
    /**
     * 创建聊天室列表记录
     */
   public  function createList($customer_id,$chat_channel_id, $is_show = 1 ){
       $date = date('Y-m-d H:i:s');// 当前时间
       $this->db->set("create_at",$date); 
       $this->db->set("update_at",$date);
       $this->db->set("customer_id",$customer_id);
       $this->db->set("is_show",$is_show);
       $this->db->set("chat_channel_id",$chat_channel_id);
       $this->db->insert("chat_list");
       $Chat_List_id = $this->db->insert_id();
       return $Chat_List_id;
   }
    
    /**
     * $data
     * 
     */
    public  function  loadChannelByCondition($data){
        
    }
    
    /**
     * 创建聊天记录
     * 必须要有发送人$data['from_customer_id'],$data['chat_channel_id']
     */
    public function createChatMessage($data){
        if(empty($data['from_customer_id']) || empty($data['chat_channel_id']) ){
            return false;
        }
        
        $this->db->set("from_customer_id",$data['from_customer_id']);
        $this->db->set("chat_channel_id",$data['chat_channel_id']);
        $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set("create_at",$date);
        
        if(!empty($data['message_type']) ){
            $this->db->set("message_type",$data['message_type']);
        }
        if(!empty($data['message']) ){
            $this->db->set("message",$data['message']);
        }
        if(!empty($data['message_url']) ){
            $this->db->set("message_url",$data['message_url']);
        }
       
        if(!empty($data['is_delete']) ){
            $this->db->set("is_delete",$data['is_delete']);
        }
        $this->db->insert("chat_message");
        $Msg_id = $this->db->insert_id();
        return $Msg_id;
    }
    
    
    /**
     *同时插入一条无效的信息
     */
    public  function  insertMsg($data){
        $this->db->insert('chat_message',$data);
        return $this->db->insert_id();
    }
    
    /**
     * 插入已阅读记录
     */
    public function insertRead_Log($data){
        $this->db->insert('chat_read_log',$data);
        return $this->db->insert_id();
    }
    
    /**
     * 查询聊天记录 获取聊天室ID(单聊)
     *
     */
    public function getChatChannel($select){
        $query = $this->db->query("
            select a.*,any_value(group_concat(b.customer_id)) as ids
            from 9thleaf_chat_channel  as  a
            join 9thleaf_chat_channel_member as b on a.id = b. chat_channel_id
            where b.customer_id in {$select}
            and a.tribe_id = 0
            and a.huanxin_group_id = 0
            group by a.id having COUNT(a.id) = 2
            ");
       return $query->row_array();
       
    }
    
    
    
}