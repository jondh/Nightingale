function showWarningAlert(domId, message){
	$("#"+domId).append('\
	<div id="timeoutWarning" class="alert alert-warning">\
	    <a href="#" class="close" data-dismiss="alert">&times;</a>\
	    <strong>Warning!</strong> '+message+'\
	</div>');
}

function showErrorAlert(domId, message){
	$("#"+domId).append('\
	<div id="timeoutWarning" class="alert alert-error alert-danger">\
	    <a href="#" class="close" data-dismiss="alert">&times;</a>\
	    <strong>Warning!</strong> '+message+'\
	</div>');
}

function showInfoAlert(domId, message){
	$("#"+domId).append('\
	<div id="timeoutWarning" class="alert alert-info">\
	    <a href="#" class="close" data-dismiss="alert">&times;</a>\
	    <strong>Warning!</strong> '+message+'\
	</div>');
}

function showSuccessAlert(domId, message){
	$("#"+domId).append('\
	<div id="timeoutWarning" class="alert alert-success">\
	    <a href="#" class="close" data-dismiss="alert">&times;</a>\
	    <strong>Warning!</strong> '+message+'\
	</div>');
}