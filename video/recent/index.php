<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>

<?=common_top("Playlists")?>

<!-- <h1 class="text-center">Rules</h1> -->

<style>
.video {
	height:200px;
	background-size:cover;
	margin-bottom:32px;
}

</style>

<div class="row">

<div class="col-xs-4">
<?php

$max = 30;

$vids = SQL_Query("SELECT * FROM cinema_cache WHERE `type`='youtube' ORDER BY expire_t DESC LIMIT ".$max,[])->data;


for ($i=0;$i<$max;$i++) {
	$vid = $vids[$i];



	if ($i>0 && $i % ($max/3) == 0) {
		?>
		</div>
		<div class="col-xs-4">
<?php
	}


	?>
	<div class="video" style="background-image:url(<?=$vid->thumb?>);">
	<?=$vid->title?>

	</div>
	<?php
}
?>
</div>

</div>

<?=common_bottom()?>
