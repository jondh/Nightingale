<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Nightingale Studios');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>
		<?php // echo $title_for_layout; ?> 
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js', 
							'http://code.jquery.com/ui/1.10.1/jquery-ui.js',
							'alerts',
							'spin'));
        echo $scripts_for_layout;
	?>
	

	<link rel='stylesheet' type='text/css' href="<?php echo $this->webroot . 'css/fullcalendar.css'; ?>" />
	<script type='text/javascript' src="<?php echo $this->webroot . 'js/moment.min.js'; ?>"></script>
	<script type='text/javascript' src="<?php echo $this->webroot . 'js/jquery.min.js'; ?>"></script>
	<script type='text/javascript' src="<?php echo $this->webroot . 'js/jquery-ui.custom.min.js'; ?>"></script>
	<script type='text/javascript' src="<?php echo $this->webroot . 'js/fullcalendar.min.js'; ?>"></script>
	
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->webroot . 'dist/css/ngs.css';?>" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?php echo $this->webroot . 'dist/css/ngs.min.css';?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo $this->webroot . 'dist/js/bootstrap.min.js';?>"></script>
 
</head>

<style>

body{
	background-image: url("<?php echo $this->webroot . 'img/whitetexture.jpg';?>");
}

#defaultNavbar{
	background-image: url("<?php echo $this->webroot . 'img/blacktexture.jpg';?>");
}

.whiteText{
	color: white;
}

h1, h2, h3{
	background-color:transparent;
}

ul{
	margin-left: 0; margin-right: 0;
}

#overlay{
	position:fixed;
	display: none;
	width:100%; height:100%;
	background: rgb(0, 0, 0); /* The Fallback */
	background: rgba(0, 0, 0, 0.8); 
	z-index:5000;
}

</style>

<?php
 if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
?>

<body>	
	
	<div id="overlay"></div>
	<div id="foo"></div>
	
    <!-- Fixed navbar -->
    <div id="defaultNavbar" class="navbar navbar-default navbar-fixed-top navbar-inverse" >
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'index')); ?>">Nightingale</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			<li><a href="<?php echo $this->Html->url(array('controller'=>'posts', 'action'=>'index')); ?>" ><span class="glyphicon glyphicon-home"></span> Home</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          		<li id="profileLI"><a id="profile"><?php echo $login['user']['firstName'] . " " . $login['user']['lastName']; ?></a></li>
				<li id="logoutLI"><a id="logout" style="cursor: pointer;">Logout</a></li>
				<!-- <li id="loginLI" style="display:none">
					<form id="loginForm" class="navbar-form" method="post">
						<div id="loginUsername" class="form-group">
							<input type="text" placeholder="Username" name="username" class="form-control">
						</div>
						<div id="loginPassword" class="form-group">
							<input id="loginPasswordField" type="password" placeholder="Password" name="password" class="form-control">
						</div>
						<button id="loginFormSubmit" onclick="return false;" class="btn btn-success">Sign in</button>
						<button id="loginFormNewUser" onclick="return false;" class="btn btn-success">New User</button>
					</form>
				</li> -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
	<br>
	<br>
	<br>
	
	<div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
  	  <!-- FOOTER -->
  	  <hr class="featurette-divider">
  	  <footer>
  	  	<p class="pull-right"><a href="#">Back to top</a></p>
  	    <p>&copy; <a href="#">Copaesthetic 2014</a> &middot; </p>
  	  </footer>
	</div>
	<?php echo $this->element('sql_dump');
	      echo $this->Js->writeBuffer();
	?>
	
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/holder.js"></script>
    
    <script>
    	<?php if( $login['login'] ){ ?>
    		$("#logoutLI").show();
    		$("#loginLI").hide();
    		$("#profileLI").show();
    		
    		$("#profile").html();
    	<?php }else{ ?>
    		$("#logoutLI").hide();
    		$("#loginLI").show();
    	<?php } ?>

    	$("#logout").click(function(){
    		$.post("<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'logoutAjax')); ?>", function(data){
    			window.location = JSON.parse(data).url;
    		});
    	});
    	
    	$("#loginFormSubmit").click(function(){
    		$.post("/Nightingale/users/loginAjax", $("#loginForm").serialize(), function(data){
    			var result = JSON.parse(data);
    			
    			if(result.result.indexOf("success") >= 0){
    				$("#loginUsername").removeClass("has-error");
    				$("#loginPassword").removeClass("has-error");
    				$("#logoutLI").show();
    				$("#loginLI").hide();
    				$("#profileLI").show();
    				
    				$("#profile").html(result.User.firstName + " " + result.User.lastName);
    				location.reload();
    			}
    			else{
    				$("#loginPasswordField").val('');
    				$("#loginUsername").addClass("has-error");
    				$("#loginPassword").addClass("has-error");
    			}
    		});
    	});
		
		var opts = {
		  lines: 9, // The number of lines to draw
		  length: 40, // The length of each line
		  width: 12, // The line thickness
		  radius: 55, // The radius of the inner circle
		  corners: 1, // Corner roundness (0..1)
		  rotate: 67, // The rotation offset
		  direction: 1, // 1: clockwise, -1: counterclockwise
		  color: '#fff', // #rgb or #rrggbb or array of colors
		  speed: 1, // Rounds per second
		  trail: 91, // Afterglow percentage
		  shadow: true, // Whether to render a shadow
		  hwaccel: false, // Whether to use hardware acceleration
		  className: 'spinner', // The CSS class to assign to the spinner
		  zIndex: 5000, // The z-index (defaults to 2000000000)
		  top: '50%', // Top position relative to parent
		  left: '50%' // Left position relative to parent
		};
		var target = document.getElementById('foo');
		var spinner = new Spinner(opts).spin(target);
		spinner.stop();
		
		function showOverlay(){
			$("#overlay").show();
			spinner.spin(target);
		}
		
		function hideOverlay(){
			$("#overlay").hide();
			spinner.stop();
		}
    	
    </script>
    
</body>
</html>
