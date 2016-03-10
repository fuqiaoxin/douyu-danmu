<?php
require_once 'domain/Douyu_Socket.php';
require_once 'domain/Message.php';
require_once 'domain/Request.php';
require_once 'domain/ServerInfo.php';
require_once 'parser/ResponseParser.php';
require_once 'util/Curl.php';
require_once 'util/Function.php';
require_once 'util/SttCode.php';

/**
 * 应用程序执行脚本
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */

define('ROOM_ID', '93713'); //房间号
define('DOUYU_URL', 'http://www.douyutv.com'); //斗鱼TV网站地址

$roomUrl = DOUYU_URL . '/' . ROOM_ID;
$roomHtml = Curl::request($roomUrl);
screen_print('读取服务器列表中...');
$serverList = ResponseParser::parserServerInfo($roomHtml);
if (empty($serverList)) {
    screen_print('读取服务器列表失败！');
}

$danmuResource = Request::serverLogin($serverList, ROOM_ID);
screen_print('读取弹幕服务器列表中...');
$danmuServerList = ResponseParser::parserDanmuServer($danmuResource);
if (empty($danmuServerList)) {
    screen_print('读取弹幕服务器列表失败！');
}

$danmuServerInfo = Request::danmuServerLogin($danmuServerList, ROOM_ID, $danmuResource);

screen_print('读取弹幕服务器GrouId中...');
$groupId = ResponseParser::parserGroupId($danmuResource);
screen_print('弹幕服务器GrouId为：' . $groupId);

screen_print("进入 " . ROOM_ID . " 号房间， " . $groupId . " 号弹幕群组...");
//Request::joinGroup($danmuServerInfo, ROOM_ID, $groupId);