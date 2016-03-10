<?php
/**
 * 服务器信息类
 */
class ServerInfo
{
    /**
     * 主机地址
     * @var string
     */
    private $host;

    /**
     * 端口
     * @var int
     */
    private $port;

    /**
     * ServerInfo constructor.
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * getHost
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * getPort
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
}