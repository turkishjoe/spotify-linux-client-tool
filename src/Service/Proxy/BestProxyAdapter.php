<?php
/**
 * TODO:
 *
 */

namespace Service\Proxy;

use BestProxy\BestProxyClient;
use BestProxy\BestProxyException;
use BestProxy\Proxy;

class BestProxyAdapter implements ProxyProviderInterface
{
    /**
     *
     * @var BestProxyClient
     */
    private $bestProxyClient;

    /**
     * BestProxyProvider constructor.
     *
     * @param BestProxyClient $proxyClient
     */
    public function __construct(BestProxyClient $proxyClient)
    {
        $this->bestProxyClient = $proxyClient;
    }

    /**
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getProxy($options = [])
    {
        try {
            $proxies = $this->bestProxyClient->getProxyList(1, $options);

            if(empty($proxies[0])){
                throw new ProxyException("Proxy not found in provider");
            }

            $proxy = $proxies[0];
            $type = $this->getType($proxy);
            $proxyObject = new Proxy();
            $proxyObject->setType($type)
                ->setHost($proxy['ip'])
                ->setPort($proxy['port']);

            return $proxyObject;
        }catch (BestProxyException $exception){
            throw new ProxyException("Error getting proxy", 0, $exception);
        }
    }

    /**
     * @param $protocolArray
     *
     * @return null|string
     */
    protected function getType($protocolArray)
    {
        foreach (BestProxyClient::ALLOWED_TYPES as $type) {
            if (!empty($protocolArray[$type])) {
                return $type;
            }
        }

        return null;
    }
}