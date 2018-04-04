<?php
/*
* mysql 单例
*/
class mysql{
    private $host    ='125.88.168.50'; //数据库主机
    private $user     = 'showuser'; //数据库用户名
    private $pwd     = 'show123qwe'; //数据库用户名密码
    private $database = 'show_test'; //数据库名
    private $charset = 'utf8'; //数据库编码，GBK,UTF8,gb2312
    private $link;             //数据库连接标识;
    private $rows;             //查询获取的多行数组
    static $_instance; //存储对象
    /**
     * 构造函数
     * 私有
     */
    private function __construct($pconnect = false) {
        if (!$pconnect) {
            $this->link = @ mysqli_connect($this->host, $this->user, $this->pwd, $this->database) or $this->err("hhhh");
        } else {
            $this->link = @ mysqli_pconnect($this->host, $this->user, $this->pwd, $this->database) or $this->err("yyyyy");
        }
        $this->query("SET NAMES '{$this->charset}'",$this->link);
        return $this->link;
    }
    /**
     * 防止被克隆
     *
     */
    private function __clone(){}

    public static function getInstance($pconnect = false){
        if(FALSE == (self::$_instance instanceof self)){
            self::$_instance = new self($pconnect);
        }
        return self::$_instance;
    }
    /**
     * 查询
     */
    public function query($sql, $link = '') {

        $this->result = mysqli_query($this->link,$sql) or $this->err($sql);
        return $this->result;
    }
    /**
     * 单行记录
     */
    public function getRow($sql, $type = MYSQL_NUM) {
       // error_log(($this->link?"link:":"unlink:").$sql);
        $result = mysqli_query($this->link,$sql) or $this->err($sql);
        return mysqli_fetch_array($result, $type);
    }
    /**
     * 多行记录
     */
    public function getRows($sql, $type = MYSQL_ASSOC) {
        //error_log(($this->link?"link:":"unlink:").$sql);
        $result = mysqli_query($this->link,$sql) or $this->err($sql);
        while ($row = mysqli_fetch_array($result, $type)) {
            $this->rows[] = $row;
           // error_log($row);
        }
        return $this->rows;
    }
    /**
     * 错误信息输出
     */
    protected function err($sql = null) {
        //这里输出错误信息
        error_log('error:'.$sql);
        exit();
    }
}
//用例
//$db = mysql::getInstance();

//$data = $db->getRows('select * from blog');

?>