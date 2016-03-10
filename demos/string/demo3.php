<?PHP
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
	$a = mbStrSplit("中华人民共和国中央人民政府","1");
	$a = array_unique($a);
	print_r($a);
?>
