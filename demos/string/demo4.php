<?PHP
	@ini_set('memory_limit', '264M');
	function mbStrSplit ($string, $len=1) {
		$start = 0;
		$strlen = mb_strlen($string);
		while ($strlen) {
			$array[] = mb_substr($string,$start,$len,"utf8");
			$string = mb_substr($string, $len, $strlen,"utf8");
			$strlen = mb_strlen($string);
		}
		return $array;
	}
	$a = mbStrSplit("中华人民共和国","1");
	$a = array_unique($a);
	print_r($a);
	
	
	
	
	
	$arr = $a;  
	$count1 = count($arr);
	$result = array();  
	$t = getCombinationToString($arr, $count1);  
	//print_r($t);  
	echo '<br />';

	$arr_a1 = array();
	foreach($t as $itm){
		//echo $itm;
		$len3 = utf8_strlen($itm);
		for($i1=$len3;$i1>=2;$i1--){
			
			$str_a1 = cut_str($itm, $i1, 0, 'UTF-8');
			$len4 = utf8_strlen($str_a1);
			if($len4=="2"){
				$arr_a1[] = $str_a1;
			}
			//echo substr($itm,0,$i1);
			//echo $str{$i1};
			//echo '<br />';
		}
		//echo '<br />';
	}
	$arr_a2 = array_unique($arr_a1);
	print_r($arr_a2);
	  
	function getCombinationToString($arr, $m) {  
		if ($m ==1) {  
		   return $arr;  
		}  
		$result = array();  
		  
		$tmpArr = $arr;  
		unset($tmpArr[0]);  
		for($i=0;$i<count($arr);$i++) {  
			$s = $arr[$i];  
			$ret = getCombinationToString(array_values($tmpArr), ($m-1), $result);  
			  
			foreach($ret as $row) {  
				$result[] = $s . $row;  
			}  
		}  
		  
		return $result;  
	}


	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') 
	{ 
	if($code == 'UTF-8') 
	{ 
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
	preg_match_all($pa, $string, $t_string); 
	if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)); 
	return join('', array_slice($t_string[0], $start, $sublen)); 
	} 
	else 
	{ 
	$start = $start*2; 
	$sublen = $sublen*2; 
	$strlen = strlen($string); 
	$tmpstr = ''; 
	for($i=0; $i< $strlen; $i++) 
	{ 
	if($i>=$start && $i< ($start+$sublen)) 
	{ 
	if(ord(substr($string, $i, 1))>129) 
	{ 
	$tmpstr.= substr($string, $i, 2); 
	} 
	else 
	{ 
	$tmpstr.= substr($string, $i, 1); 
	} 
	} 
	if(ord(substr($string, $i, 1))>129) $i++; 
	} 
	if(strlen($tmpstr)< $strlen ) $tmpstr.= "..."; 
	return $tmpstr; 
	} 
	} 
	//$str = "abcd需要截取的字符串"; 
	//echo cut_str($str, 8, 0, 'gb2312');   



	//$zhStr = ‘您好，中国！’;
	//$str = ‘Hello,中国！’;
	// 计算中文字符串长度
	function utf8_strlen($string = null) {
		// 将字符串分解为单元
		preg_match_all("/./us", $string, $match);
		// 返回单元个数
		return count($match[0]);
	}
	//echo utf8_strlen($zhStr); // 输出：6
	//echo utf8_strlen($str); // 输出：9
?>
