<?php
/**
 * 消息处理类
 * @author LincolnZhou<875199116@qq.com> 2016-03-12
 */
class MessageHandler
{
    /**
     * @param Douyu_Socket $socket socket对象
     * @param string $content 发送内容
     */
    public static function send($socket, $content)
    {
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();

        $socket->send($byte, $length);
    }

    /**
     * @param Douyu_Socket $socket socket对象
     * @return string
     */
    public static function receive($socket)
    {
        return $socket->read();
    }
}