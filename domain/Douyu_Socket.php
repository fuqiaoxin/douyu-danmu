<?php
/**
 * 斗鱼Socket类
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
class Douyu_Socket
{
    private $socket;

    /**
     * Douyu_Socket constructor.
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            screen_print('Socket创建失败');
        }

        $result = socket_connect($socket, $host, $port);
        if (!$result) {
            screen_print(sprintf('Socket无法连接-%s:%s', $host, $port));
        }

        $this->socket = $socket;
    }

    /**
     * 发送数据
     * @param $msg
     * @param $length
     */
    public function send($msg, $length)
    {
        socket_write($this->socket, $msg, $length);
    }

    /**
     * 读取数据
     * @return string
     */
    public function read()
    {
        return socket_read($this->socket, 1024);
    }

    /**
     * 关闭连接
     */
    public function close()
    {
        socket_close ($this->socket);
    }
}