<?php 
	//setcookie("user", "Alex Porter", time()+3600);
	//echo $_COOKIE["user"];
	
	class AMPCrypt {
		private static function getKey(){
			return md5('exampleKey');
		}
		public static function encrypt($value){
			 $td = mcrypt_module_open('tripledes', '', 'ecb', '');
			 $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
			 $key = substr(self::getKey(), 0, mcrypt_enc_get_key_size($td));
			 mcrypt_generic_init($td, $key, $iv);
			 $ret = base64_encode(mcrypt_generic($td, $value));
			 mcrypt_generic_deinit($td);
			 mcrypt_module_close($td);
			return $ret;
		}
		public static function dencrypt($value){
			 $td = mcrypt_module_open('tripledes', '', 'ecb', '');
			 $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
			 $key = substr(self::getKey(), 0, mcrypt_enc_get_key_size($td));
			 $key = substr(self::getKey(), 0, mcrypt_enc_get_key_size($td));
			 mcrypt_generic_init($td, $key, $iv);
			 $ret = trim(mdecrypt_generic($td, base64_decode($value))) ;
			 mcrypt_generic_deinit($td);
			 mcrypt_module_close($td);
			return $ret;
		}
		public static function again($city,$time,$content){
			$data = array("city"=>$city,"time"=>$time,"content"=>$content);
			$data = implode(",",$data);
			setcookie("my_data", $data, time()+60*60*24*365*10);
			//echo $_COOKIE["user"];
		}
	}
	$city = AMPCrypt::encrypt("上海");
	$time = time();
	$content = "测试";
	//echo AMPCrypt::dencrypt(AMPCrypt::encrypt("北京"));
	
	$my_data = $_COOKIE["my_data"];
	if(!$my_data){
		AMPCrypt::again($city,$time,$content);
	}else{
		$my_data = explode(",",$my_data);
		
		$city_again = AMPCrypt::dencrypt($my_data[0]);
	}
?>
<html>
<head>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#citys").hide();
	$("#city").click(function(){
		$("#citys").toggle();
	});
	<?PHP
		$s = array();
		$s[] = array("city_id"=>"a001","city_name"=>"北京");
		$s[] = array("city_id"=>"a002","city_name"=>"上海");
		$s[] = array("city_id"=>"a003","city_name"=>"天津");
		$s[] = array("city_id"=>"a004","city_name"=>"重庆");
		$s[] = array("city_id"=>"a005","city_name"=>"石家庄");
		$s[] = array("city_id"=>"a006","city_name"=>"合肥");
		
		for($i1=1;$i1<=count($s);$i1++){
	?>
	$("#a00<?PHP echo $i1; ?>").click(function(){
		var city = $("#a00<?PHP echo $i1; ?>").text();
		//alert(city);
		$.get("city.php?city="+city,function(data,status){
			//alert(data);
			window.location.reload()
		});
	});
	<?PHP } ?>
	
});
</script>
</head>

<body>

	<div id="city"><?PHP if(!$city_again){ ?>北京<?PHP }else{ echo $city_again; } ?></div>
	<div id="citys">
	<?PHP
		foreach($s as $item){
	?>
	<span id="<?PHP echo $item['city_id']; ?>"><?PHP echo $item['city_name']; ?></span><br>
	<?PHP } ?>
	
	</div>
	
</body>

</html> 
