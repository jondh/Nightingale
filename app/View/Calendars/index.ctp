<?php ?>

<style>
	.myWidthLegend{
		width:9%;
	}

	.myWidth{
		width:13%;
	}
	
	.tdHover:hover {
		background-color: #bbbbbb;
		color: #000000;
	}
	
	.border{
		vertical-align:middle;
		text-align: center;
		border-style:solid;
		border-width:1px;
	}
	
	.aptm{
		background: rgba(200, 12, 43, 0.9);
	}
	
</style>

<link rel='stylesheet' type='text/css' href="<?php echo $this->webroot . 'css/fullcalendar.css'; ?>" />
<script type='text/javascript' src="<?php echo $this->webroot . 'js/moment.min.js'; ?>"></script>
<script type='text/javascript' src="<?php echo $this->webroot . 'js/jquery.min.js'; ?>"></script>
<script type='text/javascript' src="<?php echo $this->webroot . 'js/jquery-ui.custom.min.js'; ?>"></script>
<script type='text/javascript' src="<?php echo $this->webroot . 'js/fullcalendar.min.js'; ?>"></script>

<div class="container" style="width:100%;">
	<div class="jumbotron">
		<div id="calendar"></div>
	</div>
	<!-- <div class="col-lg-10">
		<div class="panel-group" id="accordion">

		</div>
	</div>
	<div class="col-lg-2">
		<button id="ShowID" class="btn btn-primary">Show ID</button>
		<br><br>
		<button id="30MinBtn" class="btn btn-primary">Select 30 Min</button>
		<br><br>
		<button id="1hrBtn" class="btn btn-primary">Select 1 Hr</button>
		<br><br>
		<button id="block" class="btn btn-primary">Block out</button>
		<br><br>
		<button id="remove" class="btn btn-primary">Remove</button>
	</div> -->
</div>

<script>

	$(document).ready(function() {
		
		var lessionTime = 45;

	    // page is now ready, initialize the calendar...

		$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					minTime: "08:00:00",
					defaultDate: '2014-06-12',
					defaultView: 'agendaWeek',
					editable: false,
					dayClick: function(date, jsEvent, view) {

						if(view.name.indexOf('month') < 0){
							var startTime = date.toISOString();
							date.add('minutes', lessionTime);
							var endTime = date.toISOString();
					        alert('Clicked on: ' + date.format("h"));
							$('#calendar').fullCalendar('addEventSource',
								{
									events: [
									{
										title: 'test',
										start: startTime,
										end: endTime
									}
									]
								});
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
							start: '2014-06-09T16:00:00'
						},
						{
							id: 999,
							title: 'Repeating Event',
							start: '2014-06-16T16:00:00'
						},
						{
							title: 'Meeting',
							start: '2014-06-12T10:30:00',
							end: '2014-06-12T12:30:00'
						},
						{
							title: 'Lunch',
							start: '2014-06-12T12:00:00'
						},
						{
							title: 'Birthday Party',
							start: '2014-06-13T07:00:00'
						},
						{
							title: 'Click for Google',
							url: 'http://google.com/',
							start: '2014-06-28'
						}
					]
				});

	});
	//
	// var selectType = 0;
	// var selectedID = 0;
	// var minTime = 12;
	// var maxTime = 20;
	//
	// $("#ShowID").click(function(){
	// 	selectType = 0;
	// });
	//
	// $("#30MinBtn").click(function(){
	// 	selectType = 1;
	// });
	//
	// $("#1hrBtn").click(function(){
	// 	selectType = 2;
	// });
	//
	// $("#block").click(function(){
	// 	selectType = 3;
	// });
	//
	// $("#remove").click(function(){
	// 	selectType = 4;
	// });
	//
	// var calendarEntries = <?php echo json_encode($entries); ?>;
	// var studentCalendars = <?php echo json_encode($students); ?>;
	// var teacherCalendar = <?php echo json_encode($teacher); ?>;
	//
	// alert(JSON.stringify(calendarEntries));
	// alert(JSON.stringify(teacherCalendar));
	// createCalendarHead("My Calendar", "myCalendarBody");
	// createCalendarBody(calendarEntries, "myCalendarBody");
	//
	//
	// if(teacherCalendar.result.indexOf("success") >= 0){
	// 	createCalendarHead("Teaching Schedule", "teachingCalender");
	// 	createCalendarBody(teacherCalendar.return.Entry, "teachingCalender");
	// }
	//
	// var collapseRefCount = 1;
	//
	// function createCalendarHead(title, bodyId){
	// 	$("#accordion").append('\
	// 		<div class="panel panel-primary" style="height:100%;">\
	// 			<div class="panel-heading">\
	// 				<h3 class="panel-title">\
	// 					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse'+collapseRefCount+'">\
	// 						'+title+'\
	// 					</a>\
	// 				</h3>\
	// 			</div>\
	// 			<div id="collapse'+collapseRefCount+'" class="panel-collapse collapse">\
	// 				<div class="panel-body" style="height:100%; overflow:auto;">\
	// 					<table class="table table-bordered">\
	// 						<thead>\
	// 							<tr>\
	// 								<th class="myWidthLegend"></th>\
	// 								<th class="myWidth">Sunday</th>\
	// 								<th class="myWidth">Monday</th>\
	// 								<th class="myWidth">Tuesday</th>\
	// 								<th class="myWidth">Wednesday</th>\
	// 								<th class="myWidth">Thursday</th>\
	// 								<th class="myWidth">Friday</th>\
	// 								<th class="myWidth">Saturday</th>\
	// 							</tr>\
	// 						</thead>\
	// 						<tbody id="'+bodyId+'"></tbody>\
	// 					</table>\
	// 				</div>\
	// 			</div>\
	// 		</div>\
	// 	');
	//
	// 	$('#collapse'+collapseRefCount).on('shown.bs.collapse', function() { alert('shown'+bodyId); });
	// 	$('#collapse'+collapseRefCount).on('hidden.bs.collapse', function() { alert('hidden'+bodyId); });
	//
	// 	collapseRefCount++;
	// }
	//
	// function createCalendarBody(entries, calendarBodyId){
	// 	var matrix = [];
	// 	for(var i=0; i<48; i++) {
	// 		matrix[i] = [];
	// 		for(var j=0; j<7; j++) {
	// 			matrix[i][j] = '1';
	// 		}
	// 	}
	//
	// 	if(entries.result.indexOf("success") >= 0){
	// 		var entryArray = entries.return;
	// 		for(var i = 0; i < entryArray.length; i++){
	//
	// 			var t = entryArray[i].CalendarEntry.time.split(/[- :]/);
	// 			var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
	//
	// 			var hour = d.getHours()*2;
	// 			var day = d.getDay();
	// 			if(d.getMinutes() == 30){
	// 				hour += 1;
	// 			}
	//
	// 			var rowspan = entryArray[i].CalendarEntry.length * 2;
	// 			var description = entryArray[i].CalendarEntry.description;
	// 			if(entryArray[i].CalendarEntry.type == 1){
	// 				description = entryArray[i].User.firstName + " " + entryArray[i].User.lastName;
	// 				matrix[hour][day] = '<td id="'+hour+'q'+(day+1)+'q'+calendarBodyId+'" class="border well well-sm aptm" rowspan="'+rowspan+'">'+description+'</td>';
	// 			}
	// 			else{
	// 				matrix[hour][day] = '<td id="'+hour+'q'+(day+1)+'q'+calendarBodyId+'" class="tdHover border well well-sm" rowspan="'+rowspan+'">'+description+'</td>';
	// 			}
	// 			for(var j = 1; j < rowspan; j++){
	// 				matrix[hour+j][day] = '0';
	// 			}
	// 		}
	// 	}
	//
	// 	for(var i = 0; i < matrix.length; i++){ // iterate through columns (times) (48)
	// 		for(var j = 0; j < matrix[i].length; j++){  // iterate through each row (day) (7)
	// 			if(matrix[i][j] == '1'){
	// 				matrix[i][j] = '<td id="'+i+'q'+(j+1)+'q'+calendarBodyId+'" class="tdHover border" rowspan="1"></td>';
	// 			}
	// 		}
	// 	}
	//
	// 	for(var i = minTime*2; i < maxTime*2; i++){ // iterate through columns (times)
	// 		var row = '<tr><td id="'+i+'q0q'+calendarBodyId+'" class="border">'+timeFromNum(i/2)+'</td>';
	// 		for(var j = 0; j < matrix[i].length; j++){  // iterate through each row (day)
	// 			row += matrix[i][j];
	// 		}
	// 		row += "</tr>";
	// 		$('#'+calendarBodyId).before(row);
	// 	}
	// }
	//
	//
	// $('.tdHover').bind("click", cellClick);
	//
	//
	// function cellClick(){
	// 	if(selectType == 0){
	// 		alert(this.id);
	// 	}
	// 	else if(selectType == 1){
	// 		if(!$("#"+this.id).hasClass("aptm")){
	// 			removeClickedCell(selectedID);
	// 			addCellClickProp(this.id);
	// 			selectedID = this.id;
	// 		}
	// 	}
	// 	else if(selectType == 2){
	// 		if(!$("#"+this.id).hasClass("aptm") && this.id != selectedID){
	// 			var next = this.id.split("q");
	// 			var nextId = (parseInt(next[0])+1) + "q" + next[1] + "q" + next[2];
	// 			if(!($("#"+nextId).hasClass("well")) && (parseInt(next[0])+1) < maxTime*2){
	//
	// 				removeClickedCell(selectedID);
	// 				$("#"+nextId).remove();
	// 				$("#"+this.id).attr('rowspan','2');
	// 				addCellClickProp(this.id);
	// 				selectedID = this.id;
	// 			}
	// 		}
	// 	}
	// 	else if(selectType == 3){
	// 		if(!$("#"+this.id).hasClass("aptm")){
	// 			addCellClickProp(this.id);
	// 			combineCells(this.id);
	// 		}
	// 	}
	// 	else if(selectType == 4){
	// 		if(!$("#"+this.id).hasClass("aptm")){
	// 			removeClickedCell(this.id);
	// 		}
	// 	}
	// }
	//
	// function combineCells(id){
	// 	var cur = id.split("q");
	// 	var curRow = parseInt(cur[0]);
	// 	var nextId = (parseInt(cur[0])+1) + "q" + cur[1] + "q" + cur[2];
	// 	var prevId = (parseInt(cur[0])-1) + "q" + cur[1] + "q" + cur[2];
	//
	// 	if($("#"+nextId).hasClass("well") && !$("#"+nextId).hasClass("aptm")){
	// 		var num = parseInt($("#"+nextId).attr('rowspan'));
	// 		$("#"+nextId).attr('rowspan','1');
	// 		$("#"+id).attr('rowspan', num+1);
	// 		$("#"+nextId).remove();
	// 	}
	// 	while(curRow > minTime){
	// 		curRow -= 1;
	// 		prevId = curRow + "q" + cur[1] + "q" + cur[2];
	//
	// 		if($("#"+prevId).hasClass("well") && !$("#"+prevId).hasClass("aptm")){
	// 			var num = parseInt($("#"+prevId).attr('rowspan'));
	// 			$("#"+prevId).attr('rowspan', num+parseInt($("#"+id).attr('rowspan')));
	// 			$("#"+id).remove();
	// 			break;
	// 		}
	// 		if($("#"+prevId).length > 0){
	//   				break;
	// 		}
	// 	}
	// }
	//
	// function removeClickedCell(id){
	// 	if(!$("#"+id).hasClass("aptm")){
	// 		if($("#"+id).hasClass("well")){
	// 			removeCellClickProp(id);
	// 			var cur = id.split("q");
	// 			var num = parseInt($("#"+id).attr('rowspan'));
	// 			$("#"+id).attr('rowspan', '1');
	// 			for( var i = parseInt(cur[0])+1; i < (parseInt(cur[0]) + num); i++){
	// 				var next2 = i + "q" + parseInt(cur[1]) + "q" + cur[2];
	// 				var next2before = i + "q" + (parseInt(cur[1])-1) + "q" + cur[2];
	// 				var j = 2;
	// 				while($("#"+next2before).length <= 0){
	// 					next2before = i + "q" + (parseInt(cur[1])-j) + "q" + cur[2];
	// 					j++;
	// 				}
	// 				$("#"+next2before).after("<td id='"+next2+"' class='tdHover border' rowspan='1'></td>");
	// 			}
	// 			$('.tdHover').unbind("click", cellClick);
	// 			$('.tdHover').bind("click", cellClick);
	// 		}
	// 	}
	// }
	//
	// function addCellClickProp(id){
	// 	$("#"+id).addClass('well well-sm');
	// 	$("#"+id).html('clicked');
	// }
	//
	// function removeCellClickProp(id){
	// 	$("#"+id).removeClass('well well-sm');
	// 	$("#"+id).html('');
	// }
	//
	// function timeFromNum(num){
	// 	var timeStr;
	//
	// 	if(Math.floor(num/12) == 0){
	// 		timeStr = "AM";
	// 	}
	// 	else{
	// 		if(num != 12 && num != 12.5){
	// 			num -= 12;
	// 		}
	// 		timeStr = "PM";
	// 	}
	//
	// 	if(num%1 == 0){
	// 		timeStr = num + ":00" + timeStr;
	// 	}
	// 	else{
	// 		timeStr = (num-0.5) + ":30"  + timeStr;
	// 	}
	// 	return timeStr;
	// }
</script>

			