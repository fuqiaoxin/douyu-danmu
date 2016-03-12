<?php
/**
 * 请求构造类
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
class Request
{
    /**
     * 登录服务器
     * @param int $roomId 房间号
     * @return string
     */
    public static function serverLogin($roomId)
    {
        $devid = str_replace(array('{', '-', '}'), '', guid());
        $rt = time();
        $vk = md5($rt . "7oE9nPEG9xXV69phU31FYCLUagKeYtsF" . $devid);
        $content = sprintf('type@=loginreq/username@=/ct@=0/password@=/roomid@=%s/devid@=%s/rt@=%s/vk@=%s/ver@=20150929/', $roomId, $devid, $rt, $vk);

        return $content;
    }

    /**
     * 登录弹幕服务器
     * @param int $roomId 房间Id
     * @return string
     */
    public static function danmuServerLogin($roomId)
    {
        return 'type@=loginreq/username@=' . 'visitor1234567' . '/password@=' . '1234567890123456' . '/roomid@=' . $roomId;
    }

    /**
     * 加入弹幕组
     * @param $roomId
     * @param $groupId
     * @return string
     */
    public static function joinGroup($roomId, $groupId)
    {
        return sprintf('type@=joingroup/rid@=%s/gid@=%s/', $roomId, $groupId);
    }

    /**
     * 心跳keeplive
     * @return string
     */
    public static function keepLive()
    {
        return sprintf('type@=keeplive/tick@=%s/', time());
    }
}