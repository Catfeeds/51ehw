<?php
class Downloadimage
{
    
    /**
     * 下载微信头像到本地
     * 图片地址 $url
     * 用户ID $user_id
     * $type 文件夹   保存到哪个文件夹
     */
    public function download_weixin($url = '',$user_id = 0,$type = ''){
         
        $ext=".jpg";//以jpg的格式结尾
        clearstatcache();//清除文件缓存
        if(trim($url)==''){
            error_log('无效的图片路径');
        }
        
        if(empty($user_id) || !$user_id){
            echo '用户ID不能为空';exit;
        }
        $fileName=$user_id."_".time().$ext;
        $save_path = "uploads/".$type."/";
        //头像保存路径
        $path = FCPATH . UPLOAD_PATH.$save_path;
        //创建保存目录
        if (! file_exists($path))
            mkdir(iconv("UTF-8", "GBK", $path),0777,true);
             
            $ch=curl_init();
            $timeout=3;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
    
            $size=strlen($img);
            //文件大小
            //         var_dump("文件大小:".$size);exit;
            $fp2=@fopen($path.$fileName,'a');
            fwrite($fp2,$img);
            fclose($fp2);
            unset($img,$url);
            //         echo '<pre>';
            //         print_r(array('file_name'=>$fileName,'save_path'=>$path.$fileName,'error'=>0));
            return array('file_name'=>$save_path.$fileName,'save_path'=>$path.$fileName,'error'=>0);
    }
}