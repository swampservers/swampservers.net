<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<?php

$type = preg_replace("/[^a-z]/", '', isset($_GET["map"]) ? explode("_",$_GET["map"])[0] : "cinema");

$music_settings = [
  "greenroom" => "5cEiOwQXvy0",
  "goosebumps" => "rsEeiIrJy4E",
  "bloodswamps" => "X9qmfhg7Clw",
  "islandvibes" => "cjdkDZ3BStk",
  "holy" => "kQ-I-VQsvko",
  "crickets" => "ih4_1FyVjaY",
  "smile" => "vRF3zgF6Xao:7",
  "temptationrag" => "Z21kNmtOx6I:10",
  "garfield" => "bR5fPDVciSE",
  "csgo" => "Rvi6c8toWJM",
  "despicableme" => "axbUCR1nKRA"
];

$settings = [$type."wallpaper.jpg"];

if ($type == "cinema") {
  $settings = ["v3wallpaper.jpg", "greenroom"];



  if (date("m/d") == "06/19") {
    $settings = ["v3wallpaper.jpg", "garfield"];

  }

  if (date("m") == "10") {
    $settings = ["halloween.jpg", "bloodswamps"];
  }
}
?>

<html>
<head>
<title>Swamp Servers LOADING...</title>
<style>
body {
  background: black url(/s/loading/<?=$settings[0]?>) no-repeat center center fixed;
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

<?php if (isset($settings[1])) { 
  $musicsettings = explode(":", $music_settings[$settings[1]] );
  ?>
  
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
      videoId: '<?=$musicsettings[0]?>',
      loop: 1,
      events: {
        'onReady': onPlayerReady
      },
      autoplay: 1,
      enablejsapi: 1,
    });
  }

  var player_ready = false;
  function onPlayerReady(event) {
    player_ready = true;
    //event.target.setVolume(0);
    <?php if (isset($musicsettings[1])) {?>
    player.seekTo(<?=$musicsettings[1]?>);
    <?php }?>
    
    // document.getElementById("videoname").innerText = event.target.getVideoData().title;
  }


  var gotGameDetails = false;
  function GameDetails(servername, serverurl, mapname, maxplayers, steamid, gamemode, volume) {
    gotGameDetails = true;
    player.setVolume(volume*100);
    setInterval(function() {  
      if (player_ready && player.getPlayerState() != 0 && player.getPlayerState() != 1) {
        player.playVideo();
      }
    }, 100);
    //document.getElementById("output").innerText = mapname + " " + volume;
  }

  setTimeout(function() {
    if (!gotGameDetails) { console.log("DEFAULT LOAD"); GameDetails("servername", "serverurl", "map_name", 128, "STEAM_ID", "gamemode", 1); }
  }, 1000);

</script>

<div style="position: absolute;top: 50%;left:64px;">
<div class="sctext"><img src="/s/loading/sideways2.png"></div>
</div>

<div style="margin:32px;line-height:160%;position:fixed;bottom:0px;left:0px;right:0px;font-size:18px;text-align:center;">
<strong>Thought of the day:</strong><br>"<?php

    $badwords = array(
        " nig",
        " kike",
        " jew",
        " fag",
        " kkk ",
        " klan ",
        " lynch ",
        " cum",
        " cock",
        " dick",
        " ass ",
        " butthole",
        " asshole",
        " anus",
        " penis",
        " vagina",
        " fuck",
        " puss",
        " shit",
        " suck",
        " rape",
        " rapist",
        " nude",
        " hitler",
        " heil",
        " fap",
        " porn",
        " anal",
    );

    $file = file($THOUGHTFILEPATH, FILE_IGNORE_NEW_LINES);

    for ($i = 0; $i < 1000; $i++) {
        $str = $file[rand(0, count($file) - 1)];
        $str2 = " " . strtolower($str) . " ";

        $ok = true;
        foreach ($badwords as &$value) {
            if (strpos($str2, $value) !== false) {
                $ok = false;
            }
        }

        if ($ok) {
            echo $str;
            break;
        }
    }

    ?>" <!--<br><em style="font-size:10pt;">(user submitted)</em>-->
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

<div id="output"></div>

</body>
</html>
