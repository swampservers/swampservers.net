<!-- This file is subject to copyright - contact swampservers@gmail.com for more information. -->
<html>

<head>
	<title>Swamp Cinema - Video Search</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="description" content="Garry's Mod Cinema gamemode.">
		<meta name="keywords" content="garrysmod,cinema">
		<meta name="author" content="pixelTail Games">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="/css/style.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">

	<style>
	.glyphicon {
		float: right;
	}

	.col-sm-4 {
		padding: 20px;
	}

	.topzone {
		width: 100%;
		height: 80px;
		background-position: center;
		background-repeat: no-repeat;
	}

	h3 {
		text-align: center;
		margin: 0px;
		margin-top: 8px;
		margin-bottom: 12px;
	}

	.list-group-item {
		background-color: #DDD !important;
		color:black !important;
	}

	a.list-group-item:hover {
		background-color: #FFF !important;
	}

	#ytsearchbutton {
		background:transparent;
		border:0px;
	}

	#ytsearchbutton:hover {
		background-color: #FFF !important;
	}

	#ytsearch {
		padding: 4px;
		border: 2px solid gray;
		width:100%;
		height:100%;
	}

	#ytsearchholder {
		padding: 0px;
		height: 47px;
	}

	#ytsearchinnerholder {
		position: absolute;
		top:3px;
		bottom:3px;
		left:3px;
		right:47px;
	}

	#ytsearchbutton {
		float:right;
		padding:14px;
		width:47px;
		height:47px;
	}

	.videosheader {
		color:#BBB;
		font-style: italic;
		margin-bottom: 20px;
	}

	</style>
</head>
<body>

	<!-- <nav>
		<ul>
			<li><a href="index.html">Swamp Cinema</a></li>
			<li><a href="search.html" class="active">Video Search</a></li>
			<li><a href="plugins.html">Plugin Installation</a></li>
		</ul>
	</nav> -->


	<script>
		function submi(e) {
			window.location.href = "https://www.youtube.com/results?search_query="+document.getElementById("ytsearch").value;
			e.stopPropagation();
			return false;
		}
		function cript(e) {
		    if (e.keyCode == 13) {
		       submi();
		    }
		}
		function noparent(e) {
			e.stopPropagation();
			return false;
		}
	</script>

	<div style="position:absolute;top:32px;left:0;right:0;bottom:0;">
		<section id="content-container">

	<div style="width:840px;margin-left:auto;margin-right:auto;position:relative;top:20%;">
		
		<!--
		<div class="alert alert-info text-center" role="alert" style="padding:8px;">
			<h4>
  			New: Upload your own videos to <a href="http://horatiotube.stream/"><img src="http://horatiotube.stream/videos/userPhoto/logo.png" width="150"></a></h4>
		</div>-->


		<div class="row">
      		<div class="col-sm-4">
      			<div class="topzone" style="background-image:url('youtube.png');background-size:88px;">
					
				</div>
				<h3>YouTube Videos</h3>
				<div class="list-group">
					<span class="list-group-item" id="ytsearchholder">
						<span id="ytsearchinnerholder">
							<input id="ytsearch" type="text" placeholder="YouTube Search" onkeypress="cript(event)" onclick="noparent(event)" />
						</span>
						<button id="ytsearchbutton" onclick="submi(event)">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
					<a class="list-group-item" href="http://www.youtube.com/">YouTube Home<span class="glyphicon glyphicon-home" style="color:#00A;"></span></a>
					<a class="list-group-item" href="http://www.reddit.com/r/videos/">/r/Videos<span class="glyphicon glyphicon-star" style="color:#BA0;"></span></a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="topzone" style="background-image:url('https://swampservers.net/s/emotes/alexjones.png');background-size:128px;">
					
				</div>
				<h3>Other Sites</h3>
				<div class="list-group">
					<a class="list-group-item" href="https://bflix.gg/home">BFlix<span class="glyphicon glyphicon-film" style="color:#800"></span></a>
					<a class="list-group-item" href="https://www.bitchute.com/">BitChute<span class="glyphicon glyphicon-play-circle" style="color:#800"></span></a>
					<a class="list-group-item" href="https://twitch.tv">Twitch.tv<span class="glyphicon glyphicon-eye-open" style="color:#080;"></span></a>
					<a class="list-group-item" href="https://www.soundcloud.com">Soundcloud<span class="glyphicon glyphicon-fire" style="color:#C80;"></span></a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="topzone" style="background-image:url('files.png');background-size:128px;">
					
				</div>
				<h3>Your Content</h3>
				<!--
				<div class="list-group">
					<a class="list-group-item" href="http://horatiotube.stream/">HoratioTube<span class="glyphicon glyphicon-facetime-video" style="color:#C00;"></span></a>
					
					<a class="list-group-item" href="https://swampservers.net/sources">Tutorial:<br>• Dropbox<br>• Web/HLS Files<br>• HLS Livestreaming<span class="glyphicon glyphicon-plus" style="color:#40A;position:relative;top:-32px;"></span></a>
				</div>
				-->
			</div>
		</div>
<!--
		<h4 class="text-center">Other sites... &nbsp;
		<a href="https://twitch.tv"><img src="twitch.png" width="160"></a>
		<a href="https://www.soundcloud.com">
			<img src="soundcloud.png" height="40">
		</a>
		</h4>
-->

	</div>


		</section>
	</div>

	<script type="text/javascript">
	// Event called when a service is hovered
	function hoverService() {
		console.log( "RUNLUA: surface.PlaySound('garrysmod/ui_hover.html');" );
	}

	</script>

<style>
#footer {
	position:absolute;
	bottom:16px;
	left:0px;
	right:0px;
	text-align:center;
	
}
#footer>a {
	color:white;
}	
</style>

<h4 id="footer"><a href="/video/recent">★ Need something to watch? Click here for random videos!</a></h4>

</body>

</html>
