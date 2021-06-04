<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?=common_top("Swamp Servers - News")?>

<div class="row">
<div class="col-lg-8">

<div class="well">
	<div class="text-center"><strong>IMPORTANT: The DOUBLE POINTS perk is once again tied to our STEAM GROUP because Discord <a href="/discord">literally banned us for not protecting child molestors</a></strong></div>
	<script>
	function discordgroup() { console.log("RUNLUA:MOTDWINDOW:Close() timer.Simple(0.1, function() gui.OpenURL('https://steamcommunity.com/groups/swampservers') end)"); }
	</script>
	<div class="text-center">
	<img style="width:48px;" src="/s/img/steamlogo.png"><img style="width:48px;" src="/s/img/soy1.png"> &nbsp;
	<a onclick='discordgroup()' href="https://steamcommunity.com/groups/swampservers">Join our STEAM GROUP today for DOUBLE POINTS!</a>
		&nbsp; <img style="width:48px;" src="/s/img/soy1.png"><img style="width:48px;" src="/s/img/steamlogo.png">
	</div>
</div>


<h1 class="text-center">News</h1>

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




<!-- STEAM NEWS -->
<div style="padding:0px 8px;">
		<?php 
$page = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/cache/newsfile.txt");
$start = strpos($page, "large_title");
$notfirst = false;
$errorfree = 0;
while ($start) {
if ($errorfree > 20) {die("error");}
$errorfree = $errorfree + 1;
$hrefstart = strpos($page, "href=\"", $start) + 6;
$hrefend = strpos($page, "\"", $hrefstart);
$datestart = strpos($page, "announcement_byline\">", $start) + 21;
$dateend = strpos($page, "-", $datestart);
$start = strpos($page, ">", $start) + 1;
$end = strpos($page, "<", $start);
?>
<div>
<h2><?=substr($page, $start, $end - $start)?></h2>

<p style="padding:8px 0px;">
<?php
$start = strpos($page, "bodytext", $end);
$start = strpos($page, ">", $start) + 1;
$end = strpos($page, "</div>", $start);
echo str_replace(" target=\"_blank\"", "", str_replace("https://steamcommunity.com/linkfilter/?url=", "", substr($page, $start, $end - $start)));
?>
</p>

<div class="row">
<div class="col-lg-6">
<p class="text-muted">
<?=trim(substr($page, $datestart, $dateend - $datestart))?>
</p>
</div>
<div class="col-lg-6">
<p class="pull-right">
<a class="color hoverul" href="<?=substr($page, $hrefstart, $hrefend - $hrefstart)?>">View on Steam Community >></a>
</p>
</div>
</div>
<hr>
<br>
</div>
<?php
$notfirst = true;
$start = strpos($page, "large_title", $start);
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
		<li>No porn unless you're underground</li>
		<li>No hackers (get a life)</li>
	</ol>
	<a href="/rules">Full rules</a>
</div>

<div class="well">
	<!--<div class="text-center"><strong>Want DOUBLE POINTS?</strong></div>-->
	<script>
	function steamgroup() { console.log("RUNLUA:MOTDWINDOW:Close() timer.Simple(0.1, function() gui.OpenURL('https://steamcommunity.com/groups/swampservers') end)"); }
	</script>
	<div class="text-center">
	<img style="width:48px;" src="/s/img/steamlogo.png"> &nbsp; <a onclick='steamgroup()' href="https://steamcommunity.com/groups/swampservers">Join our Steam group!</a> &nbsp; <img style="width:48px;" src="/s/img/steamlogo.png">
	</div>
</div>

<div class="well">
	<div class="text-center"><strong>Help wanted (PAID)</strong></div>
	<div class="text-center">
	<img style="width:48px;transform: scale(1.3333);" src="/s/img/lua2.png"> &nbsp;&nbsp; <a href="https://github.com/swampservers/contrib">Experienced coder?</a> &nbsp; <img style="height:48px;" src="/s/img/phpe.png">
	</div>
</div>

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
			<div class="text-center"><strong>Thought of the day</strong></div>
			<div class="text-center" style="margin:4px auto;">
				<form action="" method="post">
					<input type="text" name="thought" autofocus="autofocus" maxlength="100" size="30">
					<br>
					<input style="margin-top:8px;" type="submit" value="Submit">
				</form>
			</div>
			<div class="text-center" style="font-size:10pt;"><em>Messages will be shown randomly on the loading screen</em></div>
	<?php
}
?>
</div>


<div class="well">
	<div class="text-center"><strong>Recent updates</strong></div>
	<?php
$junk = array();
exec('cd /swamp/cinema/garrysmod/addons/contrib; git log --pretty=format:"%ad: %s" --relative-date -n 10', $junk);
// exec('cd /swamp/cinema/garrysmod/addons/swampcinema; git log --pretty=format:"%ad: %s" --relative-date -n 5', $junk2);
echo implode("<br>", $junk);
?>
</div>

</div> <!--column-->
</div> <!--row-->

<!--
	<div class="text-center">
		<img src="bannermeme<?=rand(1, 2)?>.jpg" width="600" height="170">
	</div>
-->
<?=common_bottom()?>