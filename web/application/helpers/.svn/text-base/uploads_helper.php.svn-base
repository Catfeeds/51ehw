<?php  

    /**
     * Curl上传文件
     * @param $filepath 上传的文件路径（全路径）(必选)
     * @param $url 服务器的上传方法(必选)
     * @param $type 类型(可选)
     * @param $new_name 上传后的文件名 (可选)
     */
    function CurlUpload($filePath,$url,$type='image/png',$new_name=null){

        if(!file_exists($filePath)){
            echo "文件不存在";exit;
        } 
        
        if(!preg_match('/^(http:\/\/|https:\/\/)[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$url)){
            echo "http://地址错误";exit;
        }

        $ch = curl_init();  
        
        if (class_exists('\CURLFile')) {//php>5.4  
            $post_data = array('file' => new \CURLFile($filePath,$type,$new_name));
            $post_data['name'] = $new_name;
            
        } else {  
            $post_data = array('file' => '@' . $filePath); 
        }  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36 SE 2.X MetaSr 1.0');
        curl_setopt($ch,CURLOPT_REFERER,'HTTP://www.51ehw.com');
        curl_setopt($ch, CURLOPT_HEADER, false);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);  
        curl_setopt($ch, CURLOPT_URL, $url);//正式服务器处理上传  
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($filePath)); //这句非常重要，告诉远程服务器，文件大小    
        $info= curl_exec($ch);  
        curl_close($ch); 
    }  
    
    /**
     * 单图片。
     * @param $filepath 上传的文件路径（全路径）(必选)
     * @param $new_name 上传后的文件名 (可选)
     * @param $img_size 上传图片的大小 (可选) 单位M;
     * @param $field    上传表单的字段 (可选) 
     * 
     */
    function file_upload( $filePath,$new_name=null,$img_size = 2,$field="file"){
        if (empty($_FILES)){
            return false;
        }
    
        $filePath = trim($filePath,"/");
    
        $CI =& get_instance();
        $CI->load->helper("ps_helper");
        $CI->load->library('upload');
    
        $filePath = UPLOAD_PATH . $filePath;//保存路径
        if (! file_exists($filePath)){
            mkdirsByPath($filePath);
        }
    
        $config['file_name'] = empty( $new_name ) ? date("YmdHis") : $new_name;
        $config['upload_path'] = $filePath;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 1024 * $img_size;
        //         $config['max_filename'] = '50';
    
        $CI->upload->initialize($config);
        
        if ($CI->upload->do_upload($field)) 
        {
            return $CI->upload->data();
        }
    
        return false;
    
    }
    
    
    /**
     * 多图片上传。
     * @param $filepath 上传的文件路径（全路径）(必选)
     * @param $img_size 上传图片的大小 (可选) 单位M;
     * @param $field    上传表单的字段 (可选)
     *
     */
    function complex_file_upload( $filePath,$img_size = 2,$field="file"){
        $return = array();
        if(!empty($_FILES[$field]["name"][0])){
            $filePath = trim($filePath,"/");
            $CI =& get_instance();
            $CI->load->helper("ps_helper");
            $CI->load->library('upload');
            $filePath = UPLOAD_PATH . $filePath;//保存路径
            if (! file_exists($filePath)){
                mkdirsByPath($filePath);
            }
            
            $count=count($_FILES[$field]["name"]);//图片数量
            for($i=0;$i<$count;$i++){

                $field_name = $_FILES[$field]['name'][$i]. '_' . $i;
                $_FILES[$field_name] = array(
                        'name' => $_FILES["file"]['name'][$i],
                        'size' => $_FILES["file"]['size'][$i],
                        'type' => $_FILES["file"]['type'][$i],
                        'tmp_name' => $_FILES["file"]['tmp_name'][$i],
                        'error' => $_FILES["file"]['error'][$i]
                );

                $config['file_name'] =  date("YmdHis");
                $config['upload_path'] = $filePath;
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 1024 * $img_size;
                
                $CI->upload->initialize($config);
                
                if ($CI->upload->do_upload($field_name) && $images = $CI->upload->data())
                {
                        $return[] = $images;
                    
                }else{
                    return array();
                }
            }
        }
        
        return $return;
        
        
        
//         $config['file_name'] =  date("YmdHis");
//         $config['upload_path'] = $filePath;
//         $config['allowed_types'] = 'gif|jpg|png|jpeg';
//         $config['max_size'] = 1024 * $img_size;
//         //         $config['max_filename'] = '50';
        
//         $CI->upload->initialize($config);
        
//         if ($CI->upload->do_upload($field))
//         {
//             return $CI->upload->data();
//         }
        
//         return false;
        
    }
    
    
    function base_upload( $base64_img,$new_file_name,$save_path )
    { 
        $return['status'] = false;
       
        $up_dir = UPLOAD_PATH.$save_path;//存放在当前目录的upload文件夹下
        
        if( !file_exists($up_dir) )
        {
            mkdir($up_dir,0777);
        }
        
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png') ) )
            {
                $new_file = $up_dir.$new_file_name.'.'.$type;
                 
                if( file_put_contents( $new_file, base64_decode( str_replace($result[1], '', $base64_img) ) ) )
                {
                    $img_path = str_replace('../../..', '', $new_file);
        
                    $return['status'] = 1;
                    $return['data']['img_path'] = IMAGE_URL.$save_path.$new_file_name.'.'.$type;
                    $return['data']['img_name'] = $new_file_name.'.'.$type;;
        
                }else{
                    $return['status'] = 2;
        
                }
            }else{
                //文件类型错误
                $return['status'] = 3;
            }
        
        }else{
            //文件错误
            $return['status'] = 4;
        }
        
        
        return $return;
    }

?>