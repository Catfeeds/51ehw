<?php
namespace dubbo\invok;

class Cluster{
    protected static $providerMap = array();
    private static $_instance;

    private function __construct(){

    }

    private function __clone(){

    }

    /**
     *
     */
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *
     * @param unknown $invokerDesc
     * @param unknown $host
     * @param unknown $schema
     */
    public function addProvider($invokerDesc,$host,$schema){
        $desc = $invokerDesc->toString();
        $this->providerMap[$desc][] = $host;
    }

    /**
     *
     * @param unknown $invokerDesc
     */
    public function getProvider($invokerDesc){
        $desc = $invokerDesc->toString();
        echo "<br /> DESC：";
        print_r($desc);
        echo "<br />";
        print_r(Cluster::$providerMap);
        echo "<br />";
        $returns = isset(Cluster::$providerMap[$desc])?Cluster::$providerMap[$desc]:array();
        $key = array_rand($returns);
        return isset($returns[$key])?$returns[$key]:NULL;
    }

    /**
     *
     */
    public function getProviders(){
        return $this->providerMap;
    }

}
