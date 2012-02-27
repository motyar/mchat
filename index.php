<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<style>
body
{
	width: 80%;
	margin: 0 auto;
}
#chats
{
	height: 500px;
	overflow-y: scroll;
}
#msg
{
	font-size: 25px;
	width: 99%;
	border: 1px solid #DDD;
	border-radius: 5px;
	-moz-border-radius: 5px;
	font-family: Arial, Helvetica, sans-serif;
	margin: 5px auto 20px;
	padding: 5px;
	border-image: initial;
}
.msgln
{
	padding: 3px;
}
.msgln:nth-child(odd)
{
	background-color: #EAEAEA;
}
footer
{
	position: fixed;
	bottom: 10px;
}
</style>
</head>
<body>
<?php
	$room = 'roomname';
?>
<div id="chats"></div>
<form onsubmit="javascript:sendMsg();return false;">
	<input type="text" name="text" id="msg" autocomplete="off" />
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
var username = '';

if(!username)
{
	var username = prompt("Hey there, good looking stranger!  What's your name?", "");
}

function sendMsg(){
	if(!username)
	{
		username = prompt("Hey there, good looking stranger!  What's your name?", "");
		if(!username)
		{
			return;
		}
	}

	var msg = document.getElementById("msg").value;
	if(!msg)
	{
		return;
	}
	
	document.getElementById("chats").innerHTML+=strip('<div class="msgln"><b>'+username+'</b>: '+msg+'<br/></div>');
	$("#chats").animate({ scrollTop: 2000 }, 'normal');

	$.get('/server.php?msg='+msg+'&user='+username+'&room=<?php echo $room; ?>', function(data)
	{
		document.getElementById("msg").value = '';
	});
}

var old = '';
var source = new EventSource('/server.php?room=<?php echo $room; ?>');

source.onmessage = function(e)
{
	if(old!=e.data){
		document.getElementById("chats").innerHTML='<span>'+e.data+'</span>';
		old = e.data;
	}
};

function strip(html)
{
	var tmp = document.createElement("DIV");
	tmp.innerHTML = html;
	return tmp.textContent||tmp.innerText;
}
</script>
<footer>
Created by <a href="http://twitter.com/motyar">@motyar</a> | <a href="http://motyar.blogspot.com/">blog</a> | <a href="http://news.ycombinator.com/item?id=3509146">discuss</a>
</footer>
</body>
</html>