<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");

define('ENDPOINT', 'https://graph.fb.me/');
define('ACCESS_TOKEN', ''); 
define('USER_ID', ''); 
define('MY_USER_ID', '100010835689571'); 
$posts = curl(ENDPOINT.USER_ID.'/posts?fields=id&limit=1&access_token='.ACCESS_TOKEN); 
$idFirstPost = $posts->data[0]->id; // Get first ID status
$list_cmt = ['']; 

if(!checkCmt($idFirstPost)) {
    $cmt = $list_cmt[array_rand($list_cmt)];
	$url = ENDPOINT.$idFirstPost.'/comments?message='.$cmt.'&method=POST&access_token='.ACCESS_TOKEN;
	$log = curl($url);
		echo 'Successfully Commented';
} else {
	echo 'COMMENTED';
}
 
 
function curl($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36');

	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result);
}

function checkCmt($idPost) {
     $getReactions = curl(ENDPOINT.$idPost.'/comments?access_token='.ACCESS_TOKEN);
         foreach ($getReactions->data as $user) {
                   if(MY_USER_ID == $user->from->id) {
				   return true;}
}
return false;
}

