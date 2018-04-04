<?php  
class Copygoods
{
    /**
     * 上传文件
     * @param $filepath 上传的文件路径（全路径）(必选)
     * @param $url 服务器的上传方法(必选)
     * @param $type 类型(可选)
     * @param $new_name 上传后的文件名 (可选)
     */
    function execUpload($filePath,$url,$type='image/png',$new_name=null){

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
            
}

?>