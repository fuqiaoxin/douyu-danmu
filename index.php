<?php
require_once './domain/Danmu.php';
require_once './domain/Douyu_Socket.php';
require_once './domain/Message.php';
require_once './domain/Request.php';
require_once './domain/ServerInfo.php';
require_once './handler/MessageHandler.php';
require_once './handler/ResponseParser.php';
require_once './util/Curl.php';
require_once './util/Function.php';
require_once './util/SttCode.php';

/**
 * 应用程序执行脚本
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */

define('ROOM_ID', '288016'); //房间号
define('DOUYU_URL', 'http://www.douyutv.com'); //斗鱼TV网站地址

$roomUrl = DOUYU_URL . '/' . ROOM_ID;
$roomHtml = Curl::request($roomUrl);
screen_print('读取服务器列表中...');
$serverList = ResponseParser::parserServerInfo($roomHtml);
if (empty($serverList)) {
    screen_print('读取服务器列表失败！');
}

//登录服务器
$serverInfo = $serverList[rand(0, count($serverList) - 1)]; //随机返回一个服务器
screen_print(sprintf('登录服务器-%s:%s', $serverInfo->getHost(), $serverInfo->getPort()));
//$serverScoket = new Douyu_Socket($serverInfo->getHost(), $serverInfo->getPort());
$serverSocket = new Douyu_Socket('119.90.49.106', '8028');
MessageHandler::send($serverSocket, Request::serverLogin(ROOM_ID));
$content = MessageHandler::receive($serverSocket);
$danmuResource = MessageHandler::receive($serverSocket);
screen_print(sprintf('登录服务器-%s:%s成功', $serverInfo->getHost(), $serverInfo->getPort()));

//读取弹幕服务器
screen_print('读取弹幕服务器列表中...');
$danmuServerList = ResponseParser::parserDanmuServer($danmuResource);
if (empty($danmuServerList)) {
    screen_print('读取弹幕服务器列表失败！');
}

//登录弹幕服务器
$danmuServerInfo = $danmuServerList[rand(0, count($danmuServerList) - 1)]; //随机返回一个服务器
screen_print(sprintf('登录弹幕服务器-%s:%s', $danmuServerInfo->getHost(), $danmuServerInfo->getPort()));
$danmuServerSocket = new Douyu_Socket($danmuServerInfo->getHost(), $danmuServerInfo->getPort());
$danmuServerSocket = new Douyu_Socket('danmu.douyutv.com', 8601);
MessageHandler::send($danmuServerSocket, Request::danmuServerLogin(ROOM_ID));
screen_print(sprintf('登录弹幕服务器-%s:%s成功', $danmuServerInfo->getHost(), $danmuServerInfo->getPort()));

screen_print('读取弹幕群组GrouId中...');
$groupId = ResponseParser::parserGroupId($danmuResource);
screen_print("进入" . ROOM_ID . "号房间，" . $groupId . "号弹幕群组...");
MessageHandler::send($danmuServerSocket, Request::joinGroup(ROOM_ID, $groupId));

screen_print('开始接受弹幕...');
screen_print('心跳包启动...');
$count = 0;
do {
    if ($count % 10 == 0) {
        MessageHandler::send($danmuServerSocket, Request::keepLive());
    }
    $content = MessageHandler::receive($danmuServerSocket);
    if ($content == '') {
        break;
    }

    $count++;
    if(strpos($content, 'chatmessage')) {
        $danmu = ResponseParser::parserDanmu($content);
        screen_print($danmu->getSnick() . "[" . $danmu->getUid() . "]:\t" . $danmu->getContent());
    }

} while(true);