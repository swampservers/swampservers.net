<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?php
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

$type = "cinema";
$wallpaper = "v3wallpaper";
if (isset($_GET["map"])) {
    if (startsWith($_GET["map"], "fatkid")) {
        $type = "fatkid";
        $wallpaper = "fatkidwallpaper";
    }
    if (startsWith($_GET["map"], "duckhunt")) {
        $type = "duckhunt";
        $wallpaper = "duckwallpaper";
    }
    if (startsWith($_GET["map"], "spades")) {
        $type = "spades";
        $wallpaper = "spadeswallpaper";
    }
}
?>

<html>
<head>
<title>Swamp Servers LOADING...</title>
<style>
body {
  background: black url(/loading/<?=$wallpaper?>.jpg) no-repeat center center fixed;
  background-size: cover;
}
<?php if ($type == "cinema") {?>
div {
  color: white;
  font-family: cursive;
}
@font-face {
  font-family: 'Righteous';
  font-style: normal;
  font-weight: 400;
  src: local('Righteous'), local('Righteous-Regular'), url(https://fonts.gstatic.com/s/righteous/v5/w5P-SI7QJQSDqB3GziL8XVtXRa8TVwTICgirnJhmVJw.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}
.sctext {
  transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -ms-transform: translateX(-50%) translateY(-50%);
  -o-transform: translateX(-50%) translateY(-50%);
  color: white;
}

<?php }?>

</style>
</head>
<body>

<?php if ($type == "cinema") {?>

<div id="player" style="display:none;"></div>

<script>
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '390',
      width: '640',
      videoId: 'vRF3zgF6Xao', //'ih4_1FyVjaY',
      loop: 1,
      events: {
        'onReady': onPlayerReady
      }
    });
  }

  function onPlayerReady(event) {
    //event.target.setVolume(0);
    event.target.seekTo(7);
    event.target.playVideo();
    // document.getElementById("videoname").innerText = event.target.getVideoData().title;
    // document.getElementById("videonameouter").style.display="block";
  }
  function GameDetails(servername, serverurl, mapname, maxplayers, steamid, gamemode, volume) {
      player.setVolume(volume*10);
  }

</script>

<div style="position: absolute;top: 50%;left:48px;">
<div class="sctext"><img src="sideways.png"></div>
</div>

<div style="margin:12px;line-height:160%;position:fixed;bottom:0px;left:0px;right:0px;font-size:18px;text-align:center;">
<strong>Thought of the day:</strong><br>"<?php

    include $_SERVER['DOCUMENT_ROOT'].'/lib/secrets.php';
    $file = file($THOUGHTFILEPATH, FILE_IGNORE_NEW_LINES);
    $str = $file[rand(0, count($file) - 1)];
    echo $str;
    ?>"
</div>

<!--
<div style="margin:14px;position:fixed;left:0px;bottom:0px;font-size:12px;text-align:left;display:none;" id="videonameouter">
  You're listening to:<br><span id="videoname" style="font-weight:bold;font-size:14px;">-</span>
</div>
-->

<?php }?>

<?php if ($type == "spades") {?>

<div style="font-family:monospace;margin:12px;line-height:160%;position:fixed;bottom:0px;left:0px;right:0px;font-size:18px;text-align:center;color:white;">
<strong>Gamemode is "Ace of Spades" in the GMod server browser</strong>
</div>
<?php }?>

</body>
</html>
