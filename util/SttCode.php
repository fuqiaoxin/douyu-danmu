<?php
/**
 * 斗鱼Socket数据编解码规则类
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
class SttCode
{
    /**
     * 解码
     * @param string $str 字符串
     * @return mixed|string
     */
    public static function decode($str)
    {
        $str = trim($str);

        if (empty($str)) {
            return $str;
        }

        return str_replace(array('@S', '@A'), array('/', '@'), $str);
    }

    /**
     * 编码
     * @param string $str 字符串
     * @return mixed|string
     */
    public static function encode($str)
    {
        $str = trim($str);

        if (empty($str)) {
            return $str;
        }

        return str_replace(array('@', '/'), array('@A', '@S'), $str);
    }
}