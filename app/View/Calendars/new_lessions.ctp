<?php
	echo $this->element('newUser');
?>


<script src="https://checkout.stripe.com/checkout.js"></script>

<div id="alertArea"></div>

<div class="container" style="width:100%;">
	<div class="col-md-8">
		<h1 class="well">Choose Your <?php echo $length; ?>min Lesson(s)</h1>
		<div class="jumbotron" id="calendar"></div>
	</div>
	<div class="col-md-4">
		<?php if($credits > 0){ ?>
		<h1 class="well">
			You have <span id="totalCredits"><?php echo $credits; ?></span> credit(s).
		</h1>
		<?php } ?>
		<h1 class="well">
			$<span id="totalAmount">0</span>
			<button id="submitBtn" class="btn btn-primary" onclick="submitEntries(this)" style="width:100%" disabled>Submit</button>
		</h1>
		<ul id="selectedLessons" class="list-group">
			<a class="list-group-item active h3">
				<span id="lessonNum">0</span> Lessons
			</a>
		</ul>
	</div>
	
</div>

<?php echo $this->fetch('newUserModal'); ?>

<?php echo $this->fetch('newUserScript'); ?>

<script>

	var lessonTime = <?php echo json_encode($length); ?>;
	var numLessons = 0;
	var minNewLessons = 4;
	var pricePerMinute = .825;
	var amount = 0;
	
	var myLessons = <?php echo json_encode($myLessions); ?>;
	var otherLessons = <?php echo json_encode($otherLessions); ?>;
	var blocks = <?php echo json_encode($blocks); ?>;
	var credits = <?php echo json_encode($credits); ?>;
	var newEntries = [];
	
	var userId = <?php 	
			if($loggedIn){
				echo json_encode($user['id']);
			}
			else{
				echo -1;
			}
	?>;
	
	if(myLessons == ""){
		var newPaid = minNewLessons - credits;
		if(newPaid < 0){ newPaid = 0; }
		$("#totalAmount").empty().append(lessonTime*newPaid*pricePerMinute);
		$("#submitBtn").empty().append("Please Select At Least "+minNewLessons+" Lessons");
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
				endDate.add('minutes', lessonTime);
				var sources = $("#calendar").fullCalendar( 'clientEvents', function(e){
					if( ( (moment(e.start).isBefore(date) || moment(e.start).isSame(date)) && moment(e.end).isAfter(date)) || ( moment(e.start).isBefore(endDate) && (moment(e.end).isAfter(endDate) || moment(e.end).isSame(endDate)) ) || (moment(e.start).isAfter(date) && moment(e.end).isBefore(endDate)) ){
						return true;
					}
					return false;
				} );
		        
				if(sources.length == 0){
					addLessonShow(date);
					$('#calendar').fullCalendar('addEventSource',
						{
							events: [
								{
									id: 'entry'+numLessons,
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
			if(myLessons){
				for(var i = 0; i < myLessons.length; i++){
					var startDate = moment.utc(myLessons[i].CalendarEntry.time, "YYYY-MM-DD HH:mm:ss");
					var endDate = moment.utc(startDate);
					endDate.add('minutes', myLessons[i].CalendarEntry.length);
					events.push({
						title: myLessons[i].CalendarEntry.description,
						start: startDate.toISOString(),
						end: endDate.toISOString(),
						backgroundColor: "#1202c4",
						borderColor: "#aaaaaa"
					});
				}
			}
			if(otherLessons){
				for(var i = 0; i < otherLessons.length; i++){
					var startDate = moment.utc(otherLessons[i].CalendarEntry.time, "YYYY-MM-DD HH:mm:ss");
					var endDate = moment.utc(startDate);
					endDate.add('minutes', otherLessons[i].CalendarEntry.length);
					events.push({
						title: otherLessons[i].CalendarEntry.description,
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

	
	function addLessonShow(d){
		numLessons++;
		setCredits();
		newEntries.push({
			cal_id: 'entry'+numLessons,
			user_id: userId,
			calendar_id: <?php echo json_encode($calendar['Calendar']['id']); ?>,
			time: d.format("YYYY-MM-DD HH:mm:ss"),
			length: lessonTime,
			type: 1,
			description: "lesson",
			timeStamp: ""
		});
		if(myLessons != ""){
			setTotalAmount(numLessons);
			$("#submitBtn").attr('disabled', false);
		}
		else if(numLessons >= minNewLessons){
			setTotalAmount(numLessons);
			$("#submitBtn").attr('disabled', false);
			$("#submitBtn").empty().append("Purchase");
		}
		$("#lessonNum").empty().append(numLessons);
		$("#selectedLessons").append("<div id='entry"+numLessons+"' class='list-group-item' onclick='removeEntry(this)'><span class='glyphicon glyphicon-remove'></span> "+d.format("dddd, MMMM Do YYYY, h:mm:ss a")+"</div>");
	}
	
	function removeEntry(e){
		$("#calendar").fullCalendar('removeEvents', e.id);
		$(e).remove();
		revomeIdFromEntries(e.id);
		setCredits();
		if(myLessons != ""){
			setTotalAmount(numLessons);
			if(numLessons == 0){
				$("#submitBtn").attr('disabled', true);
			}
		}
		else if(numLessons < minNewLessons){
			setTotalAmount(minNewLessons);
			$("#submitBtn").attr('disabled', true);
			$("#submitBtn").empty().append("Please Select At Least "+minNewLessons+" Lessons");
		}
		else{
			setTotalAmount(numLessons);
		}
	}
	
	function setCredits(){
		var creditsLeft = credits - numLessons;
		if(creditsLeft >= 0){
			$("#totalCredits").empty().append(creditsLeft);
		}
	}
	
	function setTotalAmount(lessonAmount){
		var newPaid = lessonAmount - credits;
		if(newPaid < 0){ newPaid = 0; }
		$("#totalAmount").empty().append(lessonTime*newPaid*pricePerMinute);
	}
	
	function revomeIdFromEntries(id){
		for(var i = 0; i < newEntries.length; i++){
			if(newEntries[i].cal_id === id){
				newEntries.splice(i,1);
				numLessons--;
				$("#lessonNum").empty().append(numLessons);
				break;
			}
		}
	}
	
	function stripePayment(){
		showOverlay();
		amount = (numLessons-credits)*lessonTime*pricePerMinute*100;
		if(amount <= 0){
			postEntries();
		}
		else{
			var tokenFun = false;
			var handler = StripeCheckout.configure({
				key: 'pk_test_2D3yhzZkwDUZsiU6awirfaNK',
				image: '/square-image.png',
				allowRememberMe: false,
				closed: function(){
					if(!tokenFun){
						hideOverlay();
					}
				},
				token: function(token) {
					tokenFun = true;
					var inputData = {
						token: token.id,
						email: token.email,
						amount: amount,
						number_of_lessons: (numLessons-credits),
						lesson_length: lessonTime
					};
					// timeout function
					var hasReturned = false;
					setTimeout(function(){
						if(!hasReturned){
							showWarningAlert("alertArea", "Something is not happening. Try later please.");
						}	
					}, 15000);
				
					$.post("<?php echo $this->Html->url(array('controller'=>'payments', 'action'=>'processAndAdd')); ?>", inputData, function(data){
						hasReturned = true;
						var result = JSON.parse(data);
						if(result.result === "success"){
							showSuccessAlert("alertArea", "You were charged successfully.");
							postEntries();
						}
						else{
							if(result.hasOwnProperty("type")){
								if(result.type === "add"){
									showErrorAlert("alertArea", "Something is wrong on our end. Please try later or contact us if the problem persists.");
								}
							}
							showErrorAlert("alertArea", "Something is wrong. You should not have been charged.");
						}
					});
				}
			});

			handler.open({
			  name: 'Nightingale',
			  description: numLessons + ' ' + lessonTime + 'min Lesson(s)',
			  amount: amount
			});
		}
	}
	
	function submitEntries(btn){
		var loggedIn = <?php echo json_encode($loggedIn); ?>;
		if(loggedIn){
			stripePayment();
		}
		else{
			$("#newUserModal").modal('show');
		}
		
	}
	
	function newUserComplete(id){
		for(var i = 0; i < newEntries.length; i++){
			newEntries[i].user_id = id;
		}
		stripePayment();
	}
	
	function postEntries(){
		$.post("<?php echo $this->Html->url(array('controller'=>'calendar_entries', 'action'=>'addMany')); ?>", JSON.stringify(newEntries), function(data){
			alert(data);
			hideOverlay();
			location.reload();
		});
	}
	
</script>

			