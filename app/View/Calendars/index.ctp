<?php
	echo $this->element('posts');
?>

<style>

#newLessonsButton{
	margin-bottom:1em;
	width:100%;
}

</style>

<div class="container" style="width:100%;">
	
	<div class="col-md-4">
		<div class="well">
			<center>
				<img src="<?php echo $this->Gravatar->get_gravatar($user['email'], 200); ?>" class="img-circle">
				<h2><?php echo $user['firstName'] . " " . $user['lastName']; ?></h2>
				<h3><?php echo count($upcomingLessons); ?> upcoming lessons</h3>
				<h3><?php echo count($previousLessons); ?> previous lessons</h3>
				<h4>Joined: <?php echo $this->Time->format($user['dateTime'], '%B %e, %Y'); ?></h4>
			</center>
		</div>
	</div>
	
	<div class="col-md-8">
		<div class="list-group">
			<a class="list-group-item active">Upcoming Lessons</a>
			<?php foreach($upcomingLessons as $lesson): ?>
				<a class="list-group-item">
					<?php echo $this->Time->format($lesson['CalendarEntry']['time'], '%B %e, %Y %H:%M %p'); ?>
					<?php if( (time()+(60*60*24*$calendar['Calendar']['no_cancel_days'])) < strtotime($lesson['CalendarEntry']['time'])){ ?>
					<span class="glyphicon glyphicon-remove pull-right" style="cursor:pointer" onclick="removeLesson(<?php echo $lesson['CalendarEntry']['id']; ?>)"></span>
					<?php } ?>
				</a>
			<?php endforeach; ?>
			<?php if(count($upcomingLessons) == 0): ?>
				<a class="list-group-item">
					<center>
						You have no upcoming lessons. Click the button below to get educated.
					</center>
				</a>
			<?php endif; ?>
		</div>
		
		<a href="<?php echo $this->Html->url(array('controller'=>'calendars', 'action'=>'newLessons')); ?>">
			<button id="newLessonsButton" class="btn btn-default">Buy More or Modify Lessons</button>
		</a>
		
		<?php echo $this->fetch('postsDisplay'); ?>
	</div>
	
</div>

<div class="modal fade" id="deleteLessonModal" tabindex="-1" role="dialog" aria-labelledby="deleteLessonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="deleteLessonModalLabel">Delete Lesson?</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this lesson?<br>
		You will receive a credit to select another lesson of this length.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="deleteLessonModalSubmit" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<?php echo $this->fetch('addPostScript'); ?>

<script>

	function removeLesson(entry_id){
		$('#deleteLessonModal').modal('show');
		$('#deleteLessonModalSubmit').unbind('click');
		$('#deleteLessonModalSubmit').click(function(){
			$('#deleteLessonModalSubmit').button('loading');
			$.post("<?php echo $this->Html->url(array('controller'=>'calendar_entries', 'action'=>'deleteAjax')); ?>", {'id': entry_id}, function(data){
				alert(data);
			});
		});
	}

</script>