<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>
<html>
<head>
</head>
<body>


<script>

      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.

      <?php if ($_GET['t'] == "vapor" || $_GET['t'] == "gym") {?>
      var volumeMod=0.8;
      <?php } else if ($_GET['t'] == "helltaker") {?>
      var volumeMod=1;
      <?php } else {?>
      var volumeMod=0.5;
      <?php }?>

      var basevol = <?=isset($_GET['v']) ? filter_var($_GET['v'], FILTER_SANITIZE_NUMBER_INT) : 100?>;
      var atten = -0.5;
      var attentarget = 1;

      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '0',
          width: '0',
          <?php if ($_GET['t'] == "vapor") {?>
          videoId: 'SEZ4b8ulFq8',
          <?php } elseif ($_GET['t'] == "treatment") {?>
          videoId: '-npBowNYDfg',
          <?php } elseif ($_GET['t'] == "gym") {?>
          videoId: 'kN97xHbQTHI',
          <?php } elseif ($_GET['t'] == "cavern") {?>
          videoId: 'xM5EyW-wJ1k',
          <?php } elseif ($_GET['t'] == "cavernalt") {?>
          videoId: '-erU20cQO_Y',
          <?php } elseif ($_GET['t'] == "cavernnight") {?>
          videoId: 'QT8vuiS0cpQ',
          <?php } elseif ($_GET['t'] == "helltaker") {?>
          videoId: 'GzeBHIto4Ps',
          <?php } else {
    die(" DIE SKID SCUM");
}?>
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }


        function onPlayerReady(event) {
        	player.ready = true;
          player.setVolume(basevol*Math.max(atten,0)*volumeMod);
          <?php if ($_GET['t'] == "vapor") {?>
          player.seekTo(<?=time() % 2867?>);
          <?php }?>
          <?php if ($_GET['t'] == "gym") {?>
          player.seekTo(<?=time() % 726?>);
          <?php }?>
          player.playVideo();
      }
           function onPlayerStateChange(e) {
           	        if (e.data === YT.PlayerState.ENDED) {
            player.seekTo(0);
            player.playVideo();
        }
      }

      function setVolume(v) {
        basevol = v;
        player.setVolume(basevol*Math.max(atten,0)*volumeMod);
      }

      function setAttenuation(a) {
        attentarget = a;
        player.setVolume(basevol*Math.max(atten,0)*volumeMod);
      }

      setInterval(function(){
        atten += Math.min(Math.max(attentarget-atten,-0.05),0.05);
        player.setVolume(basevol*Math.max(atten,0)*volumeMod);
      }, 50);


</script>

</div>

<div id="player" style="display:none;"></div>


</body>
</html>