<?php include $_SERVER['DOCUMENT_ROOT'] . '/common-1.php'?>

	<meta charset="utf-8">
	<title>Swamp Servers - Commands</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<link rel="shortcut icon" href="#">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common-2.php'?>

	<nav>
		<div class="logo"> <a href="">Commands</a> </div>
		<ul>
			<li><a href="#General">General</a></li>
			<li><a href="#Chat">Chat</a></li>
			<li><a href="#Stats">Stats</a></li>
			<li><a href="#Points">Points</a></li>
		</ul>
	</nav>

	<span class="hide"></span>
	<div class="container bg-danger" id="code">
		<div class="code">
			<h1>Important</h1>      
			<p>Do not include the "< >" symbols when you type the commands.</p>
		</div>
	</div>


	<div class="command">
		<div>
			<span class="hide" id="General"></span>
			<div class="General">
				<h2>General</h2>
				<hr>
			</div>
		</div>

		<div>
			<span class="hide" id="Chat"></span>
			<div class="Chat">
				<h2>Chat</h2>
				<hr>
			</div>
		</div>

		<div>
			<span class="hide" id="Stats"></span>
			<div class="Stats">
				<h2>Stats</h2>
				<hr>
			</div>
		</div>

		<div>
			<span class="hide" id="Points"></span>
			<div class="Points">
				<h2>Points</h2>
				<hr>
			</div>
		</div>

		<script type="text/javascript">

			function gen(cmd, msg) {
				let adds=[
				'<hr>',
				'<div>',
				'<h5 class="bg-secondary">'+cmd+'</h5>',
				'<p>'+msg+'</p>',
				'</div>'
				];
				return adds.join('\n');
			}
			

			var cmdg = ["/help","/join","/rules","/donate","/tp &lt;PLAYER&gt;","/tpa","/editpony","/kill","/stuck","/drop"];

			var msgg = ["Open this help page","Join our Steam group and double your points per minute","View the server rules","Donate money for in-game points and to show support","Requests a teleport to a player","Accepts a requested teleport to you","Edit your pony player model","Kills your player","Kills your player if you're stuck","Deletes your current weapon (does NOT \"drop\" it to be picked up)"];

			for (var i = 0; i < cmdg.length; i++) {
				$(String('.General')).append(gen(cmdg[i],msgg[i]));
			}


			var cmdc = ["/vote","/image &lt;QUERY&gt;","/gif &lt;QUERY&gt;","[url:&lt;URL&gt;]"];

			var msgc = ["Opens a menu that allows you to start a vote","Search and display an image","Search and display a GIF","Post a specific image in chat (note: no / and no space)"];

			for (var i = 0; i < cmdc.length; i++) {
				$(String('.Chat')).append(gen(cmdc[i],msgc[i]));
			}


			var cmds = ["/deaths","/kills","/playtime"];

			var msgs = ["Shows your death count in chat","Shows your kill count in chat","Shows your playtime in global chat"];

			for (var i = 0; i < cmds.length; i++) {
				$(String('.Stats')).append(gen(cmds[i],msgs[i]));
			}


			var cmdp = ["/8ball &lt;QUESTION&gt;","/roll &lt;AMOUNT&gt;","/coinflip &lt;PLAYER&gt; &lt;AMOUNT&gt;","/lotto","/givepoints &lt;PLAYER&gt; &lt;AMOUNT&gt;","/points","/bounty &lt;PLAYER&gt; &lt;AMOUNT&gt;","/bountyrandom &lt;AMOUNT&gt;","/bountyall &lt;AMOUNT&gt;"];

			var msgp = ["Ask the magic 8-ball a question","Gamble points (points lost will NOT be reimbursed)","Coinflip another player","Bet points in the lottery","Gives a player a specified amount of points","Shows your points in global chat","Places a bounty on a player (you can bounty yourself)","Places a bounty on a random player","Places a bounty on everyone"];

			for (var i = 0; i < cmdp.length; i++) {
				$(String('.Points')).append(gen(cmdp[i],msgp[i]));
			}

		</script>
	</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common-3.php'?>