<?php 



function get_curl($url) {
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $output;
    } else {
        return file_get_contents($url);
    }
}


class vk {

    private static $access_token;
    private static $url = "https://api.vk.com/method/";


	public static function set_token($token)
	{
	   self::$access_token = $token;
	}
	
    public static function method($method, $params = null) {
        
        $p = "";
		
		$params["access_token"] = self::$access_token;
	
        if( $params && is_array($params) ) {
            foreach($params as $key => $param) {
                $p .= ($p == "" ? "" : "&") . $key . "=" . urlencode($param);
            }
        }
        $secondurl = self::$url . $method . "?" . $p;
     
        $response = get_curl($secondurl);
        if( $response ) {
            $obj = json_decode($response);
 
            
            return $obj;
        }
        return false;
    }
}


?>