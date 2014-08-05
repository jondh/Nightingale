<?php ?>

<div class="container">

	<div class="col-lg-8">

		<div class="jumbotron">
		
			<?php if( $login['login'] ){ ?>
				<button id="addPostButton" class="btn btn-primary">Add Post</button>
			
				<div id="addPostFormDiv" class="jumbotron" style="display:none;">
					<form id="addPostForm" class="form-horizontal" role="form" method="post">
						<div id="addPostTitleDiv" class="form-group">
							<label id="addPostTitleLabel" for="addPostTitle" class="control-label">Title</label>
							<input id="addPostTitle" class="form-control" name="title" placeholder="Title">
						</div>
						<div id="addPostContentDiv" class="form-group">
							<label id="addPostContentLabel" for="addOrganAddress" class="control-label">Content</label>
							<textarea id="addPostContent" class="form-control" name="content" rows="3"></textarea>
						</div>
						<button id="addPostCancel" onclick="return false;" type="submit" class="btn btn-primary">Cancel</button>
						<button id="addPostSubmit" onclick="return false;" type="submit" class="btn btn-primary pull-right">Submit</button>
					</form>
				</div>
			<?php } ?>

			<div id="postArea">

				<?php foreach ($posts as $post):  ?> 

					<div class="panel panel-primary">
						<div class="panel-heading">
								<?php echo $post['Post']['title']; ?>
								<small class="pull-right">By: <?php echo $post['User']['username']; ?></small>
						</div>
						<div class="panel-body">
							<?php echo $post['Post']['content']; ?>
						</div>
						<div class="panel-footer h5" style="padding: 5px 10px 5px 10px">
							<?php echo $this->Time->niceShort($post['Post']['dateTime']); ?>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		
		</div>
		
	</div>
	
	<div class="col-lg-4 sidebar-outer">
	
		<div class="jumbotron">
			<?php echo $this->Html->link(
				'Calendar',
				array(
					'controller' => 'calendars',
					'action' => 'index'
				)
			); ?>
		</div>
	
	</div>
	
</div>

<script>

	$("#addPostButton").click(function(){
		$("#addPostButton").hide('fast');
		$("#addPostFormDiv").show('slow');
	});
	
	$("#addPostCancel").click(function(){
		$("#addPostButton").show('fast');
		$("#addPostFormDiv").hide('slow');
	});
	
	$("#addPostSubmit").click(function(){
		$.post("/Nightingale/posts/add", $("#addPostForm").serialize(), function(data){
			var result = JSON.parse(data);
			var resultStr = result.result;
			if(resultStr.indexOf("success") >= 0){
				$("#addPostFormDiv").hide();
				$("#addPostButton").show();
				$("#addPostTitleDiv").removeClass("has-success has-error");
				$("#addPostContentDiv").removeClass("has-success has-error");
				$("#addPostForm").trigger('reset');
				
				location.reload();
			}
			else{
				if( result.hasOwnProperty('errors') ){
					var errors = result.errors;
					if( errors.hasOwnProperty('title') ){
						$("#addPostTitleDiv").removeClass("has-success").addClass("has-error");
						$("#addPostTitleLabel").html("Title: " + errors.title);
					}
					else{
						$("#addPostTitleDiv").removeClass("has-error").addClass("has-success");
						$("#addPostTitleLabel").html("Title");
					}
					
					if( errors.hasOwnProperty('content') ){
						$("#addPostContentDiv").removeClass("has-success").addClass("has-error");
						$("#addPostContentLabel").html("Content: " + errors.content);
					}
					else{
						$("#addPostContentDiv").removeClass("has-error").addClass("has-success");
						$("#addPostContentLabel").html("Content");
					}
				}
			}
		});
	});

</script>
			

			