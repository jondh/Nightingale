
<link href='http://fonts.googleapis.com/css?family=Marcellus+SC|Just+Another+Hand|Poiret+One|Montez|Just+Me+Again+Down+Here|Clicker+Script|Rancho|Dancing+Script|Amatic+SC|Satisfy|Julius+Sans+One|Six+Caps' rel='stylesheet' type='text/css'>

<style>

a{
	color:#fec6f8;
	text-shadow: 0 0 0.2em #e06bff, 0 0 0.2em #e06bff, 0 0 0.2em #e06bff;
}

a:hover{
	color:#ffffff;
	text-shadow: 0 0 0.4em #eba0ff, 0 0 0.4em #eba0ff, 0 0 0.4em #eba0ff;
	text-decoration:none;
}

.h2{
	font-family: 'Poiret One', cursive;
}

html, body{
	background-color:transparent;
	height: 100%;
	margin: 0;
}

html{
	/*background:url(<?php echo $this->webroot . "img/BlurBACKGROUND.jpg";?>) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;*/
}

img.desaturate{
-webkit-filter: grayscale(100%);
filter: grayscale(100%);
filter: gray;
filter: url("data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' height='0'><filter id='greyscale'><feColorMatrix type='matrix' values='0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0' /></filter></svg>#greyscale");
}

.opacity {
	background: rgba(0, 0, 0, 0.4);
}

.myForm {
	padding: 10px 0px 10px 20px;
}

.myFormLabel{
	color:white;
}

.page{
	position:relative;
	height: 100%;
}

.vertCenter{
	position: relative;
	top: 50%;
	-webkit-transform: translateY(-50%);
}

.bottom{
	position: absolute;
	bottom:0;
	width:100%;
}

#frontFoot{
	background-color:black;
	height:7%;
	min-height:50px;
	max-height:65px;
	background: rgba(0, 0, 0, 0.4);
}
#downArrow:hover{
	max-height: 90%;
}

#myFooter{
	position:absolute;
	bottom:0;
	width:100%;
	height:40%;
	background-color:black;
	background: rgba(0, 0, 0, 0.6);
}

#downArrow{
	position: absolute;
	display: block;
	margin-left: auto;
	margin-right: auto;
	left:0; right:0;
	max-height: 100%;
}

#page2{
	position:relative;
	height: 95%;
	background:url(<?php echo $this->webroot . "img/page2BG.jpg";?>) center center;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}

#page3{
	background-color: white;
}

.fullContent{
	height: 100%;
}

.p1buttonsContainer{
	position:relative; 
	height:50%; width:100%; 
	overflow:hidden;
}

.p1buttons{
	position:absolute; 
	max-height:100%; max-width:100%;
}

.p1buttons:hover{
	opacity:0;
}

.contentHeight{
	height: 80%;
}

.logoHeight{
	height:35%;
}

#logoBird{
	float:right;
}

@media (max-width: 767px) {
	.fullContent{
		height: 50%;
	}
	.contentHeight{
		height: 90%;
	}
	
	#logoBird{
		float:none;
	}
	
	.logoImg{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
}

#socialBar{
	float:right;
	height:70%;
	max-height:70%;
}

.socialIcon{
	opacity:0.6;
	height:100%;
	max-height:100%;
}

.socialIcon:hover{
	filter:none;
	-webkit-filter: grayscale(0%);
}

.bgvid { 
	position: fixed; right: 0; bottom: 0;
	min-width: 100%; min-height: 100%;
	width: auto; height: auto; z-index: -100;
	background: url(<?php echo $this->webroot . 'img/lyleSing.jpg';?>) no-repeat;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
}

</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content opacity">
	  <div class="modal-header">
		<button type="button" class="close btn-cancel" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Login</h4>
	  </div>
	  <div class="modal-body">
		<form class="myForm" id="loginForm">
			<center>
			<fieldset>
				<div id="usernameDiv" class="form-group">
					<label class="myFormLabel" for="username">Username</label>
					<input type="text" class="form-control" name="username" id="username" placeholder="username">              
				</div>
				<div id="passwordDiv" class="form-group">
					<label class="myFormLabel" for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="password">              
				</div>
			</fieldset>
			</center>
		</form>

		<form class="myForm" id="newUserForm" style="display:none">
			<center>
			<fieldset>
				<div id="newUserUsernameDiv" class="form-group">
					<label class="myFormLabel" for="newUsername">Username</label>
					<input type="text" class="form-control" name="newUsername" id="newUserUsername" placeholder="username">              
				</div>
				<div id="newUserEmailDiv" class="form-group">
					<label class="myFormLabel" for="newEmail">Email</label>
					<input type="email" class="form-control" name="newEmail" id="newUserEmail" placeholder="email">              
				</div>
				<div id="newUserFirstNameDiv" class="form-group">
					<label class="myFormLabel" for="newFirstName">First Name</label>
					<input type="text" class="form-control" name="newFirstName" id="newUserFirstName" placeholder="first name">              
				</div>
				<div id="newUserLastNameDiv" class="form-group">
					<label class="myFormLabel" for="newLastName">Last Name</label>
					<input type="text" class="form-control" name="newLastName" id="newUserLastName" placeholder="last name">              
				</div>
				<div class="form-group">
					<label class="myFormLabel" for="newPassword">Password</label>
					<input type="password" class="form-control" name="newPassword" id="newUserPassword" placeholder="password">              
				</div>
				<div class="form-group">
					<label class="myFormLabel" for="newPasswordConfirm">Password Confirm</label>
					<input type="password" class="form-control" name="newPasswordConfirm" id="newUserPasswordConfirm" placeholder="password confirm">              
				</div>
			</fieldset>
			</center>
		</form>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Close</button>
		<button id="modalSubmit" type="button" class="btn btn-primary">Submit</button>
	  </div>
	</div>
  </div>
</div>
	
<div id="userButtons" style="position:absolute; margin:20px 20px 20px 20px; z-index:10;">
	<button id="signIn" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Sign in</button>
	<button id="newUser" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="display:none;">New User</button>
</div>

<div class="page">
	
	<div class="bgvid"></div>
	<?php if($mobile == 'false'){ ?>
	<video autoplay loop poster="<?php echo $this->webroot . 'img/lyleSing.jpg';?>" class="bgvid">
		<source src="<?php echo $this->webroot . 'video/lyleSing.webm';?>" type="video/webm" >
		<source src="<?php echo $this->webroot . 'video/lyleSing.mp4';?>" type="video/mp4">
	</video>
	<?php } ?>
		
	
	
	<div class="vertCenter logoHeight">
		<div class="col-sm-5 fullContent">
			<img class="logoImg" id="logoBird" style="max-height:100%; max-width:100%;" src='<?php echo $this->webroot . "img/burddd.png";?>'>
		</div>
		<div class="col-sm-7 fullContent">
			<img class="logoImg" style="max-height:100%; max-width:100%;" src='<?php echo $this->webroot . "img/nightingale_words.png";?>'>
		</div>
	</div>
	
	<div id="frontFoot" class="bottom">
		<img id="downArrow" src="<?php echo $this->webroot . 'img/down-arrow.png';?>">
		<div id="socialBar" class="vertCenter">
			<span><a href="http://twitter.com/nightingaleGS" target="_blank"><img id="twitter" class="img-circle socialIcon desaturate" src="<?php echo $this->webroot . 'img/twitter.png';?>"></a></span>
			<span><img class="img-circle socialIcon desaturate" src="<?php echo $this->webroot . 'img/facebook.png';?>"></span>
			<span><a href="mailto:info@nightingaleguitarstudio.com"><img class="img-circle socialIcon desaturate" src="<?php echo $this->webroot . 'img/email.png';?>" title="info@nightingaleguitarstudio.com"></a></span>
			<span><img class="img-circle socialIcon desaturate" src="<?php echo $this->webroot . 'img/youtube.png';?>"></span>
		</div>
	</div>
</div>

<div id="page2"  >
	<img src="">
	<div class="vertCenter contentHeight">
		<div class="col-sm-6 fullContent">
			<center><img id="1imgMain" style="max-height:100%; max-width:100%;" src='<?php echo $this->webroot . "img/lessonsbylyle.png";?>'></center>
		</div>
		<div class="col-sm-6 fullContent">
			<div class="p1buttonsContainer">
				<center>
					<img class="p1buttons" src='<?php echo $this->webroot . "img/1hour.gif";?>'>
					<img style="max-height:100%; max-width:100%;" src='<?php echo $this->webroot . "img/1hourhover.gif";?>'>
				</center>
			</div>
			<div class="p1buttonsContainer">
				<center>
					<img class="p1buttons" src='<?php echo $this->webroot . "img/30minutes.gif";?>'>
					<img style="max-height:100%; max-width:100%;" src='<?php echo $this->webroot . "img/30minuteshover.gif";?>'>
				</center>
			</div>
		</div>
	</div>
</div>

<div id="page3" class="page">
	<div style="background-color:black;">
		<img style="width:50%; max-width:1000px; display: inline-block;" src='<?php echo $this->webroot . "img/address.jpg";?>'>
		
	</div>
	<div id="map-canvas" style="height:60%; width:100%"></div>
	<center><div class='h2' style="background-color:black; padding:1em; margin:0"><a id="viewMapLink" href='https://goo.gl/maps/8nC7z' target="_blank">View In Google Maps</a></div></center>
	
</div>

<script>

var mobile = "<?php echo $mobile; ?>";


function initialize() {
	
	var MY_MAPTYPE_ID = 'custom_style';
	
	var featureOpts = [
	    {
		  featureType: "all",
	      stylers: [
	        { hue: '#000000' },
			{ saturation: '-90'},
	        { visibility: 'simplified' },
	        { gamma: 0.1 },
	        { weight: 0.0 }
	      ]
	    },
		{
	      featureType: 'road',
	      elementType: 'geometry',
	      stylers: [
	        { color: '#ffff9a' },
			{ saturation: '0'},
	        { gamma: 1.0 }
	      ]
	    },
		{
	      featureType: 'road.arterial',
	      elementType: 'geometry',
	      stylers: [
	        { color: '#90d0d6' },
			{ saturation: '0'},
	        { gamma: 1.0 }
	      ]
	    },
		{
	      featureType: 'road.highway',
	      elementType: 'geometry',
	      stylers: [
	        { color: '#fd009d' },
			{ saturation: '0'},
	        { gamma: 1.0 }
	      ]
	    },
	    {
	      elementType: 'labels',
	      stylers: [
	        { visibility: 'off' }
	      ]
	    },
	    {
	      featureType: 'water',
	      stylers: [
	        { color: '#000000' }
	      ]
	    }
	  ];
	
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(29.628713, -95.143691),
		scrollwheel: false,
		draggable: false,
   	 	mapTypeControlOptions: {
     		mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
   	 	},
    	mapTypeId: MY_MAPTYPE_ID
	};

	var map = new google.maps.Map(document.getElementById('map-canvas'),
 		mapOptions);
 		
	var marker = new google.maps.Marker({
		map: map,
		position: {lat: 29.628713, lng: -95.143691}
	});
	
	var styledMapOptions = {
	   name: 'Custom Style'
	};
	
	var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
	
	map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
	  'callback=initialize';
	document.body.appendChild(script);
}

window.onload = loadScript;

$("#signIn").click(function(){
	$("#myModalLabel").html("Sign In");
	$("#loginForm").show();
	$("#newUserForm").hide();
});

$("#newUser").click(function(){
	$("#myModalLabel").html("New User");
	$("#loginForm").hide();
	$("#newUserForm").show();
});


$("#modalSubmit").click(function(){
	
	if($("#loginForm").css('display') == "block"){
		$.post("<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'loginAjax')); ?>", $("#loginForm").serialize(), function(data){
			var result = JSON.parse(data);
		
			if(result.result.indexOf("success") >= 0){
				$("#usernameDiv").removeClass("has-error");
				$("#passwordDiv").removeClass("has-error");
			
				window.location = "<?php echo $loginURL;?> ";
			}
			else{
				$("#password").val('');
				$("#usernameDiv").addClass("has-error");
				$("#passwordDiv").addClass("has-error");
			}
		});
	}
	if($("#newUserForm").css('display') == "block"){
		alert("new user");
	}
});

</script>