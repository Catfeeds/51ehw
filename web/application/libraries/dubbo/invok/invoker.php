<?php

namespace dubbo\invok;
use \dubbo\invok\Cluster;

abstract class Invoker{
    protected $invokerDesc;
    protected $url;
    protected $id;
    protected $debug;
    protected $notification = false;
    protected $cluster;

    /**
     *
     * @param unknown $url
     * @param string $debug
     */
    public function __construct($url=null, $debug=false) {
        // server URL
        $this->url = $url;
        $this->id = 1;
        $this->debug;
        $this->cluster = Cluster::getInstance();
    }

    /**
     *
     * @param unknown $notification
     */
    public function setRPCNotification($notification) {
        empty($notification) ?
            $this->notification = false
            :
            $this->notification = true;
    }

    /**
     *
     */
    public function getCluster(){
        return $this->cluster;
    }

    /**
     *
     * @param unknown $url
     */
    public function setHost($url){
        $this->url = $url;
    }

    /**
     *
     * @param unknown $host
     * @param unknown $invokerDesc
     */
    public static function genDubboUrl($host,$invokerDesc){
        return $host.'/'.$invokerDesc->getService();
    }

    /**
     *
     */
    public function toString(){
        return  __CLASS__;
    }

    /**
     *
     * @param unknown $name
     * @param unknown $arguments
     */
    abstract public function __call($name,$arguments);
}

