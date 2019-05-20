<?php
/**
 * TODO:
 *
 */

namespace Service\Spotify;

use BestProxy\Proxy;
use Matomo\Ini\IniReader;
use Service\Proxy\ProxyException;
use Service\Proxy\ProxyProviderInterface;

class SpotifyManager
{
    private $proxyProvider;
    private $iniReader;

    public function __construct(ProxyProviderInterface $proxyProvider, IniReader $iniReader)
    {
        $this->proxyProvider = $proxyProvider;
        $this->iniReader = $iniReader;
    }

    public function changeProxy($fileName, $options = []){
        $proxy = $this->proxyProvider->getProxy($options);

        if (!is_null($proxy)) {
            $array = $this->iniReader->readFile($fileName);
            $dateTime = new \DateTime();
            $backupFileName = $fileName . '.backup' . $dateTime->format('Y_m_d_h_i_s');
            copy($fileName, $backupFileName);
            $array['network.proxy.addr'] = $this->toSpotifyUrl($proxy);
            $this->createIniFile($fileName, $array);
        }else{
            throw new ProxyException;
        }
    }

    private function encodeValue($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_string($value)) {
            return "\"$value\"";
        }
        return $value;
    }

    /**
     *
     * @param string $backupFileName
     * @param array $array
     * @return void
     */
    protected function createIniFile(string $backupFileName, array $array)
    {
        $file = fopen($backupFileName, 'w');
        foreach ($array as $key => $value) {
            $str = sprintf("%s=%s\n", $key, $this->encodeValue($value));
            fputs($file, $str);
        }

        fclose($file);
    }

    /**
     * TODO:
     *
     * @return string
     */
    protected function toSpotifyUrl(Proxy $proxy){
        return $proxy->toUrl() . '@' . $this->getSpotifyType($proxy);
    }

    /**
     * TODO:
     *
     * @return bool|int|string
     */
    protected function getSpotifyType(Proxy $proxy){
        $type = $proxy->getType();
        if($type = 'https' || $type = 'http'){
            return 'http';
        }

        return $type;
    }
}