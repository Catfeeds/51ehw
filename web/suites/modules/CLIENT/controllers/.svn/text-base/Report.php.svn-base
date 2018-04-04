<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
include 'Util/Common.inc.php';
class Report extends Backend_Controller
{
    private $showfield = array(
        'pay_account_id' => '支付ID',
        'customer_id' => '用户ID',
        'customer_name' => '登录帐号',
        'app_name' => '分公司',
        'agent_id' => '合伙人ID',
        'agent_name' => '合伙人',
        'corporation_id' => '企业id',
        'corporation_name' => '企业名称',
        'M_credit' => '货豆实际余额',
        'credit' => '货豆授信余额',
        'cash' => '现金余额'
    );
    private $Mshowfield = array(
        'id' => '流水id',
        'order_no' => '单号',
        'created_at' => '时间',
        'beginning_balance' => '初始余额',
        'amount1' => '存入',
        'amount2' => '支出',
        'ending_balance' => '最终余额',
        'remark' => '备注'
    );
    private $Cshowfield = array(
        'id' => '流水id',
        'created_at' => '授信时间',
        'credit_start_time' => '开始时间',
        'credit_end_time' => '结束时间',
        'credit' => '授信金额',
        'remark' => '备注',
        'creditstatus' => '状态'
    );
    private $Cashshowfield = array(
        'cid' => '流水id',
        'charge_no' => '单号',
        'created_at' => '时间',
        'beginning_balance' => '期初余额',
        'cash1' => '存入',
        'cash2' => '支出',
        'ending_balance' => '最终余额',
        'remark' => '备注'
    );
    function __construct()
    {
        parent::__construct();
        $this->load->model("Report_mdl");
        $this->load->model("Customer_currency_log_mdl");
        $this->load->model("Customer_money_log_mdl");
        $this->load->model("Customer_credit_log_mdl");
        $this->load->model("Pay_account_mdl");
    }

    /**
     * 展示余额流水报表
     */
    function index()
    {
        $app_id=$this->session->userdata('app_info')['id'];
        if ($app_id == 0) {
            $data['app_info'] = $this->Report_mdl->app();
        }

        $data['fields'] = $this->showfield;
        foreach ($data['fields'] as $key => $val) {
            $fks[$key]['data'] = $key;
        }
        $fks['opter1']['data'] = null;
        $fks['opter1']['className'] = 'td-operation1';
        $fks['opter1']['defaultContent'] = '';
        $fks['opter2']['data'] = null;
        $fks['opter2']['className'] = 'td-operation2';
        $fks['opter2']['defaultContent'] = '';

        $fks = array_values($fks);
        $data['columns'] = json_encode($fks);

        $this->assign($data);
        $this->display('report/ticket_list_view');
    }


    public function action($parsedata='parsedata'){
        $params = $this->input->get();

        $data = $this->$parsedata($params,array('pagelist'=>1));
        $recordsFiltered = $this->$parsedata($params,array('total'=>1));


        $returndata = array(
            "draw" => intval(@$params['draw']),
            "total" => intval($recordsFiltered),
            "fieldsContent" => $data['fieldsContent']
        );

        if(!empty($data)){
            foreach ($data as $key=>$val) {
                $returndata[$key] = $val;
            }
        }

        echo json_encode($returndata,JSON_UNESCAPED_UNICODE);
    }


    /*列表处理数据输出*/
    private function parsedata($params=[],$condition=[]){
        $where =  $infos = $con = [];

        #搜索类型
        if(!empty($params['option'])){
            $coroption = array('agent_name','corporation_name','app_id');
            $where = array_intersect($coroption,array_keys($params['option']));
        }
        if(!empty($where)){
            $corData = $this->Report_mdl->get_report_data($params);
            if(is_array($corData) && !empty($corData)){
                $condition['customer_id'] = array_keys($corData);
                $infos =$this->Pay_account_mdl->getAccountlist($params,$condition);
            }
        }else{
            $infos = $this->Pay_account_mdl->getAccountlist($params,$condition);
            if(!isset($condition['total']) && !empty($infos)){
                if(isset($condition['pagelist'])){
                    $customerId = array_unique( array_column($infos,'customer_id'));
                    if($customerId) $con['customer_id'] = $customerId;
                }
                $corData = $this->Report_mdl->get_report_data([],$con);
            }
        }
        #print_r($infos);
        #print_r($corData);
        if(isset($condition['total'])){
            return $infos;
        }

        $fields = $this->showfield;

        $fks= array_keys($fields);
        if(!isset($condition['all'])){//传参
            $fks[] = 'id';
        }

        $fieldsContent = array();
        if(!empty($infos)){
            foreach($infos as $key=>$val){
                foreach ($fks as $fv){
                    if(in_array($fv,array('corporation_id', 'corporation_name', 'agent_id', 'agent_name','app_name'))){
                        $val[$fv] = $corData[$val['customer_id']][$fv]??'';
                    }
                    if(isset($condition['all'])){
                        $fieldsContent[$key][]=$val[$fv];
                    }else{
                        $fieldsContent[$key][$fv]=$val[$fv];
                    }
                }
            }
        }

        //获取实际授信总数
        $get_mtotal = $this->Pay_account_mdl->get_mtotal($params,$condition);

        $ehw_m = $ehw_cash  = 0;

        /*第一页第一行显示平台,搜索不用*/
        if($params['fuzzySearch'] != 'false'){//不查询的时候
            $uri = 'report/get_51ehw_m';
            //取51易货网货豆余额
            $ehw_m=$this->Customer_currency_log_mdl->get_51ehw_m();
            //获取51易货网现金余额
            $ehw_cash=$this->Customer_money_log_mdl->get_51ehw_c();

            if( $params['startIndex'] == 0 || isset($condition['all'])){//列表第一页或者导出是显示平台信息
                $row_app = array(
                    array(
                        'pay_account_id' => '',
                        'customer_id' => '',
                        'customer_name' => '',
                        'app_name' => $this->session->userdata('app_info')['app_name'],
                        'agent_id' => '',
                        'agent_name' => '',
                        'corporation_id' => '',
                        'corporation_name' => '51易货网',
                        'M_credit' => $ehw_m,
                        'credit' => '',
                        'cash' => $ehw_cash
                    )
                );
                $fieldsContent = array_merge($row_app, $fieldsContent);
            }


        }

        if(isset($condition['all'])){
            $total = array(
                array(
                    'pay_account_id' => '',
                    'customer_id' => '',
                    'customer_name' => '',
                    'app_name' => '',
                    'agent_id' => '',
                    'agent_name' => '',
                    'corporation_id' => '',
                    'corporation_name' => '合计:',
                    'M_credit' => $get_mtotal['mcredit']+$ehw_m,
                    'credit' => $get_mtotal['credit']??0,
                    'cash' => $get_mtotal['cash']+$ehw_cash
                )
            );

            $fieldsContent = array_merge($fieldsContent,$total);
            foreach($fieldsContent as $key=>$val){
                $allarr[$key]= array_values($val);
            }
            #print_r($fieldsContent);
            $data = array(
                'filename' => '余额及流水报表',
                'fis' => array_values($fields),
                'fieldsContent' => $allarr
            );
        }else{
            $data['fieldsContent'] = $fieldsContent;
            $data['mcredit']=$get_mtotal['mcredit']+$ehw_m;
            $data['credit']=$get_mtotal['credit'];
            $data['cash']=$get_mtotal['cash']+$ehw_cash;
        }
        return $data;
    }



    /*导出余额及流水报表*/
    public function export(){
        $params = $this->input->get();
        $data = $this->parsedata($params, array('all'=>1));
        $this->load->library('User_PHPExcel');
        $this->user_phpexcel->push($data['filename'],$data['fis'],$data['fieldsContent']);
    }

    public function  get_m_detailed($id){
        if($this->app_id == 0){
            $data['id'] = $id ;
            $this->load->model("Report_mdl");
            if($id>0){
                $data['credit']=$this->Pay_account_mdl->m_balance($id);
                $data['showparams'] = $data['credit']['M_credit'];
            }else{
                //取51易货网货豆余额
                $data['ehw_m']=$this->Customer_currency_log_mdl->get_51ehw_m();
                $data['showparams'] = $data['ehw_m'];
            }
            $this->assign($data);
            $this->display('report/coupons');
        }else{
            return show_message2('您没有权限或错误数据（没有用户或用户没有绑定企业!）', 'report',4);
        }
    }


    /**
     * M卷实际余额页面
     */
    public function MActual($id,$mcredit)
    {
        $this->load->model("Report_mdl");
        $data['mcredit']=$mcredit;
        $data['fields'] = $this->Mshowfield;
        foreach ($data['fields'] as $key => $val) {
            $fks[$key]['data'] = $key;
            if(in_array($key,array('amount1','amount2','remark'))){
                $fks[$key]['orderable'] = false;
            }
        }
        $fks = array_values($fks);
        $data['columns'] = json_encode($fks);


        $data['id'] =$id;
        $this->assign($data);
        $this->template('report/mactual');
    }

    /**
     * 获取M卷实际余额
     */
    public function getMActual($id){
        $params = $this->input->get();
        $this->load->model("Report_mdl");
        $params['id'] = @$id;

        $infos = $this->parseMdata($params);
        $recordsFiltered = $this->parseMdata($params,array('total'=>1));
        #print_r($infos);
        $returndata = array(
            "draw" => intval(@$params['draw']),
            "total" => intval($recordsFiltered),
            "pageData" => $infos,

        );
        echo json_encode($returndata,JSON_UNESCAPED_UNICODE);
    }

    /*导出货豆实际余额报表*/
    public function exportM($id){
        $params = $this->input->get();
        $params['id'] = @$id;
        $data = $this->parseMdata($params,array('all'=>1));
        $this->load->library('User_PHPExcel');
        $this->user_phpexcel->push($data['filename'],$data['fis'],$data['fieldsContent']);
    }

    /*列表处理数据输出*/
    private function parseMdata($params,$condition=[]){
        $infos=$this->Customer_currency_log_mdl->actual($params,$condition);
        if(isset($condition['total'])){
            return $infos;
        }
        $fields = $this->Mshowfield;
        foreach ($fields as $key => $val) {
            $fks[] = $key;
            $fis[] = $val;
        }

        $fieldsContent = array();
        foreach($infos as $key=>$val){
            foreach ($fks as $fv){
                if($fv == 'amount1'){
                    if($val['type'] == 1){
                        $val[$fv] = $val['amount'];
                    }else{
                        $val[$fv] = '';
                    }
                }
                if($fv == 'amount2'){
                    if($val['type'] == 2){
                        $val[$fv] = $val['amount'];
                    }else{
                        $val[$fv] = '';
                    }
                }
                if(isset($condition['all'])){
                    $fieldsContent[$key][]=$val[$fv];
                }else{
                    $fieldsContent[$key][$fv]=$val[$fv];
                }
            }
        }


        if(isset($condition['all'])){
            $data = array(
                'filename' => '货豆实际余额报表',
                'fis' => $fis,
                'fieldsContent' => $fieldsContent
            );
            return $data;
        }else{
            return $fieldsContent;
        }
    }






    public function CreditActual($id,$credit)
    {
        $this->load->model("Report_mdl");
        $data['credit']=$credit;
        $data['id'] =$id;
        $data['fields'] = $this->Cshowfield;
        foreach ($data['fields'] as $key => $val) {
            $fks[$key]['data'] = $key;
        }

        $fks = array_values($fks);
        $data['columns'] = json_encode($fks);

        $this->assign($data);
        $this->template('report/creditactual');
    }

    /**
     * 获取授信
     */
    public function getCreditActual($id){
        $params = $this->input->get();
        $this->load->model("Report_mdl");
        $params['id'] = @$id;

        $infos=$this->Customer_credit_log_mdl->get_credit($params);
        $recordsFiltered=$this->Customer_credit_log_mdl->get_credit($params,array('total'=>1));

        $fields = $this->Cshowfield;
        $fks = array_keys($fields);
        $fieldsContent = array();
        if(!empty($infos)){
            foreach($infos as $key=>$val){
                foreach ($fks as $fv){
                    if($fv == 'creditstatus'){
                        if($val[$fv] == '授信到期'){
                            $val[$fv] = "<span style='color:red'>$val[$fv]</span>";
                        }
                    }
                    $fieldsContent[$key][$fv]=$val[$fv];
                }
            }
        }



        #print_r($infos);
        $returndata = array(
            "draw" => intval(@$params['draw']),
            "total" => intval($recordsFiltered),
            "pageData" => $fieldsContent,

        );
        echo json_encode($returndata,JSON_UNESCAPED_UNICODE);
    }


    /*导出授信报表*/
    public function exportCredit($id){
        $params = $this->input->get();
        $params['id'] = @$id;

        $infos=$this->Customer_credit_log_mdl->get_credit($params,array('all'=>1));

        $filename = '授信报表';
        $fields = $this->Cshowfield;
        foreach ($fields as $key => $val) {
            $fks[] = $key;
            $fis[] = $val;
        }

        $fieldsContent = [];
        if(!empty($infos)){
            foreach($infos as $key=>$val){
                foreach ($fks as $fv){
                    $fieldsContent[$key][]=$val[$fv];
                }
            }
        }


        require_once APPPATH.'libraries/PHPExcel.php';
        require_once APPPATH.'libraries/PHPExcel/Writer/Excel2007.php';
        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        header("Content-type:application/vnd.ms-excel");  //设置内容类型
        header("Content-Disposition:attachment;filename=data.xls");  //文件下载
        #设置当前的sheet
        $objPHPExcel->setActiveSheetIndex(0);
        #设置sheet的name
        $objPHPExcel->getActiveSheet()->setTitle($filename);

        //表头
        foreach ($fis as $pColumn => $val) {
            $c = PHPExcel_Cell::stringFromColumnIndex($pColumn);
            #设置底色
            $objPHPExcel->getActiveSheet()->getStyle($c . 1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('feeecd');
            $objPHPExcel->getActiveSheet()->setCellValue($c . 1, $val);
        }


        //数据
        if(!empty($fieldsContent)){
            foreach ($fieldsContent as $row => $val) {
                foreach ($val as $col => $v) {
                    $r = $row+2;
                    $c = PHPExcel_Cell::stringFromColumnIndex($col);
                    $objPHPExcel->getActiveSheet()->setCellValue($c .$r, $v);
                    if($col == 5 ){
                        if($v == '授信到期'){
                            $objPHPExcel->getActiveSheet()->setCellValue($c .$r, $v);
                            $objPHPExcel->getActiveSheet()->getStyle($c . $r)->getFont()->getColor()->setARGB('#ff0000');
                        }
                    }

                }
            }

        }

        $fieldnames = $filename.date('Ymihis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fieldnames.'.xls"');
        header('Cache-Control: max-age=0');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter->save('php://output'); //文件通过浏览器下载

    }



    /*现金列表处理数据输出*/
    private function parseCdata($params,$condition=[]){
        $infos=$this->Customer_money_log_mdl->cash($params,$condition);
        if(isset($condition['total'])){
            return $infos;
        }
        $fields = $this->Cashshowfield;
        foreach ($fields as $key => $val) {
            $fks[] = $key;
            $fis[] = $val;
        }

        $fieldsContent = array();
        foreach($infos as $key=>$val){
            foreach ($fks as $fv){
                if($fv == 'cash1'){
                    $val[$fv] = ($val['type'] == 1) ? $val['cash'] : '-';
                }
                if($fv == 'cash2'){
                    $val[$fv] = ($val['type'] == 2) ? $val['cash'] : '-';
                }
                if(isset($condition['all'])){
                    $fieldsContent[$key][]=$val[$fv];
                }else{
                    $fieldsContent[$key][$fv]=$val[$fv];
                }
            }
        }


        if(isset($condition['all'])){
            $data = array(
                'filename' => '现金报表',
                'fis' => $fis,
                'fieldsContent' => $fieldsContent
            );
            return $data;
        }else{
            $data['fieldsContent'] = $fieldsContent;
            return $data;
        }
    }


    /*导出现金详细信息*/
    public function exportCash(){
        $params = $this->input->get();
        $data = $this->parseCdata($params,array('all'=>1));
        $this->load->library('User_PHPExcel');
        $this->user_phpexcel->push($data['filename'],$data['fis'],$data['fieldsContent']);
    }


    /**
     * 现金页面
     */
    function cash($id,$cash){
        if($this->app_id ==0){
            $data['id']=$id;
            $data['cash']=$cash;

            $data['fields']  = $this->Cashshowfield;;
            foreach ($data['fields'] as $key => $val) {
                $fks[$key]['data'] = $key;
            }

            $fks = array_values($fks);
            $data['columns'] = json_encode($fks);

            $this->assign($data);
            $this->display('report/cash');
            $this->load->view ( 'footertable' );

        } else{
            return show_message2('您没有权限', 'report',4);
        }
    }

    /**
     * 获取现金详细信息
     */
    function get_cash($id){
        $params = $this->input->get();
        $this->load->model("Report_mdl");
        $params['id'] = $id;
        $infos=$this->Customer_money_log_mdl->cash($params);
        $recordsFiltered=$this->Customer_money_log_mdl->cash($params,array('total'=>1));
        $returndata = array(
            "draw" => intval(@$params['draw']),
            "total" => intval($recordsFiltered),
            "pageData" => $infos,

        );
        echo json_encode($returndata,JSON_UNESCAPED_UNICODE);
    }





}

