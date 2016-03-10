<?php
/**
 * 常用方法封装
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
/**
 * 屏幕输出
 * @param string $str 字符串数据
 */
function screen_print($str)
{
    echo "$str\n";
}

/**
 * var_dump数据
 * @param array $data 任何数据
 */
function debug($data)
{
    var_dump($data);
    exit;
}

/**
 * 生成GUID
 * @return string
 */
function guid() {
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        return $uuid;
    }
}