<?php //This file is subject to copyright - contact swampservers@gmail.com for more information. ?>

<?php 
global $NoBodyContainer;
$NoBodyContainer=true;
?>

<?=common_top("")?>

<?php
$serverdata = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/cache/servers.txt'), true);
?>

<!-- this is the page body lmao -->
<link href="css/landing_page.min.css" rel="stylesheet">


<style>
  .carousel-overlay {
    position:absolute;
    z-index: 99999;
    top:0px;
    left:0px;
    right:0px;
  }
  .carousel-overlay-text {
    background: rgba(0,0,0,50%);
    padding-top:12px;
    padding-bottom:4px;
  }
  .carousel-overlay-text > h1 {
    margin-top:0px;
  }
  .spacer > h1 {
    font-size:60px;
  }
  .spacer > h4 {
    margin-bottom:0px;
  }
  .spacer {
    padding-top: 72px;
    padding-bottom: 12px;
    text-align: center;
    /* background: #111 url(/s/img/noise.png); */

    /* background: #393939;
    background-image: url(/s/img/titlebackground.png);
    background-repeat: repeat-x;
    background-size: auto 100%;
    background-position: center; */

  }
  .server-btn-group-holder {
    margin-top: 8px;
  }
  /* ITS NOT CENTERED */
  .parallax {
    background-position: center !important;
    background-size: cover !important;
  }

  .myparallax {
    background-position: center;
    background-size: cover !important;
  }


  .mask {
    background: linear-gradient(to right, rgba(9, 14, 11, 0.4), rgba(9, 14, 11, 0.4)) !important;
  }

</style>

<section class="top">
  <div class="top">
		<div class="mask"></div>
		<div class="title">
			<h1>Welcome to the Swamp</h1>
			<h2>We are a unique Garry's Mod gaming community</h2>
      <div class="text-center">
        <ul style="display:inline-block;text-align:left;font-size:22px;">
          <li>Custom-built servers that perform well and download fast</li>
          <li>Minimal rules and lenient, down-to-earth staff</li>
        </ul>
      </div>
		</div>
	</div>
	<div class="parallax" style="background:url('/s/screenshots/gamercattle.jpg')"></div>
</section>


<!-- 
background-position-y:100% -->

<!-- <div class="myparallax" style="background:url('/screenshots/gamercattle.jpg');height:800px"></div> -->


<script>

  function cb(ts) {
    
    window.requestAnimationFrame(cb);

    var els = document.getElementsByClassName("myparallax");

    for (var i=0;i<els.length;i++) {
      var el = els[i];

      var rect = el.getBoundingClientRect();

      // dist from top
      // var totop = rect.y
      // var tobottom = window.innerHeight - rect.bottom
      // var ratio = Math.abs(totop) /  (Math.abs(totop) + Math.abs(tobottom));

      // var toptopagebottom = window.innerHeight - rect.y;
      // var bottomtopagetop = rect.bottom;
      // var ratio = Math.abs(bottomtopagetop) /  (Math.abs(toptopagebottom) + Math.abs(bottomtopagetop));

      var ratio = (rect.y / (window.innerHeight - rect.height));

      // console.log(rect);

      el.style.backgroundPositionY = (ratio*100) + "%";
      el.style.backgroundPositionX = "50%";

    }

  }

  // window.requestAnimationFrame(cb);

</script>


<!-- <div style="height:800px">
  Test
  <div class="parallax" style="background:url('/screenshots/gamercattle.jpg')"></div>
</div> -->



<!-- 
<div id="main-carousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#main-carousel" data-slide-to="1" class=""></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <div style="background:url('/screenshots/server_room.png')" class="slider-size">
        <div class="caption">
          <p>Our servers download quickly, perform well, and are custom-built from the ground up.</p>
        </div>
      </div>
    </div>
    <div class="item">
      <div style="background:url('/screenshots/statue.png')" class="slider-size">
        <div id="cinema2" class="slider-size">
          <div class="caption">
            <p>Our rules are minimal and easy to follow, and our staff is very down-to-earth.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->



<!-- <section class="top">
    <div class="top">
		<div class="mask"></div> -->
		<!-- <div class="title"> -->

    <!-- <div class="text-center">
        <h1>Swamp Cinema</h1>

        <h4 class="text-center"> A casual, chaotic social game based around a virtual movie theater. </h4>

        <div class="btn-group" role="group" aria-label="...">
          <span class="btn btn-default fake-button">IP: <?=$serverdata['cinema']['ip']?></span>
          <span class="btn btn-primary fake-button"><?=$serverdata['cinema']['players']?> players online</span>
          <a class="btn btn-success" href="steam://connect/cinema.swampservers.net:27015" role="button">Join &raquo;</a>
        </div>
      </div>

		</div> -->


	<!-- </div>
	<div class="parallax" style="background:url('/screenshots/swampcinemadk.jpg')"></div>
</section> -->

<div class="spacer">
  <h1>Swamp Cinema</h1>
  <h4>A casual, chaotic social game based around a virtual movie theater.</h4>
</div>

<div id="cinema-carousel" class="carousel slide" data-ride="carousel">

  <div class="carousel-overlay text-center">
    <!-- <div class="carousel-overlay-text">
      <h1>Swamp Cinema</h1>
      <h4>A casual, chaotic social game based around a virtual movie theater.</h4>
    </div> -->
    <div class="server-btn-group-holder">
      <div class="btn-group" role="group" aria-label="...">
        <span class="btn btn-default fake-button">IP: <?=$serverdata['cinema']['ip']?></span>
        <span class="btn btn-primary fake-button"><?=$serverdata['cinema']['players']?> players online</span>
        <a class="btn btn-success" href="steam://connect/cinema.swamp.sv:27015" role="button">Join &raquo;</a>
      </div>
    </div>
  </div>

  <ol class="carousel-indicators">
    <li data-target="#cinema-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#cinema-carousel" data-slide-to="1" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="2" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="3" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="4" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="5" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="6" class=""></li>
    <li data-target="#cinema-carousel" data-slide-to="7" class=""></li>
    <!-- <li data-target="#cinema-carousel" data-slide-to="8" class=""></li> -->
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
       <div  class="slider-size" style="background:url('/s/screenshots/fulltheater.jpg')">
        
       <!-- <div style="position:fixed" class="slider-size">
        <div class="parallax" style="position:fixed;background:url('/screenshots/swampcinemadk.jpg')"></div>
      </div> -->

        <div class="caption">
          One of the most unique and popular servers in GMod.
        </div>
      </div>
    </div>
    <div class="item">
      <div style="background:url('/s/screenshots/rocketlaunch.jpg')" class="slider-size">
        <div class="caption">
          Explore the vast map full of discoveries above and below ground!
        </div>
      </div>
    </div>

    <div class="item">
      <div style="background:url('/s/screenshots/chess.jpg')" class="slider-size">
        <div class="caption">
          Play minigames such as chess, golf, slots, and dodgeball!
        </div>
      </div>
    </div>

    <div class="item">
      <div style="background:url('/s/screenshots/spookyponies.jpg')" class="slider-size">
        <div class="caption">
          <!-- Build your own secluded theater and hang out with your friends! -->
          Collect and customize props to build theaters, bases, and more!
        </div>
      </div>
    </div>


    <!-- <div class="item">
      <div style="background:url('/screenshots/carousel/cinema/screenshot_2.jpg')" class="slider-size">
        <div class="caption">
          Save up points and trade unique items with other players!
        </div>
      </div>
    </div> -->

    <div class="item">
      <div style="background:url('/s/screenshots/mirror.jpg')" class="slider-size">
        <div class="caption">
          Customize your character - are you a human or a pony?
        </div>
      </div>
    </div>


    <div class="item">
      <div style="background:url('/s/screenshots/gamerfight.jpg')" class="slider-size">
        <div class="caption">
          Find unique weapons and fight other players for control of the theaters. RDM anyone you want!
        </div>
      </div>
    </div>

    <div class="item">
      <div style="background:url('/s/screenshots/garfields.jpg')" class="slider-size">
        <div class="caption">
          Participate in server-wide events!
        </div>
      </div>
    </div>

    <div class="item">
      <div style="background:url('/s/screenshots/bedroom.jpg')" class="slider-size">
        <div class="caption">
          Or, just hang out for a casual night of YouTube videos.
        </div>
      </div>
    </div>

  </div>
  <a class="left carousel-control" href="#cinema-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#cinema-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<div class="spacer">
  <h1>Fat Kid</h1>
  <h4>Our remake of the classic Halo 3 custom game.</h4>
</div>

<!-- 

<section class="top">
  <div class="top">
		<div class="mask"></div>
		<div class="title">
			<h1>Fat Kid</h1>

      <h4 class="text-center"> A casual, chaotic social game based around a virtual movie theater. </h4>
			
      <div class="text-center">
        <div class="btn-group" role="group" aria-label="...">
          <span class="btn btn-default fake-button">IP: <?=$serverdata['fatkid']['ip']?></span>
          <span class="btn btn-primary fake-button"><?=$serverdata['fatkid']['players']?> players online</span>
          <a class="btn btn-success" href="steam://connect/fatkid.swamp.sv:27015" role="button">Join &raquo;</a>
        </div>
      </div>

		</div>
	</div>
	<div class="parallax" style="background:url('/screenshots/swampcinemadk.jpg')"></div>
</section> -->

<div id="fatkid-carousel" class="carousel slide" data-ride="carousel">

    <div class="carousel-overlay text-center">
    <!-- <div class="carousel-overlay-text">
        <h1>Fat Kid</h1>
        <h4>Our remake of the classic Halo 3 custom game.</h4>
    </div> -->
    <div class="server-btn-group-holder">
      <div class="btn-group" role="group" aria-label="...">
        <span class="btn btn-default fake-button">IP: <?=$serverdata['fatkid']['ip']?></span>
        <span class="btn btn-primary fake-button"><?=$serverdata['fatkid']['players']?> players online</span>
        <a class="btn btn-success" href="steam://connect/fatkid.swamp.sv:27015" role="button">Join &raquo;</a>
      </div>
    </div>
  </div>

			<ol class="carousel-indicators">
				<li data-target="#fatkid-carousel" data-slide-to="0" class="active"></li>
				<li data-target="#fatkid-carousel" data-slide-to="1" class=""></li>
				<li data-target="#fatkid-carousel" data-slide-to="2" class=""></li>
			</ol>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div style="background:url('/screenshots/carousel/fatkid/screenshot_1.jpg')" class="slider-size">
						<div class="caption">
							He's slow, he's obese, and he's hungry. Do whatever it takes to avoid being devoured by the Fat Kid.
						</div>
					</div>
				</div>
				<div class="item">
					<div style="background:url('/screenshots/carousel/fatkid/screenshot_2.jpg')" class="slider-size">
						<div id="cinema2" class="slider-size">
							<div class="caption">
								Numerous weapons are hidden throughout the map. Use them to hold back the Fat Kid and his skeleton army.
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div style="background:url('/screenshots/carousel/fatkid/screenshot_3.jpg')" class="slider-size">
						<div id="cinema2" class="slider-size">
							<div class="caption">
								<b>Autism Alert!</b> Do you have what it takes to beat the Fat Kid and his horde of pony minions?
							</div>
						</div>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#fatkid-carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#fatkid-carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

<?=common_bottom()?>
