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
		
		echo $this->Html->script(array(
			'https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js', 
			'http://code.jquery.com/ui/1.10.1/jquery-ui.js',
			'vertical_scroll_pages',
			'strings'
			));
        echo $scripts_for_layout;
	?>
	
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
	<script src="../../../../../dist/js/bootstrap.min.js"></script>
 
</head>

<?php
 if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
?>

<body>	
	
	<?php echo $this->fetch('content'); ?>
	
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/holder.js"></script>
    
    
</body>
</html>
