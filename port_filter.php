<?php
/**
 * TCP端口过滤工具
 * @author LincolnZhou<875199116@qq.com> 2016-03-09
 */
//_config":"%5B%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228068%22%7D%2C%7B%22ip%22%3A%22119.90.49.110%22%2C%22port%22%3A%228049%22%7D%2C%7B%22ip%22%3A%22119.90.49.95%22%2C%22port%22%3A%228071%22%7D%2C%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228067%22%7D%2C%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228070%22%7D%2C%7B%22ip%22%3A%22119.90.49.103%22%2C%22port%22%3A%228013%22%7D%2C%7B%22ip%22%3A%22119.90.49.104%22%2C%22port%22%3A%228019%22%7D%2C%7B%22ip%22%3A%22119.90.49.109%22%2C%22port%22%3A%228045%22%7D%2C%7B%22ip%22%3A%22119.90.49.102%22%2C%22port%22%3A%228006%22%7D%2C%7B%22ip%22%3A%22119.90.49.106%22%2C%22port%22%3A%228026%22%7D%5D","def_disp_gg":0
//$str = '_config":"%5B%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228068%22%7D%2C%7B%22ip%22%3A%22119.90.49.110%22%2C%22port%22%3A%228049%22%7D%2C%7B%22ip%22%3A%22119.90.49.95%22%2C%22port%22%3A%228071%22%7D%2C%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228067%22%7D%2C%7B%22ip%22%3A%22119.90.49.94%22%2C%22port%22%3A%228070%22%7D%2C%7B%22ip%22%3A%22119.90.49.103%22%2C%22port%22%3A%228013%22%7D%2C%7B%22ip%22%3A%22119.90.49.104%22%2C%22port%22%3A%228019%22%7D%2C%7B%22ip%22%3A%22119.90.49.109%22%2C%22port%22%3A%228045%22%7D%2C%7B%22ip%22%3A%22119.90.49.102%22%2C%22port%22%3A%228006%22%7D%2C%7B%22ip%22%3A%22119.90.49.106%22%2C%22port%22%3A%228026%22%7D%5D","def_disp_gg":0';
fwrite(STDOUT,"Please input a string:\n");
$arg = trim(fgets(STDIN));
if ($arg == null) {
    print 'input is null';
} else {
   filter($arg);
}

/**
 * 过滤数据，匹配ip和prot
 * @param string $str 指定字符串
 */
function filter($str)
{
    $pattern = "/%7B%22ip%22%3A%22(.*?)%22%2C%22port%22%3A%22(.*?)%22%7D%2C/";
    preg_match_all($pattern, $str, $matches);

    //判断是否有匹配
    if (empty($matches)) {
        echo "\nno match\n";
    }

    $filterStr = [];
    echo "\nresult is:\n";

    foreach ($matches[0] as $key => $match) {
        echo sprintf("%s:%s\n", $matches[1][$key], $matches[2][$key]);
        array_push($filterStr, sprintf('tcp.port == %s', $matches[2][$key]));
    }

    echo "\nfilter string is:\n";
    echo implode(' || ', $filterStr) . ' || tcp.flags.push == 1';
}