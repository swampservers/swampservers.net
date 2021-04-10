if (window.swfobject === undefined) window.swfobject = null;
window.open = function() { return null; }; // prevent popups

var jwinterval;
//youtube
var backupPlayer;

var theater = {

	VERSION: 'Swamp',

	playerContainer: null,
	playerContent: null,
	// closedCaptions: false,
	// language: "en",
	hdPlayback: false,
	player: null,
	volume: 25,
	syncMaxDiff: 5,

	getPlayerContainer: function() {
		if ( this.playerContainer === null ) {
			this.playerContainer = document.getElementById('player-container') ||
				document.createElement('div');
		}
		return this.playerContainer;
	},

	getPlayerContent: function() {
		if ( this.playerContent === null ) {
			this.playerContent = document.getElementById('content') ||
				document.createElement('div');
		}
		return this.playerContent;
	},

	resetPlayer: function() {
		if ( this.player ) {
			this.player.onRemove();
			delete this.player;
		}
		this.getPlayerContainer().innerHTML = "<div id='player'></div>";
	},

	enablePlayer: function() {
		// Show player
		var player = this.getPlayerContainer();
		player.style.display = "block";

		// Hide content
		var content = this.getPlayerContent();
		content.style.display = "none";
	},

	disablePlayer: function() {
		// Hide player
		var player = this.getPlayerContainer();
		player.style.display = "none";

		this.resetPlayer();

		// Show content
		var content = this.getPlayerContent();
		content.style.display = "block";
	},

	getPlayer: function() {
		return this.player;
	},

	loadVideo: function( type, data, startTime ) {

		if ( ( type === null ) || ( data === null ) ) return;
		
		if ( type === "" ) {
			this.disablePlayer();
			return;
		}

		startTime = Math.max( 0, startTime );

		var player = this.getPlayer();

		if(type=="cartoon" && data.substring(0,3)=="jw_") { type="file"; }

		// player doesn't exist or is different video type
		if ( (player === null) || (player.getType() != type) ) {

			this.resetPlayer();
			this.enablePlayer();

			var playerObject = getPlayerByType( type );
			if ( playerObject !== null ) {
				this.player = new playerObject();
			} else {
				this.getPlayerContainer().innerText = "Video type not yet implemented.";
				return;
			}

		}

		this.player.setVolume( (this.volume !== null) ? this.volume : 25 );
		this.player.setStartTime( startTime || 0 );
		this.player.setVideo( data );

	},

	setVolume: function( volume ) {
		this.volume = volume;
		if ( this.player !== null ) {
			this.player.setVolume( volume );
		}
	},

	seek: function( seconds ) {
		var player = this.getPlayer();
		if ( player ) {
			player.seek( seconds );
		}
	},

	enableHD: function() {
		this.hdPlayback = true;
	},

	isHDEnabled: function() {
		return this.hdPlayback;
	},

	sync: function( time ) {

		if ( time === null ) return;

		if ( this.player !== null ) {

			var current = this.player.getCurrentTime();
			if ( ( current !== null ) &&
				( Math.abs(time - current) > this.syncMaxDiff ) ) {
				this.player.setStartTime( time );
			}

		}

	},

	toggleControls: function( enabled ) {
		if ( this.player !== null ) {
			this.player.toggleControls( enabled );
		}
	},

	/*
		Google Chromeless player doesn't support closed captions...
		http://code.google.com/p/gdata-issues/issues/detail?id=444
	*/
	
	enableCC: function() {
		this.closedCaptions = true;
	},

	isCCEnabled: function() {
		return this.closedCaptions;
	}

	/*clickPlayerCenter: function() {
		var evt = document.createEvent("MouseEvents");

		var player = document.getElementById("player");

		var w = player.clientWidth / 2,
			h = player.clientHeight / 2;

		evt.initMouseEvent("click", true, true, window,
			0, 0, 0, w, h, false, false, false, false, 0, null);

		this.getPlayer().dispatchEvent(evt);
	},

	setLanguage: function( language ) {
		this.language = language;
	}
	*/

};


var players = [];

function getPlayerByType( type ) {
	return players[ type ];
}

var DefaultVideo = function() {};
DefaultVideo.prototype = {
	player: null,

	lastVideoId: null,
	videoId: null,

	lastVolume: null,
	volume: 0.123,

	currentTime: 0,

	getCurrentTime: function() {
		return null;
	},

	lastStartTime: 0,
	startTime: 0,

	setVolume: function( volume ) {},
	setStartTime: function( seconds ) {},
	seek: function( seconds ) {},
	onRemove: function() {},
	toggleControls: function() {}
};

function registerPlayer( type, object ) {
	object.prototype = new DefaultVideo();
	object.prototype.type = type;
	object.prototype.getType = function() {
		return this.type;
	};

	players[ type ] = object;
}

/*
	If someone is reading this and trying to figure out how
	I implemented each player API, here's what I did.

	To avoid endlessly searching for API documentations, I
	discovered that by decompiling a swf file, you can simply
	search for "ExternalInterface.addCallback" for finding
	JavaScript binded functions. And by reading the actual 
	source code, things should be much easier.

	This website provides a quick-and-easy way to decompile
	swf code http://www.showmycode.com/

	If you need additional information, you can reach me through
	the following contacts:

	samuelmaddock.com
	samuel.maddock@gmail.com
	http://steamcommunity.com/id/samm5506


	Test Cases

	theater.loadVideo( "youtube", "JVxe5NIABsI", 30 )
	theater.loadVideo( "youtubelive", "0Sdkwsw2Ji0" )
	theater.loadVideo( "vimeo", "55874553", 30 )
	theater.loadVideo( "twitch", "mega64podcast,c4320640", 30*60 )
	theater.loadVideo( "twitch", "cosmowright,c1789194" )
	theater.loadVideo( "twitchstream", "ignproleague" )
	Justin.TV Support removed 8-5-2014
	theater.loadVideo( "blip", "6484826", 60 )
	theater.loadVideo( "html", "<span style='color:red;'>Hello world!</span>", 10 )
	theater.loadVideo( "viooz", "", 0 )

*/
(function() {
	
	var YouTubeIframeVideo = function() {

		var player;

		this.setVideo = function( id ) {
			this.lastStartTime = null;
			this.lastVideoId = null;
			this.videoId = id;

			if (player) { return; }

			player = new YT.Player('player', {
				height: '200%',
				width: '100%',
				videoId: id,
				playerVars: {
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					modestbranding: 1,
					rel: 0,
					iv_load_policy: 3, // hide annotations
					cc_load_policy: theater.closedCaptions ? 1 : 0
				},
				events: {
					onReady: onYouTubePlayerReady,
				}
			});
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
		};

		this.seek = function( seconds ) {
			if ( this.player !== null ) {
				this.player.seekTo( seconds, true );

				// Video isn't playing
				if ( this.player.getPlayerState() != 1 ) {
					this.player.playVideo();
				}
			}
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		this.getCurrentTime = function() {
			if ( this.player !== null ) {
				return this.player.getCurrentTime();
			}
		};

		this.canChangeTime = function() {
			if ( this.player !== null ) {
				//Is loaded and it is not buffering
				return this.player.getVideoBytesTotal() != -1 &&
				this.player.getPlayerState() != 3;
			}
		};

		this.think = function() {

			if ( this.player !== null ) {

				if ( this.videoId != this.lastVideoId ) {
					this.player.loadVideoById( this.videoId, this.startTime );
					this.lastVideoId = this.videoId;
					this.lastStartTime = this.startTime;
				}

				if ( this.player.getPlayerState() != -1 ) {

					if ( this.startTime != this.lastStartTime ) {
						this.seek( this.startTime );
						this.lastStartTime = this.startTime;
					}

					if ( this.volume != this.lastVolume ) {
						this.player.setVolume( this.volume );
						this.lastVolume = this.volume;
					}

				}
			}

		};

		this.onReady = function() {
			this.player = player;

			this.player.getIframe().style.position = "relative";
			this.player.getIframe().style.top = "-50%";

			if ( theater.isHDEnabled() ) {
				this.player.setPlaybackQuality("hd720");
			}

			this.interval = setInterval( this.think.bind(this), 100 );
		};

	};
	registerPlayer( "youtubelive", YouTubeIframeVideo );


	//plays drive and youtube
	//yva_video is a weird thing i found... i think it's supposed to be for ads, but it works for this lol
	var YouTubeFlashVideo = function() {
		
		var params = {
			allowScriptAccess: "always",
			bgcolor: "#000000",
			wmode: "opaque"
		};

		var attributes = {
			id: "player",
		};

		this.setVideo = function( id ) {
			this.lastStartTime = null;
			this.videoId = id;

			var url = 'https://youtube.googleapis.com/apiplayer?enablejsapi=1&amp;autoplay=1&amp;fs=1&amp;hl=en&amp;modestbranding=1&amp;autohide=1&amp;showinfo=0&amp;controls=0';

			if ( theater.isCCEnabled() ) {
				url += "&cc_load_policy=1";
				url += "&yt:cc=on";
			}

			if (id.length > 11) {
				url += '&amp;docid=' + id + '&amp;ps=docs&amp;partnerid=30';
			} 

			swfobject.embedSWF(url, "player", "100.0%", "100.0%", "9", null, null, params, attributes);
		}

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
		};

		this.seek = function( seconds ) {
			if ( this.player != null ) {
				this.player.seekTo( seconds, true );

				if ( this.player.getPlayerState() != 1 ) {
					this.player.playVideo();
				}
			}
			var self = this;
			setTimeout(function() {
				if (self.getCurrentTime() < seconds - 30) {
					self.player.setPlaybackQuality("default");
					setTimeout(function() {
						self.player.seekTo( seconds, true );
					}, 2500);
				}
			}, 2500);
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		this.getCurrentTime = function() {
			if ( this.player != null ) {
				return this.player.getCurrentTime();
			}
		};

		this.think = function() {
			if ( this.player != null ) {
				if ( (typeof(this.player.getPlayerState) === "function") && this.player.getPlayerState() != -1 ) {
					if ( this.startTime != this.lastStartTime ) {
						this.seek( this.startTime );
						this.lastStartTime = this.startTime;
					}
					if ( this.volume != this.player.getVolume() ) {
						this.player.setVolume( this.volume );
						this.volume = this.player.getVolume();
					}
				}
			}
		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			this.player.style.width = "126.6%";
			this.player.style.height = "104.2%";
			this.player.style.marginLeft = "-24.2%";
			this.player.style.marginTop = "-2%";

			this.ytforceres="large";
			
			if (theater.isHDEnabled()) {
				this.ytforceres = "hd720";
			}
			
			if (this.videoId.length <= 11) {
				this.player.loadVideoById( this.videoId, this.startTime, this.ytforceres);
				this.lastStartTime = this.startTime;
			} else {
				this.player.setPlaybackQuality(this.ytforceres);
			}

			var self = this;
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};

	};
	registerPlayer( "youtube", YouTubeIframeVideo );
	registerPlayer( "drive", YouTubeFlashVideo );


	var FileVideo = function() {

		var params = {
			allowScriptAccess: "always",
			bgcolor: "#000000",
			wmode: "opaque"
		};

		var attributes = {
			id: "player",
		};

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastStartTime = null;
			//this.lastVideoId = null;
			id=id.replace(".smil.mp4",".smil");
			this.videoId = id;

			var element = document.getElementById("loadingmessage");
			if(element) {element.parentNode.removeChild(element);}

			if(jwplayer("player")){jwplayer("player").remove();}
			clearInterval( jwinterval );

			//oh somewhere online haha
			jwplayer.key="ZgjVDLYYp9SF59TDwdD3w+U3On19OWR3o2ewkmKOTiY=";

			if(id.substring(0,3)=="jw_") {
				var data = eval(asp.wrap(id.substring(3,id.length)));
				data = [data[data.length-1]];
				console.log(data[0].file);
				jwplayer("player").setup({
					/*playlist: [{        
	                    sources: data
	                }],*/
	                file: data[0].file,
			       	autostart: true,
	      			width: "100%",
	     			height: "100%",
	     			primary: "flash",
	     			controls: false
	     		});
			} else {
				jwplayer("player").setup({
			        file: id,
			       	autostart: true,
	      			width: "100%",
	     			height: "100%",
	     			primary: "flash",
	     			controls: false
	     		});
			}

     		this.player = jwplayer("player");

     		this.player.onReady(onJWPlayerReady);
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
		};

		this.seek = function( seconds ) {
			if ( this.player !== null ) {
				this.player.seek( seconds );		
				this.propertime = seconds;
				this.seekpercent=0;
				this.player.play(true);
			}
		};

		this.onRemove = function() {
			clearInterval( jwinterval );
			this.player.remove();
		};

		this.think = function() {

			if(this.player != null) {
				if ( this.volume != this.player.getVolume() ) {
					this.player.setVolume( this.volume );
					this.volume = this.player.getVolume();
				}
			}

			if ( (this.player !== null) && (this.player.getDuration() > -1) ) {

				this.propertime += 0.5;

				if ( this.startTime != this.lastStartTime ) {
					this.seek( this.startTime );
					this.lastStartTime = this.startTime;
				}

				var maxoffset = 15;
				//if(this.videoId.indexOf("rtmp://") != -1) { maxoffset = 2; }

				if ( this.propertime < this.player.getDuration() && (( this.player.getPosition() + maxoffset < this.propertime ) || ( this.player.getPosition() - maxoffset > this.propertime ))) {
					this.player.seek( this.propertime );
					//console.log(Math.round(this.player.getPosition()) + " / " + Math.round(this.propertime));

					if((document.getElementById("loadingmessage")===null) && (this.videoId.indexOf("rtmp://") == -1) && (this.videoId.indexOf(".smil") == -1)) {
						var div = document.createElement("div");
						this.seekpercent=0;
						div.id = "loadingmessage";
						div.innerHTML = "<img src=\"http://swampservers.net/static/img/loading.gif\" style=\"width:28pt;height:28pt;position:relative;top:4px;\"> Buffering... <span id=\"seekpc\"></span>%<br><span style=\"font-size:14pt;position:relative;bottom:4px;\">Yes this is very slow, tell Garry to replace Awesomium</span>"; 
						document.getElementById("player-container").insertBefore(div,document.getElementById("player_wrapper"));
					}
					if(document.getElementById("seekpc")!==null){
						this.seekpercent=Math.min(Math.max(this.seekpercent,Math.floor(this.player.getBuffer()*this.player.getDuration()/this.propertime)),100);
						document.getElementById("seekpc").innerHTML = this.seekpercent;
					}

				} else {
					var element = document.getElementById("loadingmessage");
					if(element) {element.parentNode.removeChild(element);}
				}
			}

		};

		this.onReady = function() {
			this.player = jwplayer("player");
			
			// Video isn't playing
			this.player.play(true);

			this.propertime = 0;

			clearInterval( jwinterval );
			var self = this;
			jwinterval = setInterval( function() { self.think(self); }, 500 );
		};
	};
	
	registerPlayer( "file", FileVideo );
	registerPlayer( "rtmplive", FileVideo );

	var VimeoVideo = function() {

		var self = this;

		this.froogaloop = null;

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.videoId = id;

			var elem = document.getElementById("player1");
			if (elem) {
				$f(elem).removeEvent('ready');
				this.froogaloop = null;
				elem.parentNode.removeChild(elem);
			}

			var url = "https://player.vimeo.com/video/" + id + "?api=1&player_id=player1";

			var frame = document.createElement('iframe');
			frame.setAttribute('id', 'player1');
			frame.setAttribute('src', url);
			frame.setAttribute('width', '100%');
			frame.setAttribute('height', '100%');
			frame.setAttribute('frameborder', '0');

			document.getElementById('player').appendChild(frame);

			$f(frame).addEvent('ready', this.onReady);
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume / 100;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;

			// Set minimum of 1 seconds due to Awesomium issues causing
			// the Vimeo player not to load.
			this.startTime = Math.max( 1, seconds );
		};

		this.seek = function( seconds ) {
			if ( this.froogaloop !== null && seconds > 1 ) {
				this.froogaloop.api('seekTo', seconds);
			}
		};

		this.onRemove = function() {
			this.froogaloop = null;
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.think = function() {

			if ( this.froogaloop !== null ) {

				if ( this.volume != this.lastVolume ) {
					this.froogaloop.api('setVolume', this.volume);
					this.lastVolume = this.volume;
				}

				if ( this.startTime != this.lastStartTime ) {
					this.seek( this.startTime );
					this.lastStartTime = this.startTime;
				}

				this.froogaloop.api('getVolume', function(v) {
					self.volume = parseFloat(v);
				});

				this.froogaloop.api('getCurrentTime', function(v) {
					self.currentTime = parseFloat(v);
				});

			}

		};

		this.onReady = function( player_id ) {
			self.lastStartTime = null;
			self.froogaloop = $f(player_id);
			self.froogaloop.api('play');
			self.interval = setInterval( function() { self.think(self); }, 100 );
		};

	};
	registerPlayer( "vimeo", VimeoVideo );

	var TwitchVideo = function() {

		var self = this;

		this.videoInfo = {};

		/*
			Embed Player Object
		*/
		this.embed = function() {

			if ( !this.videoInfo.channel ) return;
			if ( !this.videoInfo.archive_id ) return;

			var flashvars = {
				hostname: "www.twitch.tv",
				channel: this.videoInfo.channel,
				auto_play: true,
				start_volume: (this.videoInfo.volume || theater.volume),
				initial_time: (this.videoInfo.initial_time || 0)
			};

			var id = this.videoInfo.archive_id.slice(1),
				videoType = this.videoInfo.archive_id.substr(0,1);

			flashvars.videoId = videoType + id;

			if (videoType == "c") {
				flashvars.chapter_id = id;
			} else {
				flashvars.archive_id = id;
			}

			var swfurl = "http://www.twitch.tv/swflibs/TwitchPlayer.swf";

			var params = {
				"allowFullScreen": "true",
				"allowNetworking": "all",
				"allowScriptAccess": "always",
				"movie": swfurl,
				"wmode": "opaque",
				"bgcolor": "#000000"
			};

			swfobject.embedSWF(
				swfurl,
				"player",
				"100%",
				"104%",
				"9.0.0",
				false,
				flashvars,
				params
			);

		};

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;

			var info = id.split(',');

			this.videoInfo.channel = info[0];
			this.videoInfo.archive_id = info[1];

			// Wait for player to be ready
			if ( this.player === null ) {
				this.lastVideoId = this.videoId;
				this.embed();

				var i = 0;
				var interval = setInterval( function() {
					var el = document.getElementById("player");
					if(el.mute){
						clearInterval(interval);
						self.onReady();
					}

					i++;
					if (i > 100) {
						console.log("Error waiting for player to load");
						clearInterval(interval);
					}
				}, 33);
			}
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
			this.videoInfo.volume = volume;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
			this.videoInfo.initial_time = seconds;
		};

		this.seek = function( seconds ) {
			this.setStartTime( seconds );
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.think = function() {

			if ( this.player ) {
				
				if ( this.videoId != this.lastVideoId ) {
					this.embed();
					this.lastVideoId = this.videoId;
				}

				if ( this.startTime != this.lastStartTime ) {
					this.embed();
					this.lastStartTime = this.startTime;
				}

				if ( this.volume != this.lastVolume ) {
					// this.embed(); // volume doesn't change...
					this.lastVolume = this.volume;
				}

			}

		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};

		this.toggleControls = function( enabled ) {
			this.player.height = enabled ? "100%" : "104%";
		};

	};
	registerPlayer( "twitch", TwitchVideo );

	var TwitchStreamVideo = function() {

		var self = this;

		/*
			Embed Player Object
		*/
		this.embed = function() {

			var flashvars = {
				hostname: "www.twitch.tv",
				hide_chat: true,
				channel: this.videoId,
				embed: 0,
				auto_play: true,
				start_volume: 25 // out of 50
			};

			var swfurl = "http://www.twitch.tv/swflibs/TwitchPlayer.swf";

			var params = {
				"allowFullScreen": "true",
				"allowNetworking": "all",
				"allowScriptAccess": "always",
				"movie": swfurl,
				"wmode": "opaque",
				"bgcolor": "#000000"
			};

			swfobject.embedSWF(
				swfurl,
				"player",
				"100%",
				"104%",
				"9.0.0",
				false,
				flashvars,
				params
			);

		};

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;

			// Wait for player to be ready
			if ( this.player === null ) {
				this.lastVideoId = this.videoId;
				this.embed();

				var i = 0;
				var interval = setInterval( function() {
					var el = document.getElementById("player");
					if(el.mute){
						clearInterval(interval);
						self.onReady();
					}

					i++;
					if (i > 100) {
						console.log("Error waiting for player to load");
						clearInterval(interval);
					}
				}, 33);
			}
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.think = function() {

			if ( this.player ) {

				if ( this.videoId != this.lastVideoId ) {
					this.embed();
					this.lastVideoId = this.videoId;
				}

				 if ( this.volume != this.lastVolume ) {
					// this.embed(); // volume doesn't change...
					this.lastVolume = this.volume;
				}

			}

		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};

		this.toggleControls = function( enabled ) {
			this.player.height = enabled ? "100%" : "104%";
		};

	};
	registerPlayer( "twitchstream", TwitchStreamVideo );

	var BlipVideo = function() {

		var self = this;

		this.lastState = null;
		this.state = null;

		/*
			Embed Player Object
		*/
		var flashvars = {
			autostart: true,
			noads: true,
			showinfo: false,
			onsite: true,
			nopostroll: true,
			noendcap: true,
			showsharebutton: false,
			removebrandlink: true,
			skin: "BlipClassic",
			backcolor: "0x000000",
			floatcontrols: true,
			fixedcontrols: true,
			largeplaybutton: false,
			controlsalpha: ".0",
			autohideidle: 1000,
			file: "http://blip.tv/rss/flash/123123123123", // bogus url
		};

		var params = {
			"allowFullScreen":"true",
			"allowNetworking":"all",
			"allowScriptAccess":"always",
			"wmode":"opaque",
			"bgcolor":"#000000"
		};

		swfobject.embedSWF(
			// "http://a.blip.tv/scripts/flash/stratos.swf",
			"http://blip.tv/scripts/flash/stratos.swf",
			"player",
			"100%",
			"100%",
			"9.0.0",
			false,
			flashvars,
			params
		);

		/*
			play\n") + "pause\n") + "stop\n") + "next\n") + "previous\n") + "volume\n") + "mute\n") + "seek\n") + "scrub\n") + "fullscreen\n") + "playpause\n") + "toggle_hd\n") + "auto_hide_components\n") + "auto_show_components\n") + "show_endcap"));

			ExternalInterface.addCallback("getAvailableEvents", this.getAvailableStateChanges);
			ExternalInterface.addCallback("sendEvent", this.handleJsStateChangeEvent);
			ExternalInterface.addCallback("setPlayerUpdateTime", this.setUpdateInterval);
			ExternalInterface.addCallback("getAllowedEvents", this.displayAllowedEvents);
			ExternalInterface.addCallback("addJScallback", this.addExternallySpecifiedCallback);
			ExternalInterface.addCallback("getPlaylist", this.sendOutJSONplaylist);
			ExternalInterface.addCallback("getDuration", this.getDuration);
			ExternalInterface.addCallback("getPNG", this.getPNG);
			ExternalInterface.addCallback("getJPEG", this.getJPEG);
			ExternalInterface.addCallback("getCurrentState", this.getCurrentState);
			ExternalInterface.addCallback("getHDAvailable", this.getHDAvailable);
			ExternalInterface.addCallback("getCCAvailable", this.getCCAvailable);
			ExternalInterface.addCallback("getPlayerVersion", this.getPlayerVersion);
			ExternalInterface.addCallback("getEmbedParamValue", this.sendOutEmbedParamValue);
		*/

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;

			// Wait for player to be ready
			if ( this.player === null ) {
				var i = 0;
				var interval = setInterval( function() {
					var el = document.getElementById("player");
					if(el.addJScallback){
						clearInterval(interval);
						self.onReady();
					}

					i++;
					if (i > 100) {
						console.log("Error waiting for player to load");
						clearInterval(interval);
					}
				}, 33);
			} else {
				this.player.sendEvent( 'pause' );
			}

		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume / 100;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
		};

		this.seek = function( seconds ) {
			if ( this.player !== null ) {
				this.player.sendEvent( 'seek', seconds );
			}
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/

		this.think = function() {

			if ( (this.player !== null) ) {

				if ( this.videoId != this.lastVideoId ) {
					this.player.sendEvent( 'newFeed', "http://blip.tv/rss/flash/" + this.videoId );
					this.lastVideoId = this.videoId;
					this.lastVolume = null;
					this.lastStartTime = null;
				}

				if ( this.player.getCurrentState() == "playing" ) {

					if ( this.startTime != this.lastStartTime ) {
						this.seek( this.startTime );
						this.lastStartTime = this.startTime;
					}

					if ( this.volume != this.lastVolume ) {
						this.player.sendEvent( 'volume', this.volume );
						this.lastVolume = this.volume;
					}

				}
			}

		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};

	};
	registerPlayer( "blip", BlipVideo );

	var UrlVideo = function() {

		var self = this;

		/*
			Embed Player Object
		*/
		this.embed = function() {

			var elem = document.getElementById("player1");
			if (elem) {
				elem.parentNode.removeChild(elem);
			}

			var frame = document.createElement('iframe');
			frame.setAttribute('id', 'player1');
			frame.setAttribute('src', this.videoId);
			frame.setAttribute('width', '100%');
			frame.setAttribute('height', '100%');
			frame.setAttribute('frameborder', '0');

			document.getElementById('player').appendChild(frame);

		};

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;

			// Wait for player to be ready
			if ( this.player === null ) {
				this.lastVideoId = this.videoId;
				this.embed();

				var i = 0;
				var interval = setInterval( function() {
					var el = document.getElementById("player");
					if(el){
						clearInterval(interval);
						self.onReady();
					}

					i++;
					if (i > 100) {
						console.log("Error waiting for player to load");
						clearInterval(interval);
					}
				}, 33);
			}
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.think = function() {

			if ( this.player ) {
				
				if ( this.videoId != this.lastVideoId ) {
					this.embed();
					this.lastVideoId = this.videoId;
				}

			}

		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};

	};
	registerPlayer( "url", UrlVideo );

	// Thanks to WinterPhoenix96 for helping with Livestream support
	var LivestreamVideo = function() {

		var flashvars = {};

		var swfurl = "http://cdn.livestream.com/chromelessPlayer/wrappers/JSPlayer.swf";
		// var swfurl = "http://cdn.livestream.com/chromelessPlayer/v20/playerapi.swf";

		var params = {
			// "allowFullScreen": "true",
			"allowNetworking": "all",
			"allowScriptAccess": "always",
			"movie": swfurl,
			"wmode": "opaque",
			"bgcolor": "#000000"
		};

		swfobject.embedSWF(
			swfurl,
			"player",
			"100%",
			"100%",
			"9.0.0",
			"expressInstall.swf",
			flashvars,
			params
		);

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume / 100;
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.think = function() {

			if ( this.player !== null ) {

				if ( this.videoId != this.lastVideoId ) {
					this.player.load( this.videoId );
					this.player.startPlayback();
					this.lastVideoId = this.videoId;
				}
				
				if ( this.volume != this.lastVolume ) {
					this.player.setVolume( this.volume );
					this.lastVolume = this.volume;
				}
				
			}

		};
		
		this.onReady = function() {
			this.player = document.getElementById('player');

			var self = this;
			this.interval = setInterval( function() { self.think(self); }, 100 );
			this.player.setVolume( this.volume );
		};
		
	};
	registerPlayer( "livestream", LivestreamVideo );


	var HtmlVideo = function() {

		/*
			Embed Player Object
		*/
		this.embed = function() {

			var elem = document.getElementById("player1");
			if (elem) {
				elem.parentNode.removeChild(elem);
			}

			var content = document.createElement('div');
			content.setAttribute('id', 'player1');
			content.style.width = "100%";
			content.style.height = "100%";
			content.innerHTML = this.videoId;

			document.getElementById('player').appendChild(content);

		};

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastVideoId = null;
			this.videoId = id;
			this.embed();
		};

	};
	registerPlayer( "html", HtmlVideo );


	var VioozVideo = function() {
		// Reference:
		// https://github.com/kcivey/jquery.jwplayer/blob/master/jquery.jwplayer.js

		var flashstream = document.getElementById("flashstream"),
			embed = (flashstream && flashstream.children[4]);
		
		// Make the Player's Div Parent Element accessible
		var flashstream_container = document.getElementById(flashstream.parentNode.id);
		flashstream_container.style.display="initial";
		
		if (embed) {
			// Hide the Banner Ad that overlays the player
			document.getElementById("rhw_footer").style.display="none";
			
			// Force player fullscreen
			document.body.style.setProperty('overflow', 'hidden');
			embed.style.setProperty('z-index', '99999');
			embed.style.setProperty('position', 'fixed');
			embed.style.setProperty('top', '0');
			embed.style.setProperty('left', '0');
			embed.width = "100%";
			embed.height = "105%";

			this.player = embed;
		}

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			this.lastStartTime = null;
		};

		this.setVolume = function( volume ) {
			this.lastVolume = volume;
			if ( this.player !== null ) {
				this.player.jwSetVolume(volume);
			}
		};

		this.setStartTime = function( seconds ) {
			this.seek(seconds);
		};

		this.seek = function( seconds ) {
			if ( this.player !== null ) {
				this.player.jwSetVolume( this.lastVolume );

				var state = this.player.jwGetState();

				if ((state !== "BUFFERING") ||
					(this.getBufferedTime() > seconds)) {
					this.player.jwSeek( seconds );
				}

				// Video isn't playing
				if ( state === "IDLE" ) {
					this.player.jwPlay();
				}
			}
		};

		/*
			Player Specific Methods
		*/
		this.getCurrentTime = function() {
			if ( this.player !== null ) {
				return this.player.jwGetPosition();
			}
		};

		this.getBufferedTime = function() {
			return this.player.jwGetDuration() *
				this.player.jwGetBuffer();
		};

		this.toggleControls = function( enabled ) {
			this.player.height = enabled ? "100%" : "105%";
		};

	};
	registerPlayer( "viooz", VioozVideo );

	//Thanks yookitheater
	var KissAnime = function() {
		
		/*
			Embed Player Object
		*/	
		var params = {
			allowScriptAccess: "always",
			bgcolor: "#000000",
			wmode: "opaque"
		};

		var attributes = {
			id: "player",
		};

		var url = "http://www.youtube.com/get_player?enablejsapi=1&vq=hd720&modestbranding=1&controls=0&showinfo=0";

		/*
			Standard Player Methods
		*/
		this.setVideo = function( id ) {
			// We have to reinitialize the Flash Object everytime we change the video
			this.lastStartTime = null;
			this.lastVideoId = null;
			this.videoId = id;
			
			//Base64 Decode so we can actually use the flashvars
			id = asp.wrap(id);
			
			var flashvars = {};
			
			var k;
			var v;
			for (k in id.split("&")) {
				for (v in id.split("&")[k].split("=")) {
					if ((typeof(id.split("&")[k].split("=")[v - 1]) != "undefined") && (typeof(id.split("&")[k].split("=")[v]) != "undefined")) {
						flashvars[id.split("&")[k].split("=")[v - 1].replace("amp;", "")] = id.split("&")[k].split("=")[v];
					};
				};
			};

			//if ( this.player !== null ) {
				//this.player.remove();
			//}
			clearInterval( this.interval );
			
			swfobject.embedSWF( url, "player", "100%", "100%", "9", null, flashvars, params, attributes );
			
			this.initSeek = false;
		};

		this.setVolume = function( volume ) {
			this.lastVolume = null;
			this.volume = volume;
		};

		this.setStartTime = function( seconds ) {
			this.lastStartTime = null;
			this.startTime = seconds;
		};

		this.seek = function( seconds ) {
			if ( this.player != null ) {
				this.player.seekTo( seconds, true );

				// Video isn't playing
				if ( this.player.getPlayerState() != 1 ) {
					this.player.playVideo();
				}
			}
		};

		this.onRemove = function() {
			clearInterval( this.interval );
		};

		/*
			Player Specific Methods
		*/
		this.getCurrentTime = function() {
			if ( this.player != null ) {
				return this.player.getCurrentTime();
			}
		};

		this.canChangeTime = function() {
			if ( this.player != null ) {
				//Is loaded and it is not buffering
				return this.player.getVideoBytesTotal() != -1 &&
				this.player.getPlayerState() != 3;
			}
		};

		this.think = function() {
			if ( this.player != null ) {
				/*
				if ( theater.isForceVideoRes() ) {
					if ( this.lastWindowHeight != window.innerHeight ) {
						if ( window.innerHeight <= 1536 && window.innerHeight > 1440 ) {
							this.player.setPlaybackQuality("highres");
						}
						if ( window.innerHeight <= 1440 && window.innerHeight > 1080 ) {
							this.player.setPlaybackQuality("highres");
						}
						if ( window.innerHeight <= 1080 && window.innerHeight > 720 ) {
							this.player.setPlaybackQuality("hd1080");
						}
						if ( window.innerHeight <= 720 && window.innerHeight > 480 ) {
							this.player.setPlaybackQuality("hd720");
						}
						if ( window.innerHeight <= 480 && window.innerHeight > 360 ) {
							this.player.setPlaybackQuality("large");
						}
						if ( window.innerHeight <= 360 && window.innerHeight > 240 ) {
							this.player.setPlaybackQuality("medium");
						}
						if ( window.innerHeight <= 240 ) {
							this.player.setPlaybackQuality("small");
						}
						
						this.lastWindowHeight = window.innerHeight;
					}
				}
				*/
				if ( this.videoId != this.lastVideoId ) {
					this.lastVideoId = this.videoId;
					this.lastStartTime = this.startTime;
				}

				if ( this.player.getPlayerState() != -1 ) {
					if ( this.startTime != this.lastStartTime ) {
						this.seek( this.startTime );
						this.lastStartTime = this.startTime;
					}

					if ( this.volume != this.player.getVolume() ) {
						this.player.setVolume( this.volume );
						this.volume = this.player.getVolume();
					}

				}
			}
		};

		this.onReady = function() {
			this.player = document.getElementById('player');
			//this.player.style.marginLeft = "-24.2%";
/*
			if ( theater.isForceVideoRes() ) {
				if ( window.innerHeight <= 1536 && window.innerHeight > 1440 ) {
					this.player.setPlaybackQuality("highres");
				}
				if ( window.innerHeight <= 1440 && window.innerHeight > 1080 ) {
					this.player.setPlaybackQuality("highres");
				}
				if ( window.innerHeight <= 1080 && window.innerHeight > 720 ) {
					this.player.setPlaybackQuality("hd1080");
				}
				if ( window.innerHeight <= 720 && window.innerHeight > 480 ) {
					this.player.setPlaybackQuality("hd720");
				}
				if ( window.innerHeight <= 480 && window.innerHeight > 360 ) {
					this.player.setPlaybackQuality("large");
				}
				if ( window.innerHeight <= 360 && window.innerHeight > 240 ) {
					this.player.setPlaybackQuality("medium");
				}
				if ( window.innerHeight <= 240 ) {
					this.player.setPlaybackQuality("small");
				}
			}
			*/
			var self = this;
			this.interval = setInterval( function() { self.think(self); }, 100 );
		};
		
	};
	registerPlayer( "cartoon", KissAnime );

})();

//ASP junk
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('l 9={f:\'V+/=\',m:U,M:/H/.z(L.K),D:/H[T]/.z(L.K),W:w(s){l 7=9.A(s),5=-1,c=7.v,o,j,i,8=[,,,];b(9.M){l a=[];n(++5<c){o=7[5];j=7[++5];8[0]=o>>2;8[1]=((o&3)<<4)|(j>>4);b(x(j))8[2]=8[3]=t;d{i=7[++5];8[2]=((j&15)<<2)|(i>>6);8[3]=(x(i))?t:i&e}a.g(9.f.k(8[0]),9.f.k(8[1]),9.f.k(8[2]),9.f.k(8[3]))}u a.E(\'\')}d{l a=\'\';n(++5<c){o=7[5];j=7[++5];8[0]=o>>2;8[1]=((o&3)<<4)|(j>>4);b(x(j))8[2]=8[3]=t;d{i=7[++5];8[2]=((j&15)<<2)|(i>>6);8[3]=(x(i))?t:i&e}a+=9.f[8[0]]+9.f[8[1]]+9.f[8[2]]+9.f[8[3]]}u a}},C:w(s){b(s.v%4)X Q N("P: \'9.C\' R: O S 13 19 18 1a 17 14 Z.");l 7=9.J(s),5=0,c=7.v;b(9.D){l a=[];n(5<c){b(7[5]<r)a.g(p.q(7[5++]));d b(7[5]>F&&7[5]<y)a.g(p.q(((7[5++]&B)<<6)|(7[5++]&e)));d a.g(p.q(((7[5++]&15)<<12)|((7[5++]&e)<<6)|(7[5++]&e)))}u a.E(\'\')}d{l a=\'\';n(5<c){b(7[5]<r)a+=p.q(7[5++]);d b(7[5]>F&&7[5]<y)a+=p.q(((7[5++]&B)<<6)|(7[5++]&e));d a+=p.q(((7[5++]&15)<<12)|((7[5++]&e)<<6)|(7[5++]&e))}u a}},A:w(s){l 5=-1,c=s.v,h,7=[];b(/^[\\10-\\Y]*$/.z(s))n(++5<c)7.g(s.I(5));d n(++5<c){h=s.I(5);b(h<r)7.g(h);d b(h<11)7.g((h>>6)|16,(h&e)|r);d 7.g((h>>12)|y,((h>>6)&e)|r,(h&e)|r)}u 7},J:w(s){l 5=-1,c,7=[],8=[,,,];b(!9.m){c=9.f.v;9.m={};n(++5<c)9.m[9.f.k(5)]=5;5=-1}c=s.v;n(++5<c){8[0]=9.m[s.k(5)];8[1]=9.m[s.k(++5)];7.g((8[0]<<2)|(8[1]>>4));8[2]=9.m[s.k(++5)];b(8[2]==t)G;7.g(((8[1]&15)<<4)|(8[2]>>2));8[3]=9.m[s.k(++5)];b(8[3]==t)G;7.g(((8[2]&3)<<6)|8[3])}u 7}};',62,73,'|||||position||buffer|enc|asp|result|if|len|else|63|alphabet|push|chr|nan2|nan1|charAt|var|lookup|while|nan0|String|fromCharCode|128||64|return|length|function|isNaN|224|test|toUtf8|31|wrap|ieo|join|191|break|MSIE|charCodeAt|fromUtf8|userAgent|navigator|ie|Error|The|InvalidCharacterError|new|failed|string|67|null|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|encode|throw|x7f|encoded|x00|2048||to|correctly||192|not|wrapd|be|is'.split('|'),0,{}))

/*
	API-specific global functions
*/
function onYouTubePlayerError(e) {
	if (e>=101) {
		var player = theater.getPlayer();
		var id = player.videoId;
		if (id.length==11) {
			theater.loadVideo("youtubelive",id,player.startTime || "");
		}
	}
}

function onYouTubePlayerReady( playerId ) {

	var player = theater.getPlayer(),
	type = player && player.getType();

	if ( player && ((type == "youtube") || (type == "youtubelive") || (type == "drive") || (type == "cartoon")) ) {
		player.onReady();
	}
	player.player.addEventListener("onError", "onYouTubePlayerError");	
}

function backupYoutubePlayer( error ) {
	//error doesn't seem to return the right data...

	var element = document.getElementById("backupplayer");
	if(element) {element.parentNode.removeChild(element);}

	backupPlayer = document.createElement('iframe');
	backupPlayer.setAttribute('id', 'backupplayer');
	backupPlayer.setAttribute('src', 'http://swampservers.net/cinema/jwplayer/youtube.php?v='+theater.getPlayer().videoId);
	backupPlayer.setAttribute('width', '100%');
	backupPlayer.setAttribute('height', '100%');
	backupPlayer.setAttribute('frameborder', '0');
	backupPlayer.setAttribute('scrolling', 'no');

	document.getElementById("player-container").insertBefore(backupPlayer,document.getElementById("player"));
}

function livestreamPlayerCallback( event, data ) {
	if (event == "ready") {
		var player = theater.getPlayer();
		if ( player && (player.getType() == "livestream") ) {
			player.onReady();
		}
	}
}

function onJWPlayerReady() {
	theater.getPlayer().onReady();
}

if (window.onTheaterReady) {
	onTheaterReady();
}

console.log("Loaded theater.js v" + theater.VERSION);

function YT_createPlayer(divId, videoId) {

    var params = {
			allowScriptAccess: "always",
			bgcolor: "#000000",
			wmode: "opaque"
		};

		var attributes = {
			id: "player"
		};

    //Build the player URL SIMILAR to the one specified by the YouTube JS Player API
    var videoURL = '';
    videoURL += 'https://video.google.com/get_player?wmode=opaque&ps=docs&partnerid=30&controls=0&showinfo=0&autoplay=1'; //Basic URL to the Player
    videoURL += '&docid=' + videoId; //Specify the fileID ofthe file to show
    videoURL += '&enablejsapi=1'; //Enable Youtube Js API to interact with the video editor
    videoURL += '&playerapiid=' + videoId; //Give the video player the same name as the video for future reference
    videoURL += '&cc_load_policy=0'; //No caption on this video (not supported for Google Drive Videos)


    swfobject.embedSWF(videoURL,divId, "100%", "100%", "8", null, null, params, attributes);

}

Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = 0, len = this.length; i < len; i++) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

