

<div class="container" style="width:100%;">
	<div class="jumbotron col-md-8">
		<div id="calendar"></div>
	</div>
	<div class="col-md-4">
		<button class="btn" onclick="submitEntries()">Submit</button>
		<ul id="selectedLessions" class="list-group">
			<a class="list-group-item active h3">
				<span id="lessionNum">0</span> Lessions
			</a>
		</ul>
	</div>
	
</div>

<script>

		
	var lessionTime = 60;
	var numLessions = 0;
	
	var entries = <?php echo json_encode($entries['return']); ?>;
	
	var newEntries = [];

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
			//alert(entries.length);
			for(var i = 0; i < entries.length; i++){
				var startDate = moment(entries[i].CalendarEntry.time, "YYYY-MM-DD hh:mm:ss");
				var endDate = moment(startDate);
				endDate.add('minutes', entries[i].CalendarEntry.length);
				events.push({
					title: entries[i].CalendarEntry.description,
					start: startDate.toISOString(),
					end: endDate.toISOString()
				});
			}
			callback(events);
		}
	});

	
	function addLessionShow(d){
		numLessions++;
		newEntries.push({
			cal_id: 'entry'+numLessions,
			time: d.format("YYYY-MM-DD hh:mm:ss")
		});
		$("#lessionNum").empty().append(numLessions);
		$("#selectedLessions").append("<div id='entry"+numLessions+"' class='list-group-item' onclick='removeEntry(this)'><span class='glyphicon glyphicon-remove'></span> "+d.format("dddd, MMMM Do YYYY, h:mm:ss a")+"</div>");
	}
	
	function removeEntry(e){
		$("#calendar").fullCalendar('removeEvents', e.id);
		$(e).remove();
		revomeIdFromEntries(e.id);
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
	
	function submitEntries(){
		var loggedIn = <?php echo json_encode($loggedIn); ?>;
		if(loggedIn){
			postEntries(<?php echo json_encode($user['id']); ?>);
		}
		else{
			
		}
		
	}
	
	function postEntries(uid){
		var submitData = {
			entries: newEntries,
			user_id: uid,
			calendar_id: <?php echo json_encode($calendar['Calendar']['id']); ?>,
			length: lessionTime
		}
		$.post("<?php echo $this->Html->url(array('controller'=>'calendar_entries', 'action'=>'addMany')); ?>", JSON.stringify(submitData), function(data){
			
		});
	}
	
</script>

			