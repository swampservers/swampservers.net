	<?=common_top()?>

	<meta charset="utf-8">
	<title>Swamp Servers - Commands</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		*{
			font-family: Righteous;
			scroll-behavior: smooth;
		}
		body{
			background: #111;
			line-height: 1.8;
		}
		#nav{
			display: flex;
			height: 60px;
			width: 100%;
			background: #286068;
			align-items: center;
			justify-content: space-between;
			padding: 0 50px 0 50px;
			flex-wrap: wrap;
			position: fixed;
			top: 0px;
			z-index: 2;
		}
		.logo a{
			color: #fff;
			font-size: 30px;
			font-weight: 600;
			text-decoration: none;
		}
		#nav ul{
			display: flex;
			flex-wrap: wrap;
			list-style: none;
			margin-bottom: 0px;
		}
		#nav ul li{
			margin: 0 5px;
		}
		#nav ul li a{
			color: #f2f2f2;
			text-decoration: none;
			font-size: 17px;
			font-weight: 500;
			padding: 5px 15px;
			border-radius: 9px;
			letter-spacing: 1px;
			transition: all 0.3s ease;
		}
		#nav ul li a.active,
		#nav ul li a:hover{
			color: #111;
			background: #fff;
		}
		.hide {
			display: block;
			height: 80px;
			margin-top: 10px;
			visibility: hidden;
		}
		#code{
			max-width: 40%;
			border-radius: 25px;
		}
		.code{
			padding: 10px 10px;
		}
		.command{
			padding: 0px 400px;
			padding-bottom: 10px;
			color: #fff;
		}
		hr{
			height: 4px;
			background-color: #286068;
			border: none;
		}
		.command div div ~ hr{
			background-color: #122a2e;
			height: 3px;
			margin-left: 30px;
		}
		.command div div hr:nth-child(2){
			height: 0px;
		}
		h5{
			margin: 0px 40px;
			padding: 0px 10px;
			border: 2px outset #ccc;
			border-radius: 10px;
			display: inline;
		}
		p{
			padding: 5px 90px;
		}
	</style>

	<?=common_middle()?>

	<?php
		$cmd = ['General' => [['help','Open this help page'],
								['join','Join our Steam group and double your points per minute'],
								['rules','View the server rules'],
								['donate','Donate money for in-game points and to show support'],
								['tp &lt;PLAYER&gt;','Requests a teleport to a player'],
								['tpa','Accepts a requested teleport to you'],
								['editpony','Edit your pony player model'],
								['kill','Kills your player'],
								['stuck','Kills your player if you"re stuck'],
								['drop','Deletes your current weapon (does NOT \"drop\" it to be picked up)']
								],

				'Chat' => [['vote','Opens a menu that allows you to start a vote'],
							['image &lt;QUERY&gt;','Search and display an image'],
							['gif &lt;QUERY&gt;','Search and display a GIF'],
							['[url:&lt;URL&gt;]','Post a specific image in chat (note: no / and no space)']
							],	

				'Stats' => [['deaths','Shows your death count in chat'],
							['kills','Shows your kill count in chat'],
							['playtime','Shows your playtime in global chat']
							],

				'Points' => [['8ball &lt;QUESTION&gt;','Ask the magic 8-ball a question'],
							['roll &lt;AMOUNT&gt;','Gamble points (points lost will NOT be reimbursed)'],
							['coinflip &lt;PLAYER&gt; &lt;AMOUNT&gt;','Coinflip another player'],
							['lotto','Bet points in the lottery'],
							['givepoints &lt;PLAYER&gt; &lt;AMOUNT&gt; &lt;PLAYER&gt;','Gives a player a specified amount of points'],
							['points','Shows your points in global chat'],
							['bounty &lt;PLAYER&gt; &lt;AMOUNT&gt;','Places a bounty on a player (you can bounty yourself)'],
							['bountyrandom &lt;AMOUNT&gt;','Places a bounty on a random player'],
							['bountyall &lt;AMOUNT&gt;','Places a bounty on everyone']
							]
				];
	?>

	<nav id="nav"><div class="logo"> <a href="">Commands</a></div><ul>

	<?php
		foreach ($cmd as $k => $v) {
			echo "<li><a href=\"#".$k."\">".$k."</a></li>";		
		}
	?>

	</ul></nav><span class="hide"></span>
	<div class="container bg-danger" id="code">
	<div class="code"><h1>Important</h1><p>Do not include the < > symbols when you type the commands.</p>
	</div></div>
	<div class="command">

	<?php
		foreach($cmd as $c => $d) {
			echo "<div> <span class=\"hide\" id=".$c."></span><div class=".$c."><h2>".$c."</h2><hr>";
			foreach ($d as $e) {
				echo "<hr><div><h5 class=\"bg-secondary\">/".$e[0]."</h5><p>".$e[1]."</p></div>";
			}
		}
	?>

	<?=common_bottom()?>
