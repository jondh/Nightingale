<?php
	echo $this->element('newUser');
?>

<div class="container" style="width:100%;">
	<div class="col-md-8">
		<h1 class="well">Choose Your <?php echo $length; ?>min Lession(s)</h1>
		<div class="jumbotron" id="calendar"></div>
	</div>
	<div class="col-md-4">
		<button id="submitBtn" class="btn btn-primary" onclick="submitEntries(this)" style="width:100%" disabled>Submit</button>
		<ul id="selectedLessions" class="list-group">
			<a class="list-group-item active h3">
				<span id="lessionNum">0</span> Lessions
			</a>
		</ul>
	</div>
	
</div>

<?php echo $this->fetch('newUserModal'); ?>

<?php echo $this->fetch('newUserScript'); ?>

<script>
	var lessionTime = <?php echo json_encode($length); ?>;
	var numLessions = 0;
	var minNewLessions = 4;
	
	
	var myLessions = <?php echo json_encode($myLessions); ?>;
	var otherLessions = <?php echo json_encode($otherLessions); ?>;
	var blocks = <?php echo json_encode($blocks); ?>;
	var newEntries = [];
	
	var userId = <?php 	
			if($loggedIn){
				echo json_encode($user['id']);
			}
			else{
				echo -1;
			}
	?>;
	
	if(myLessions == ""){
		$("#submitBtn").empty().append("Please Select At Least "+minNewLessions+" Lessions");
		$("#submitBtn").attr('disabled', true);
	}

	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		allDaySlot: false,
		minTime: "08:00:00",
		maxTime: "22:00:00",
		defaultView: 'agendaWeek',
		editable: false,
		dayClick: function(date, jsEvent, view) {

			if(view.name.indexOf('month') < 0){
				var endDate = moment(date);
				endDate.add('minutes', lessionTime);
				var sources = $("#calendar").fullCalendar( 'clientEvents', function(e){
					if( ( (moment(e.start).isBefore(date) || moment(e.start).isSame(date)) && moment(e.end).isAfter(date)) || ( moment(e.start).isBefore(endDate) && (moment(e.end).isAfter(endDate) || moment(e.end).isSame(endDate)) ) || (moment(e.start).isAfter(date) && moment(e.end).isBefore(endDate)) ){
						return true;
					}
					return false;
				} );
		        
				if(sources.length == 0){
					addLessionShow(date);
					$('#calendar').fullCalendar('addEventSource',
						{
							events: [
								{
									id: 'entry'+numLessions,
									title: 'Selected',
									start: date.toISOString(),
									end: endDate.toISOString(),
									backgroundColor: "#b32c14",
									borderColor: "#aaaaaa"
								}
							]
						}
					);
				}
			}
			

		    },
		events: function(start, end, timezone, callback) {
			var events = [];
			if(myLessions){
				for(var i = 0; i < myLessions.length; i++){
					var startDate = moment.utc(myLessions[i].CalendarEntry.time, "YYYY-MM-DD HH:mm:ss");
					var endDate = moment.utc(startDate);
					endDate.add('minutes', myLessions[i].CalendarEntry.length);
					events.push({
						title: myLessions[i].CalendarEntry.description,
						start: startDate.toISOString(),
						end: endDate.toISOString(),
						backgroundColor: "#1202c4",
						borderColor: "#aaaaaa"
					});
				}
			}
			if(otherLessions){
				for(var i = 0; i < otherLessions.length; i++){
					var startDate = moment.utc(otherLessions[i].CalendarEntry.time, "YYYY-MM-DD HH:mm:ss");
					var endDate = moment.utc(startDate);
					endDate.add('minutes', otherLessions[i].CalendarEntry.length);
					events.push({
						title: otherLessions[i].CalendarEntry.description,
						start: startDate.toISOString(),
						end: endDate.toISOString(),
						backgroundColor: "#4A8591",
						borderColor: "#aaaaaa"
					});
				}
			}
			if(blocks){
				for(var i = 0; i < blocks.length; i++){
					var startDate = moment.utc(blocks[i].CalendarEntry.time, "YYYY-MM-DD HH:mm:ss");
					var endDate = moment.utc(startDate);
					endDate.add('minutes', blocks[i].CalendarEntry.length);
					events.push({
						title: blocks[i].CalendarEntry.description,
						start: startDate.toISOString(),
						end: endDate.toISOString(),
						backgroundColor: "#000",
						borderColor: "#aaaaaa"
					});
				}
			}
			callback(events);
		}
	});

	
	function addLessionShow(d){
		numLessions++;
		newEntries.push({
			cal_id: 'entry'+numLessions,
			user_id: userId,
			calendar_id: <?php echo json_encode($calendar['Calendar']['id']); ?>,
			time: d.format("YYYY-MM-DD HH:mm:ss"),
			length: lessionTime,
			type: 1,
			description: "lession",
			timeStamp: ""
		});
		if(myLessions != ""){
			$("#submitBtn").attr('disabled', false);
		}
		else if(numLessions >= minNewLessions){
			$("#submitBtn").attr('disabled', false);
			$("#submitBtn").empty().append("Submit");
		}
		$("#lessionNum").empty().append(numLessions);
		$("#selectedLessions").append("<div id='entry"+numLessions+"' class='list-group-item' onclick='removeEntry(this)'><span class='glyphicon glyphicon-remove'></span> "+d.format("dddd, MMMM Do YYYY, h:mm:ss a")+"</div>");
	}
	
	function removeEntry(e){
		$("#calendar").fullCalendar('removeEvents', e.id);
		$(e).remove();
		revomeIdFromEntries(e.id);
		if(myLessions != ""){
			if(numLessions == 0){
				$("#submitBtn").attr('disabled', true);
			}
		}
		else if(numLessions < minNewLessions){
			$("#submitBtn").attr('disabled', true);
			$("#submitBtn").empty().append("Please Select At Least "+minNewLessions+" Lessions");
		}
		
	}
	
	function revomeIdFromEntries(id){
		for(var i = 0; i < newEntries.length; i++){
			if(newEntries[i].cal_id === id){
				newEntries.splice(i,1);
				numLessions--;
				$("#lessionNum").empty().append(numLessions);
				break;
			}
		}
	}
	
	function submitEntries(btn){
		var loggedIn = <?php echo json_encode($loggedIn); ?>;
		if(loggedIn){
			postEntries();
		}
		else{
			$("#newUserModal").modal('show');
		}
		
	}
	
	function newUserComplete(id){
		for(var i = 0; i < newEntries.length; i++){
			newEntries[i].user_id = id;
		}
		postEntries();
	}
	
	function postEntries(){
		alert(JSON.stringify(newEntries));
		$.post("<?php echo $this->Html->url(array('controller'=>'calendar_entries', 'action'=>'addMany')); ?>", JSON.stringify(newEntries), function(data){
			location.reload();
		});
	}
	
</script>

			