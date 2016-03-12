<?php
/**
 * 弹幕类
 * @author LincolnZhou<875199116@qq.com> 2016-03-12
 */
class Danmu
{
    private $uid;
    private $snick;
    private $content;

    public function __construct($uid, $snick, $content)
    {
        $this->uid = $uid;
        $this->snick = $snick;
        $this->content = $content;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function getSnick()
    {
        return $this->snick;
    }

    public function getContent()
    {
        return $this->content;
    }
}