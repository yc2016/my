Thinkphp3.2.3分页错误解决方案

\ThinkPHP\Library\Think\Page.class.php

/**
 * 生成链接URL
 * @param  integer $page 页码
 * @return string
 */
private function url($page){
    //return str_replace(urlencode('[PAGE]'), $page, $this->url);
if($page=="1")
	return U(ACTION_NAME);
else
	return U(ACTION_NAME)."?p=".$page;
}
