<?php
namespace dubbo;

require_once "../invok/cluster.php";
require_once "../invok/invoker.php";
use \dubbo\invok\Cluster;
use dubbo\invok\Invoker;

class Register
{

    public $config = array(
        'registry_address' => 'localhost:2181'
    );

    public $zookeeper = null;

    protected $ip;

    protected $providersCluster;

    public static $ServiceMap = array();

    protected $acl = array(
        array(
            'perms' => \Zookeeper::PERM_ALL,
            'scheme' => 'world',
            'id' => 'anyone'
        )
    );

    /**
     * 需要提交的参数
     * @var unknown
     */
    private $opt = array(
        "side" => "provider",
        "dubbo" => "2.0.0",
        "group" => "annotationConfig",
        "category" => "providers",
        "organization" => "9thleaf",
        "owner" => '9thleaf',
        'server' => 'nginx',
        'anyhost' => 'true',
        'accepts' => '500'
    );

    public function __construct($options = array())
    {
        $this->config = array_merge($this->config, $options);
        $this->ip = $_SERVER['SERVER_ADDR'];
        $this->providersCluster = Cluster::getInstance();
        $this->zookeeper = $this->getZookeeper($this->config['registry_address']);
    }

    public function getZookeeper($registry_address)
    {
        return new \Zookeeper($registry_address);
    }

    public function subscribe($invokDesc)
    {
        $desc = $invokDesc->toString();
        $serviceName = $invokDesc->getService();

        $path = $this->getSubscribePath($serviceName);
        //获取服务下的所有提供者
        $children = $this->zookeeper->getChildren($path);
        if (count($children) > 0) {
            //遍历提供者
            foreach ($children as $key => $provider) {
                $provider = urldecode($provider);
                $this->methodChangeHandler($invokDesc, $provider);
            }
            $this->configurators();
        }
    }

    public function register($invokDesc, $invoker)
    {
        $desc = $invokDesc->toString();
        if (! array_key_exists($desc, self::$ServiceMap)) {
            self::$ServiceMap[$desc] = $invoker;
        }
        $this->subscribe($invokDesc);
        $providerHost = $this->providersCluster->getProvider($invokDesc);
        $invoker->setHost(Invoker::genDubboUrl($providerHost, $invokDesc));
        print_r($invokDesc->getService() . "<br/>");
        $registerPath = $this->getRegistryPath($invokDesc->getService());
        print_r($registerPath);
        $this->zookeeper->create($registerPath, null, $this->acl, null);
        return true;
    }

    public function methodChangeHandler($invokerDesc, $provider)
    {
        $schemeInfo = parse_url($provider);
        $providerConfig = array();
        parse_str($schemeInfo['query'], $providerConfig);

        $group = isset($providerConfig['group']) ? $providerConfig['group'] : NULL;
        $version = isset($providerConfig['version']) ? $providerConfig['version'] : NULL;
        if ($invokerDesc->isMatch($group, $version)) {
            $this->providersCluster->addProvider($invokerDesc, 'http://' . $schemeInfo['host'] . ':' . $schemeInfo['port'], $schemeInfo['scheme']);
        }
    }

    public function getInvoker($invokerDesc)
    {
        $desc = $invokerDesc->toString();
        return isset(self::$ServiceMap[$desc]) ? self::$ServiceMap[$desc] : NULL;
    }

    public function configurators()
    {
        return true;
    }

    protected function getSubscribePath($serviceName)
    {
        return '/dubbo/' . $serviceName . '/providers';
    }

    protected function getRegistryAddress()
    {
        return $this->config['registry_address'];
    }

    protected function getRegistryPath($serviceName, $application = array())
    {
        $params = http_build_query($application);
        $url = '/dubbo/' . $serviceName . '/providers/' . urlencode('http://' . $this->ip . '/' . $serviceName . '?category=providers&interface=' . $serviceName . $params);
        return $url;
    }

    protected function getConfiguratorsPath($serviceName)
    {
        return '/dubbo/' . $serviceName . '/configurators';
    }

    protected function getProviderTimeout()
    {
        return $this->config['providerTimeout'] * 1000;
    }

    public function zkinfo($invokerDesc)
    {
        echo $this->getRegistryPath($invokerDesc->getService());
        var_dump($this->providersCluster->getProviders());
        var_dump($this->providersCluster);
    }
}

?>