<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?=common_top("News","/s/screenshots/newscast.jpg")?>

<div class="row">
<div class="col-lg-8">

<!-- <div class="well">
	<div class="text-center"><strong>IMPORTANT: The DOUBLE POINTS perk is now tied to our STEAM CHAT because Discord <a href="/discord">literally banned us for not protecting child molestors</a></strong></div>
	<script>
	function discordgroup() { console.log("RUNLUA:MOTDWINDOW:Close() timer.Simple(0.1, function() gui.OpenURL('https://steamcommunity.com/groups/swampservers') end)"); }
	</script>
	<div class="text-center">
	<img style="width:48px;" src="/s/img/steamlogo.png"> &nbsp;
	<a onclick='discordgroup()' href="https://steamcommunity.com/groups/swampservers">Join our STEAM CHAT today for DOUBLE POINTS!</a>
		&nbsp; <img style="width:48px;" src="/s/img/steamlogo.png">
	</div>
</div> -->


<!-- <h1 class="text-center">News</h1> -->

<script>
var formattime = document.getElementsByClassName("formattime");
var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
for(var i = 0; i < formattime.length; i++)
{
	// puts the date in user timezone
	var date = new Date(parseFloat(formattime[i].innerText)*1000);
   formattime[i].innerText = (
	   date.toLocaleString('en-US', {weekday:'long',timeZone:tz}) + " " +
	   date.toLocaleString('en-US', {month: 'long', day: 'numeric',timeZone:tz}) + " @ " +
	   date.toLocaleString('en-US', {hour: 'numeric',minute: 'numeric',hour12: true,timeZone:tz}).toLowerCase().replace(" ","") );
}
</script>

<style>
.mc {
	text-align:center;
}
video, .customimg {
	max-width:100%;
	max-height:400px;
}
</style>

<div style="padding:0px 8px;">
<?php 

$page = json_decode(file_get_contents("/swamp/www/cache/newsposts.json"));
foreach ($page as $post) {
?>
<div>
<h2><?=$post->title?></h2>


<p style="padding:8px 0px;">
	<?=preg_replace(
		'/<a href="([^ ]+\.png|jpg)">[^ ]+<\/a>/',
		'<div class="mc"><img class="customimg" src="${1}"></div>',
	preg_replace(
		'/<a href="([^ ]+)\.(mp4|webm)">[^ ]+<\/a>/',
		'<div class="mc"><video controls><source src="${1}.${2}" type="video/${2}">${1}.${2}</video></div>',
		str_replace("\n", "<br>",$post->content)
	))?>
</p>
<div class="row">
<div class="col-lg-6">
<p class="text-muted">
<?=$post->date?>
</p>
</div>
<div class="col-lg-6">
<p class="pull-right">
<a class="color hoverul" href="<?=$post->link?>"><?=$post->upvotes?> <img src="/s/img/icon_rate.png"> &nbsp; <?=$post->comments?> <img src="/s/img/icon_comments.png"> &nbsp; on Steam Community >></a>
</p>
</div>
</div>
<hr>
<br>
</div>
<?php
}
?>
</div>


</div><!--column-->

<div class="col-lg-4">
<div class="well">
	<div class="text-center"><strong>Server rules</strong></div>
	<ol>
		<li>Absolutely no pedophiles</li>
		<li>No disgusting shock vids/pics</li>
		<li>No calls for violence/suicide</li>
		<li>No hackers (get a life)</li>
	</ol>
	<a href="/rules">Full rules</a>
</div>

<div class="well">
	<div class="text-center"><strong>Want DOUBLE POINTS?</strong></div>
	<script>
	function steamgroup() { console.log("RUNLUA:MOTDWINDOW:Close() timer.Simple(0.1, function() gui.OpenURL('https://steamcommunity.com/groups/swampservers') end)"); }
	</script>
	<div class="text-center">
	<img style="width:48px;" src="/s/img/steamlogo.png"> &nbsp; <a onclick='steamgroup()' href="https://steamcommunity.com/groups/swampservers">Join us on Steam!</a> &nbsp; <img style="width:48px;" src="/s/img/steamlogo.png">
	</div>
</div>

<div class="well" style="font-size:12pt;">
	<div class="text-center">For even more points, add <em>swamp.sv</em> to your Steam name for 10,000 per day upon login!</div>
</div>

<!-- <div class="well" style="font-size:12pt;">
<div class="text-center"><strong>Richest players</strong></div>
	
	<?php 
		$stuff = SQL_Query("SELECT points FROM users WHERE id64!=0 ORDER BY points DESC LIMIT 5",[]);

?><ul><?php
		foreach($stuff->data as $thing) {

			?>
			<li> Anonymous: <?=number_format($thing->points)?> 
			</li>
			<?php
		}

		?></ul><?php
		?>
</div> -->


<!-- TOTD STUFF -->
<div class="well">
	<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST["thought"]) || strlen(trim($_POST["thought"])) < 2 || strlen($_POST["thought"]) > 100) {
        $msg = "Error: Invalid thought";
    } else {
        $filename = "/swamp/www/thoughts/ips/" . preg_replace("/[^A-Fa-f0-9]/", "x", GetRequestIP());
        if (file_exists($filename) && (filemtime($filename)) < (time() - (3600 * 24))) {
            unlink($filename);
        }
        if (file_exists($filename)) {
            $msg = "You can only submit one thought per day!";
        } else {
            $msg = "Thought added successfully!";
            file_put_contents($filename, "ip");
            try_add_thought(str_replace("\n", "", htmlspecialchars(trim($_POST["thought"]))));
        }
    }
    ?>
	<div class="text-center"><strong><?=$msg?></strong></div>
	<?php
} else {
    ?>
			<div class="text-center"><strong>Thought of the day </strong><span style="font-size:10pt;">(for loading screen)</span></div>
			<div class="text-center" style="margin:4px auto;">
				<form action="" method="post">
					<input type="text" name="thought" maxlength="100" size="30">
					<br>
					<input style="margin-top:8px;" type="submit" value="Submit">
				</form>
			</div>	
	<?php
}
?>
</div>


<div class="well">
	<div class="text-center"><strong>Recent updates</strong></div>
	<?php
$junk = array();

foreach(["/swamp/repos/contrib","/swamp/repos/restricted","/swamp/repos/private"] as $repo) {
	exec('cd '.$repo.'; git log --pretty=format:"%ad:%s" -n 10 --date=unix', $junk);
	// print_r($junk);
}


$stuff = array();
foreach($junk as $x){
	$x = explode(":",$x,2);
	if ($x[1]=="glualint" || strtolower($x[1])=="merge") { continue; }
	if (in_array(strtolower($x[1]), ["garry's mod","work","stuff"])) { 
		$x[1]="<em>Undocumented changes</em>"; 

	} else {
		$x[1]="<strong>".$x[1]."</strong>";
	}
	$x[1] = str_replace( "cannon","swampmap", $x[1]);
	array_push($stuff, $x);
}

usort($stuff, function($a, $b) {
    return $b[0] -$a[0];
});


function plural($one, $val) {
	if ($val==1) {
		return "1 ".$one;
	} else {
		return $val." ".$one."s";
	}
}
function zdateRelative($date)
{
    $diff = time() - $date;
    if ($diff < 60){
        return plural("second", $diff);
    }
    $diff = floor($diff/60);
    if ($diff < 60){
        return plural("minute", $diff);
    }
    $diff = floor($diff/60);
    if ($diff < 24){
        return plural("hour", $diff);
    }
    $diff = floor($diff/24);
    if ($diff < 7){
        return plural("day", $diff);
    }
	$diff = floor($diff / 7);
	return plural("week", $diff);
}


$lasttime = 0;
$lastmsg = "";
$count = 0;
foreach($stuff as $thing) {
	$datestr = zdateRelative($thing[0]);
	
	if ($lastmsg == $datestr.$thing[1]) {
		continue;
	}
	
	$lasttime = $thing[0];
	$lastmsg = $datestr.$thing[1];
	?><div style="text-indent:-2em;padding-left:2em;"><span style="font-size:10pt;"><?=$datestr?> ago:</span> <?=$thing[1]?></div><?php
	$count=$count+1;
	if ($count==15) {
		break;
	}
}


// exec('cd /swamp/repos/contrib; git log --pretty=format:"%ad: %s" --relative-date -n 10', $junk);
// exec('cd /swamp/cinema/garrysmod/addons/swampcinema; git log --pretty=format:"%ad: %s" --relative-date -n 5', $junk2);
// echo implode("<br>", $junk);
?>
</div>


<div class="well">
	<div class="text-center">
	<img style="width:48px;transform: scale(1.3333);" src="/s/img/lua2.png"> &nbsp;&nbsp; Experienced coder? &nbsp; <img style="height:48px;" src="/s/img/phpe.png">
	</div>
	<div style="position:relative;top:8px;" class="text-center"><strong><a href="https://swamp.sv/contact">Contact us</a> to apply</strong></div>
</div>




</div> <!--column-->
</div> <!--row-->

<!--
	<div class="text-center">
		<img src="bannermeme<?=rand(1, 2)?>.jpg" width="600" height="170">
	</div>
-->
<?=common_bottom()?>