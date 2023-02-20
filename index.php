<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat Interface</title>
    <!-- Include Tailwind CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css"
      
    />
  </head>
  <body>
    <div class="h-screen flex flex-col">
      <div class="flex-1 bg-gray-100 p-6 flex flex-col justify-end">
        <div class="flex flex-col gap-2" id="chats">
          
          <!-- Add more messages here as needed -->
        </div>
      </div>
	<form onsubmit="sendMsg();return false;">
      <div class="bg-white p-4 flex">
        <input
          type="text"
	   id="msg"
          placeholder="Type your message here..."
          class="flex-1 border rounded-lg py-2 px-4 mr-4"
        />
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg py-2 px-4">
          Send
        </button>
      </div>
</form>
    </div>
  </body>
<script>
var username = '';

if(!username)
{
	username = prompt("Hey there, good looking stranger!  What's your name?", "");
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
	

document.querySelector("#msg").value='';
	fetch('?msg='+username+ " : " +msg);
}

var source = new EventSource('?server=yes');

var old = '';
source.onmessage = function(e)
{
	if(old!=e.data){


		const [un, text] = e.data.split(' : ');

		const mtd  = `<span class="font-bold">${un}</span> - ${text}`;

	if(e.data.includes(username+" :")){
		document.getElementById("chats").innerHTML+='<div class="bg-gray-300 text-gray-700 rounded-lg p-2 max-w-max self-end">'+mtd+'</div>';
	}else{

		document.getElementById("chats").innerHTML+='<div class="bg-blue-500 text-white rounded-lg p-2 max-w-max">'+mtd+'</div>';
	}
	window.scrollTo(0, document.body.scrollHeight); 
	old = e.data;
	}
};

</script>
</html>
