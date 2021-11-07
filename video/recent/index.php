<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>

<?php 

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"gmod")===FALSE) {
	die();
}


$NoHeader=true; ?>

<?=common_top("Random Videos")?>

<!-- <h1 class="text-center">Rules</h1> -->

<div style="overflow:auto;font-size:20px;">
Random Videos <?php
if (isset($_GET["search"]) && $_GET["search"]!="") {
	?>
- Search: <?=htmlspecialchars($_GET["search"])?> <a href="<?=$_SERVER['PHP_SELF']?>">(clear)</a>
	<?php
}
?>
<form action="" method="get" style="float:right;">
  <input style="display:inline;" type="text" name="search" placeholder="Search">
  <input style="display:inline;" type="submit" value="Search">
</form>
</div>


<style>
.video {
	height:200px;
	background-size:cover;
	margin-bottom:32px;
	cursor: pointer; 
}

.video2 {
	/* margin-top:150px; */
	background-color: rgba(0,0,0,0.5);
}

</style>



<div class="row">

<div class="col-xs-4">
<?php

$max = 8;

if (isset($_GET["search"]) && $_GET["search"]!="") {

	function tryy($time,$offset,$max) {
		try {
			return SQL_Query("SET STATEMENT max_statement_time=".$time." FOR SELECT * FROM cinema_cache WHERE `type`='youtube' AND `title` LIKE ? ORDER BY expire_t DESC LIMIT ".($max*3)." OFFSET ".rand(0,$offset),["%".$_GET["search"]."%"])->data;
		} catch (Exception $e) {
			return [];
		}
	}

	$vids = tryy(2, 1000, $max);


	if (empty($vids)) {
		$vids = tryy(1, 100, $max);
		if (empty($vids)) {
			$max = 4;
			$vids = tryy(2, 0, $max);
		}
	}
} else {
	function tryy($max) {
		try {
			//TODO add a duration setting
			// AND duration<300 AND duration>0
			return SQL_Query("SET STATEMENT max_statement_time=5 FOR SELECT * FROM cinema_cache WHERE `type`='youtube' ORDER BY expire_t DESC LIMIT ".($max*3)." OFFSET ".rand(0,10000),[])->data;
		} catch (Exception $e) {
			return [];
		}
	}

	$vids = array_merge(tryy($max/2),tryy($max/2));
}

for ($i=0;$i<count($vids);$i++) {
	$vid = $vids[$i];

	if ($i>0 && $i % $max == 0) {
?>

</div>
<div class="col-xs-4">

<?php
	}


	?>
	<div class="video" style="background-image:url(<?=$vid->thumb?>);" onclick="console.log('RVIDEO:https://www.youtube.com/watch?v=<?=$vid->key?>')">
	<div class="video2"><?=$vid->title?> (<?=sprintf('%01d:%02d', $vid->duration/ 60, $vid->duration% 60)?>)</div>

	</div>
	<?php
}
?>
</div>

</div>

<h1 class="text-center"><a href="<?=$_SERVER['REQUEST_URI']?>">Load more</a></h1>

<?=common_bottom()?>
