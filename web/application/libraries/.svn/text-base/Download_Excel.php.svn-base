<?php 
include_once 'PHPExcel.php';
/**
 * 导出EXCEL 操作类。
 */

class Download_Excel{ 
    
    /**
     * 拼装
     * @param array $title
     * @param array $data
     * @param array $row_width
     */
    public function Download($title,$data,$filename='order.xls',$row_width=array(),$center_array= array() , $string = array() )
    { 
        $result = array_merge_recursive($title,$data);
        
        if( is_array($result) )
        { 
            $this->create_xls($result,$filename,$row_width,$center_array,$string);
        }
    }
    
    /**
     * 执行
     * @param unknown $data 数据
     * @param string $filename 文件名
     * @param string $row_width 设置列宽
     * @param string $center_array 设置居中方式
     * @param string $string 科学计算法转为字符串
     * 
     */
    public function create_xls( $data,$filename='simple.xls',$row_width= array() ,$center_array= array() , $string = array() ){
        ini_set('max_execution_time', '0');
        $filename=str_replace('.xls', '', $filename).'.xls';
        $phpexcel = new PHPExcel();
        $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
        $objActSheet = $phpexcel->getActiveSheet();
        
        if( $string ){
            foreach ($string as $k => $v) //将科学计算法转为字符串的列
            {
                
                $objActSheet->getStyle($v)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            }
        }
        
        if( $center_array ){ //需要居中的列
            
            foreach ($center_array as $k => $v){
                $objStyleA1 = $objActSheet->getStyle($k);
                $objAlignA1 = $objStyleA1->getAlignment();
                
                if($v == 0){ //左右居中的列
                    $objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中
                }else{ 
                    $objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中
                }
            }
        }
        
        $phpexcel->getActiveSheet()->fromArray($data);
        $phpexcel->getActiveSheet()->setTitle('易货网');
        $phpexcel->setActiveSheetIndex(0);
        
        foreach ($row_width as $k => $v)
        {   
            $phpexcel->getActiveSheet()->getColumnDimension($k)->setWidth($v);
            
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
        $objwriter->save('php://output');
        exit;
    }
    
}
?>