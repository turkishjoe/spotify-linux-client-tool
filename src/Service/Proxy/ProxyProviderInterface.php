<?php
/**
 * TODO:
 *
 */

namespace Service\Proxy;


interface ProxyProviderInterface
{
    public function getProxy($options = []);
}