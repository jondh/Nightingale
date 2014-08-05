<?php ?>

<div class="container">

	<div class="jumbotron">

		<?php foreach ($posts as $post):  ?> 

			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>
						<?php echo $post['Post']['title']; ?>
					</center>
					<h5 class="pull-right">lsdkjf</h5>
				</div>
				<div class="panel-body">
					<?php echo $post['Post']['content']; ?>
				</div>
			</div>

		<?php endforeach; ?>
		
	</div>
	
</div>
			

			