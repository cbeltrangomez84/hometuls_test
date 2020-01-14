<?php

	function GUID() {
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	function getUserIpAddr(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	$DATA = $_POST;
	$DATA["uuid"] = GUID();
	$DATA["ip_address"] = getUserIpAddr();
	$DATA["ip_info"] = $_SERVER['HTTP_USER_AGENT'];

	/*$params =  array('uuid' => null,'categoryA' => 'B','categoryB' => 'B2','categoryC' => null,'subCategory' => null,'institutionName' => null,'comments' => 'No me están entregando medicamentos ni mi hicieron terapia restaurativa','politicA' => null,'politicB' => null,'politicC' => null,'anonymus' => false,'name' => 'Carlos','email' => 'diegorengifov@gmail.com','phone' => '3125853948','code_state' => '24','code_city' => '13','gender' => 'M','ip_address' => '190.131.248.33','ip_info' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36','date' => 1569015537000,'image' => null,'staName' => 'RISARALDA','citName' => 'BALBOA','citId' => null,'latitude' => 4.949748,'longitude' => -75.958017,'locInfo' => null,'countItems' => 0,'fileRecords' => null);*/

	$params = [];
	foreach ($DATA as $key => $value){ 
	  if($value==="") {
	  	$params[$key] = null;
	  }
	  else {
	  	$params[$key] = $value;	
	  }
	} 

	//echo json_encode($params);
	//die();

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt_array($curl, array(
	    CURLOPT_URL => "https://34.201.19.114:40003/recordController/createRecord",
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "POST",
	    CURLOPT_POSTFIELDS => json_encode($params),
	    CURLINFO_HEADER_OUT =>  true,
	    CURLOPT_HTTPHEADER => array(
	      "Accept: application/json, text/javascript; q=0.01",
	      "Accept-Encoding: gzip, deflate, br",
	      "Accept-Language: en-US,en;q=0.9",
	      "Cache-Control: no-cache",
	      "Connection: keep-alive",
	      //"Content-Type: application/x-www-form-urlencoded",
	      "Content-Type: application/json",
	      "Cookie: cookieconsent_status=allow; ogl_visits^[0^]=a5cbwGRWU7YEC1LP6tKOVOzf6GIZzyU7dbry64BfNak4xygExIAj^%^2FkGWQ5azKqmznEHJVCF4ZfufdAaCugfPjPi8vX7CB8Gs^%^2F3OdX5RVvYjyfWKHUHboChkYfbURk6Ly",
	      "Host: www.oglasnik.hr",
	      "Origin: https://www.oglasnik.hr",
	      "Referer: https://www.oglasnik.hr/stanovi-najam/novi-zagreb-bundek-2-sobni-stan-55-m2-oglas-3996266",
	      "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36",
	      "X-Requested-With: XMLHttpRequest",
	      "cache-control: no-cache",
	      "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
	    ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	    echo "cURL Error #:" . $err;
	} else {
		echo $DATA["uuid"];
	    //echo $response;
	}


?>