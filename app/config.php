<?php

use function DI\create;
use BestProxy\BestProxyClient;
use Psr\Container\ContainerInterface;

return [
    \Matomo\Ini\IniReader::class=>function(){
        return new \Matomo\Ini\IniReader();
    },
    BestProxyClient::class=>function(){
        return new BestProxyClient( getenv('BEST_PROXY_API_KEY'));
    },
    \Service\Proxy\ProxyProviderInterface::class=>function(ContainerInterface $container){
        return new \Service\Proxy\BestProxyAdapter(
            $container->get(BestProxyClient::class)
        );
    }
];
