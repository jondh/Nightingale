

<div class="container" style="width:100%;">
	<div class="jumbotron col-md-8">
		<div id="calendar"></div>
	</div>
	<div class="col-md-4">
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
	

	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		minTime: "08:00:00",
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
									title: 'test',
									start: date.toISOString(),
									end: endDate.toISOString()
								}
							]
						}
					);
				}
			}
			

		    },
		events: [
			{
				title: 'All Day Event',
				start: '2014-06-01'
			},
			{
				title: 'Long Event',
				start: '2014-06-07',
				end: '2014-06-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2014-06-09T16:00:00',
				end: '2014-06-09T18:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2014-06-16T16:00:00',
				end: '2014-06-16T18:00:00'
			},
			{
				title: 'Meeting',
				start: '2014-06-12T10:30:00',
				end: '2014-06-12T12:30:00'
			},
			{
				title: 'Birthday Party',
				start: '2014-06-13T08:00:00',
				end: '2014-06-13T010:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2014-06-28'
			}
		]
	});

	
	function addLessionShow(d){
		numLessions++;
		$("#lessionNum").empty().append(numLessions);
		$("#selectedLessions").append("<div class='list-group-item'>"+d.format("dddd, MMMM Do YYYY, h:mm:ss a")+"</div>");
	}
	
</script>

			