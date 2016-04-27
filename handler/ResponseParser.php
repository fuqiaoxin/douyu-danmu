<?php
/**
 * HTTP响应头解析
 * @author LincolnZhou<875199116@qq.com> 2016-03-10
 */
class ResponseParser
{
    const REGEX_SEVER = '/%7B%22ip%22%3A%22(.*?)%22%2C%22port%22%3A%22(.*?)%22%7D%2C/';
    const REGEX_DANMU_SERVER = '/ip@=(.*?)\/port@=(\\d*?)\//';
    const REGEX_GROUP_ID = '/type@=setmsggroup\/rid@=(\\d*?)\/gid@=(\\d*?)\//';
    const REGEX_CHAT_DANMU = '/type@=chatmsg\/rid@=(.*?)\/uid@=(.*?)\/nn@=(.*?)\/txt@=(.*?)\//';

    /**
     * 解析服务器信息
     * @param string $content 带有服务器信息数据
     * @return array
     */
    public static function parserServerInfo($content)
    {
        if ('' == $content or null == $content) return '';

        preg_match_all(self::REGEX_SEVER, $content, $matches);

        //判断是否有匹配
        if (empty($matches)) {
            return false;
        }

        $serverList = array();
        foreach ($matches[0] as $key => $match) {
            $serverInfo = new ServerInfo($matches[1][$key], $matches[2][$key]);
            array_push($serverList, $serverInfo);
        }

        return $serverList;
    }

    /**
     * 解析弹幕服务器信息
     * @param string $content 带有服务器信息数据
     * @return array|bool
     * 如下格式：
     * è¯»å–æœåŠ¡å™¨åˆ—è¡¨ä¸­... xx²type@=msgrepeaterlist/rid@=469012/list@=id@AA=75801@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=12601@AS@Sid@AA=71502@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=12602@AS@Sid@AA=71504@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=8602@AS@Sid@AA=71503@ASnr@AA=1@ASml@AA=10000@ASip@AA=danmu.douyutv.com@ASport@AA=8601@AS@S/..²type@=setmsggroup/rid@=469012/gid@=2/""²type@=scl/cd@=0/maxl@=50/88²type@=initcl/uid@=1304289830/cd@=3000/maxl@=50/œœ²type@=memberinfores/silver@=0/gold@=0/strength@=0/weight@=5121840/exp@=0/curr_exp@=0/level@=1/up_need@=1000/fans_count@=32390/fl@=0/list@=/glist@=/
     */
    public static function parserDanmuServer($content)
    {
        if ('' == $content or null == $content) return '';

        $content = SttCode::decode(SttCode::decode($content));
        preg_match_all(self::REGEX_DANMU_SERVER, $content, $matches);

        //判断是否有匹配
        if (empty($matches)) {
            return false;
        }

        $serverList = array();
        foreach ($matches[0] as $key => $match) {
            $serverInfo = new ServerInfo($matches[1][$key], $matches[2][$key]);
            array_push($serverList, $serverInfo);
        }

        return $serverList;
    }

    /**
     * 解析GroupId
     * @param string $content 带有服务器信息数据
     * @return string
     * 如下格式：
     * type@=setmsggroup/rid@=469012/gid@=2
     */
    public static function parserGroupId($content)
    {
        if ('' == $content or null == $content) return '';

        preg_match_all(self::REGEX_GROUP_ID, $content, $matches);

        //判断是否有匹配
        if (empty($matches)) {
            return false;
        }

        return $matches[2][0];
    }

    /**
     * 解析弹幕信息
     * @param string $content 带有弹幕信息
     * @return Danmu
     */
    public static function parserDanmu($content)
    {
        if ('' == $content or null == $content) return '';

        preg_match_all(self::REGEX_CHAT_DANMU, $content, $matches);

        //判断是否有匹配
        if (empty($matches)) {
            return false;
        }

        $danmu = new Danmu($matches[2][0], $matches[3][0], $matches[4][0]);

        return $danmu;
    }
}