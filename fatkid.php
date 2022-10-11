<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?php
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

$type = "fatkid";
if (isset($_GET["map"])) {
    if (startsWith($_GET["map"], "duckhunt")) {
        $type = "duckhunt";
    }
}


?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style.min.css" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width">
		<title>Fat Kid</title>

	<style>

body {
	background-color: #eeeeee !important;
	background-image:url('/s/fatkid/fatkidbanner.png');
	background-position:center -10px;
	background-repeat: no-repeat;
	padding: 0px;
	margin: 0px;
}

#content {
	background-color: #fdfdfd;
	width: 960px;
	padding: 20px;
	margin-top: 360px;
	border-radius: 16px;
	margin-left: auto;
	margin-right: auto;
}

a {
	color: black;
}

h2 {
	font-family: "Open Sans",sans-serif;
	font-weight: bolder;
	text-align: center;
	font-size: 30pt;
}

h2:first-of-type {
   	padding-top: 0.5em;
}

#content > h3 {
	font-family: "Open Sans Condensed",sans-serif;
	text-align: center;
	font-size: 28pt;
	color: #333333;
}

div, p, input {
	font-family: "Open Sans",sans-serif;
	font-size: 12pt;
	color: black;
	line-height: 140%;
}

.center {
	text-align: center;
}

#content > p {
	margin: 40px;
}

#content > .minip {
	margin-top:0px;
	margin-bottom:2px;
}

ul {
	margin-top:0px;
	margin-left:2em;
	margin-right:4em;
}

.steamcard {
	background-color: #cccccc !important;
}



	#mapinfozone > p {
		text-indent: 40px;
	}
	</style>
</head>
<body onscroll="paralax()"<?php if ($type == "duckhunt") {echo " style=\"background-image:url('/loading/duckwallpaper.jpg');\"";}?>>

	<script>
	function paralax(){
		document.body.style.backgroundPosition="center "+((document.body.scrollTop/3)-10)+"px";
	}
	</script>

	<div id="content">

	<script>
		function steamgroup() { console.log("RUNLUA:MOTDWINDOW:Close() timer.Simple(0.1, function() gui.OpenURL('https://steamcommunity.com/groups/swampservers') end)"); }
	</script>

	<div style="float:right;">
		<a href="/discord"><img style="width:48px;float:left;" src="/s/img/discord.png"></a>
		<a href="https://github.com/swampservers/fatkid"><img style="width:48px;float:left;" src="/s/img/github.png"></a>
	</div>


		<?php if (strpos($_SERVER['HTTP_USER_AGENT'], "Valve") === false) {?>
		<p class="center" style="font-size:16pt;">Fat Kid Official Server IP: <?=ServerDisplayIP("fatkid.swamp.sv")?> - <a href="steam://connect/fatkid.swamp.sv">Connect</a></p>
		<?php }?>
		<?php if ($type == "fatkid") {?>
		<?php if (!isset($_GET["map"])) {$map = "gymnasium";} else { $map = strtolower($_GET["map"]);}?>
		
		<div id="mapinfozone">
		<?php if (strstr($map, "gymnasium")) {?>
<!-- 		
		<h2>Welcome to Fattywood Junior High</h2>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			It was just an ordinary day of gym class.
			Gregory, the class fat kid, was, as usual, being bullied for his ineptitude at sports.
			But then, after being hit with a particularly heavy volley of dodgeballs, something inside his fragile autistic mind snapped.
			Or perhaps it was just hunger, as his fat ass hadn't eaten in over three hours.
			But anyway, he started eating his fellow classmates in a murderous rampage of gluttony.
		</p> -->
		<?php } elseif (strstr($map, "elementary")) {?>
		<!-- <h2>Welcome to Fattywood Elementary</h2>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			It's lunch hour, and young students have crowded into the cafeteria to eat their fill.
			One by one, the children finish their lunches and go outside to play in traffic, until only one student remains: Gregory, the fat kid.
			<em>Ring Ring!</em> The school bell chimes, announcing the end of lunch. But Gregory is still hungry.
			As the other children file back inside, a gluttonous instinct takes over Gregory's mind.
			He will eat his fellow classmates...
		</p> -->
		
		<?php }?>
		</div>

		<h3>Gameplay:</h3>
		<p class="minip">
			If you are a skinny kid:
		</p>
		<ul>
			<li>You must flee from the fat kid. Luckily, he doesn't move very fast.</li>
			<li>Break down barricades to access better weapons and distance yourself from the fat kid.</li>
			<li>Eventually, you must stop and face the fat kid. He will die under heavy, prolonged gunfire.</li>
			<li>If you can survive until the round ends, you win!</li>
			<li>If you are eaten by the fat kid, you become a SKELETON!</li>
		</ul>

		<p class="minip">
			If you are a skeleton:
		</p>
		<ul>
			<li>You are a minion of the fat kid. You must help him exterminate the skinny kids.</li>
			<li>You move fast, but die easily. Use your speed to run down and kill your former classmates.</li>
			<li>If you're a skeleton, you've already lost.</li>
		</ul>
		<p class="minip">
			If you are the fat kid:
		</p>
		<ul>
			<li>You're slow, but tough to kill. Keep moving forward and eventually the skinny kids will be cornered.</li>
			<li>Use your ground slam ability (right click) to stun nearby skinny kids, making them easier to catch.</li>
			<li>Left click on a skinny kid to EAT them and turn them into a skeleton. Skeletons will help you a lot.</li>
			<li>If you and your skeletons manage to kill all of the skinny kids before the time runs out, you win!</li>
		</ul>
		<p class="minip">
			Tips:
		</p>
		<ul>
			<li>Throw dodgeballs at the fat kid to knock him back, or throw them at a skeleton to kill it.</li>
			<li>As a skinny kid your survival depends on being able to get around the fat kid at the beginning of the game.</li>
			<li>As a skeleton, look for vents and other special passages which can be used to flank and ambush the survivors.</li>
			<li>If you're the fat kid, eat players to regain health. Use corners and dark areas to trick kids into getting too close, then use ground slam to trap them before eating them.</li>
		</ul>

		<?php } else {?>

		<h2>DUCK HUNT</h2>

		<ul>
			<li>Ducks must run through the level while dodging the hunter's arrows.</li>
			<li>If a duck reaches the end, they can shoot the hunter, and the ducks win!</li>
			<li>If the hunter eliminates the ducks or keeps them from reaching the end, the hunter wins!</li>
		</ul>

		<?php }?>

		<h3>Rules:</h3>
		<p class="center">
			Please don't use hacks on our server or exploit the map.<br>Micspam is allowed; you may mute micspammers by holding TAB and clicking the mute icon by their name.
		</p>
		<h3>Developers:</h3>
		<div class="text-center">
		<?php

//output_steam_info("76561198076504953",$players,"Map Developer: Underground, Catacombs");
//output_steam_info("76561198041190464",$players,"Map Developer: Pitbase");

SteamCard(76845684,"Creator");

?>
		</div>
		<p class="minip center">
			<br><br>
			<strong>This page is available to view out of game at swamp.sv/infection</strong>
			<br><br>
		</p>

	</div>
</html>
</head>

<script>
console.log("RUNLUA:SetFatKidMotd()");
</script>