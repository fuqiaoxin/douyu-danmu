<?php
/**
 * 请求构造类
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
class Request
{
    /**
     * 登录服务器
     * @param array $serverList 服务器列表
     * @param $roomId
     * @return string
     */
    public static function serverLogin($serverList, $roomId)
    {
        $serverInfo = $serverList[rand(0, count($serverList) - 1)]; //随机返回一个服务器

        screen_print(sprintf('登录服务器-%s:%s', $serverInfo->getHost(), $serverInfo->getPort()));

        $socket = new Douyu_Socket('119.90.49.106', '8028');
        $devid = str_replace(array('{', '-', '}'), '', guid());
        $rt = time();
        $vk = md5($rt . "7oE9nPEG9xXV69phU31FYCLUagKeYtsF" . $devid);
        $content = sprintf('type@=loginreq/username@=/ct@=0/password@=/roomid@=%s/devid@=%s/rt@=%s/vk@=%s/ver@=20150929/', $roomId, $devid, $rt, $vk);
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();

        $socket->send($byte, $length);
        $loginResource = $socket->read(); //返回的是匿名用户信息，没有多大用
        $danmuResource = $socket->read();

        $content = sprintf('type@=qrl/rid@=%s/', $roomId);
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);
        $socket->read();

        $content = sprintf('type@=keeplive/tick@=%s/vbw@=0/k@=25a12ca8b802f40cf9c30c29ce54bc2c/', time());
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);
        $socket->read();

        screen_print(sprintf('登录服务器-%s:%s成功', $serverInfo->getHost(), $serverInfo->getPort()));

        return $danmuResource;
    }

    /**
    /**
     * 登录弹幕服务器
     * @param array $danmuServerList 弹幕服务器列表
     * @param $roomId
     */
    public static function danmuServerLogin($danmuServerList, $roomId, $danmuResource)
    {
        $danmuServerInfo = $danmuServerList[rand(0, count($danmuServerList) - 1)]; //随机返回一个服务器

        screen_print(sprintf('登录弹幕服务器-%s:%s', $danmuServerInfo->getHost(), $danmuServerInfo->getPort()));

        $socket = new Douyu_Socket($danmuServerInfo->getHost(), $danmuServerInfo->getPort());
        $content = sprintf('type@=loginreq/username@=3378738/password@=1234567890123456/roomid@=%s/', $roomId);
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);

        screen_print(sprintf('登录弹幕服务器-%s:%s成功', $danmuServerInfo->getHost(), $danmuServerInfo->getPort()));

        $groupId = ResponseParser::parserGroupId($danmuResource);
        $content = sprintf('type@=joingroup/rid@=%s/gid@=%s/', $roomId, $groupId);

        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);

        return $danmuServerInfo;
    }

    public static function joinGroup($danmuServerInfo, $roomId, $groupId)
    {
        $socket = new Douyu_Socket($danmuServerInfo->getHost(), $danmuServerInfo->getPort());
        $content = sprintf('type@=joingroup/rid@=%s/gid@=%s/', $roomId, $groupId);

        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);
        var_dump($socket->read());

        $content = sprintf('type@=keeplive/tick@=%s/', time());
        $message = new Message($content);
        $byte = $message->getByte();
        $length = $message->getLength();
        $socket->send($byte, $length);
    }

    public static function keepLive($danmuServerInfo)
    {
        $socket = new Douyu_Socket($danmuServerInfo->getHost(), $danmuServerInfo->getPort());

        var_dump($socket->read());
    }
}