<?php
/**
 * 弹幕服务器过滤工具
 * @author LincolnZhou<875199116@qq.com> 2016-03-09
 */
echo "danmu server list:\n";
$str = 'vvtype@=msgrepeaterlist/rid@=6324/list@=id@AA=71504@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=8602@AS@Sid@AA=71501@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=12601@AS@Sid@AA=71502@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=12602@AS@Sid@AA=71503@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=8601@AS@S/--type@=setmsggroup/rid@=6324/gid@=22/""type@=scl/cd@=0/maxl@=30/66type@=initcl/uid@=31995370/cd@=3000/maxl@=32/type@=memberinfores/silver@=105/gold@=0/strength@=4140/weight@=83221183/exp@=171940/curr_exp@=9940/level@=9/up_need@=56560/fans_count@=301144/fl@=1/list@=/glist@=/';
$splitArr = explode('/', $str);
$serverStr = str_replace('list@=', '',$splitArr['2']);
$serverStr = explode('/', filter($serverStr, false));
array_pop($serverStr);

$servers = array();
foreach ($serverStr as $str) {
    $server = filter($str, false);
    $datas = explode('/', $server);
    $temp = array();
    foreach ($datas as $data) {
        if ($data != '') {
            list($key1, $list) = explode('@=', $data);
            if ($key1) {
                $temp[$key1] = $list;
            }
        }
    }
    echo sprintf("%s:%s\n", $temp['ip'], $temp['port']);
    array_push($servers, $temp);
}
/**
 * @param $str
 * @param bool $encode
 * @return string
 */
function filter($str, $encode = true)
{
    $str = trim($str);

    if (empty($str)) {
        return $str;
    }

    if ($encode === true) {
        return str_replace(array('@', '/'), array('@A', '@S'), $str);
    } else {
        return str_replace(array('@S', '@A'), array('/', '@'), $str);
    }
}