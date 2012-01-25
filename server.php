<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function sendMsg($id, $msg) {
  echo "id: $id" . PHP_EOL;
  echo "data: $msg" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();
  flush();
}


if(isset($_GET['user']) && isset($_GET['msg'])){
	$fp = fopen($_GET['room']."log.txt", 'a');  
    fwrite($fp, "<div class='msgln'><b>".strip_tags($_GET['user'])."</b>: ".strip_tags(($_GET['msg']))."<br></div>");  
    fclose($fp);  
}

if(file_exists($_GET['room']."log.txt") && filesize($_GET['room']."log.txt") > 0){  
    $handle = fopen($_GET['room']."log.txt", "r");  
    $contents = fread($handle, filesize($_GET['room']."log.txt"));  
    fclose($handle);
	
//deleting file when it get bigger
	if(filesize($_GET['room']."log.txt")>1100){
		@unlink($_GET['room']."log.txt");
	}
}  

sendMsg(time(),$contents);

?>