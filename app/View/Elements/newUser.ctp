<?php $this->start('newUserModal'); ?>

	<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content opacity">
		  <div class="modal-header">
			<button type="button" class="close btn-cancel" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="newUserModalLabel">Please Create an Account to Continue</h4>
		  </div>
		  <div class="modal-body">
			<form class="myForm" id="newUserForm">
				<center>
				<fieldset>
					<div id="newUserUsernameDiv" class="form-group">
						<label id="newUserUsernameLabel" class="myFormLabel" for="newUsername">Username</label>
						<input type="text" class="form-control" name="username" id="newUserUsername" placeholder="username">              
					</div>
					<div id="newUserEmailDiv" class="form-group">
						<label id="newUserEmailLabel" class="myFormLabel" for="newEmail">Email</label>
						<input type="email" class="form-control" name="email" id="newUserEmail" placeholder="email">              
					</div>
					<div id="newUserFirstNameDiv" class="form-group">
						<label id="newUserFirstNameLabel" class="myFormLabel" for="newFirstName">First Name</label>
						<input type="text" class="form-control" name="firstName" id="newUserFirstName" placeholder="first name">              
					</div>
					<div id="newUserLastNameDiv" class="form-group">
						<label id="newUserLastNameLabel" class="myFormLabel" for="newLastName">Last Name</label>
						<input type="text" class="form-control" name="lastName" id="newUserLastName" placeholder="last name">              
					</div>
					<div id="newUserPasswordDiv" class="form-group">
						<label id="newUserPasswordLabel" class="myFormLabel" for="newPassword">Password</label>
						<input type="password" class="form-control" name="password" id="newUserPassword" placeholder="password">              
					</div>
					<div id="newUserPassworConfirmDiv" class="form-group">
						<label id="newUserPassworConfirmLabel" class="myFormLabel" for="newPasswordConfirm">Password Confirm</label>
						<input type="password" class="form-control" name="passwordConfirm" id="newUserPasswordConfirm" placeholder="password confirm">              
					</div>
				</fieldset>
				</center>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Close</button>
			<button id="newUserSubmit" type="button" class="btn btn-primary" onclick="newUser(this)">Submit</button>
		  </div>
		</div>
	  </div>
	</div>
	
<?php $this->end(); ?>

<?php $this->start('newUserScript'); ?>

<script>

	function newUser(e){
		var newUserData = $("#newUserForm").serialize();
		$(e).button('loading');
		$.post("<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'addAjax')); ?>", newUserData, function(data){
			$(e).button('reset');
			var result = JSON.parse(data);
			var resultStr = result.result;
			if(resultStr.indexOf("success") >= 0){
			
				$("#newUserUsernameDiv").removeClass("has-success has-error");
				$("#newUserFirstNameDiv").removeClass("has-success has-error");
				$("#newUserLastNameDiv").removeClass("has-success has-error");
				$("#newUserEmailDiv").removeClass("has-success has-error");
				$("#newUserPasswordDiv").removeClass("has-success has-error");
				$("#newUserPasswordConfirmDiv").removeClass("has-success has-error");
				
				// $("#newUserForm").trigger('reset');
				if(typeof newUserComplete == 'function'){
					newUserComplete(result.id);
				}
			}
			else{
				if( result.hasOwnProperty('errors') ){
					var errors = result.errors;
					if( errors.hasOwnProperty('username') ){
						$("#newUserUsernameDiv").removeClass("has-success").addClass("has-error");
						$("#newUserUsernameLabel").html("Username: " + errors.username);
					}
					else{
						$("#newUserUsernameDiv").removeClass("has-error").addClass("has-success");
						$("#newUserUsernameLabel").html("Username");
					}
			
					if( errors.hasOwnProperty('firstName') ){
						$("#newUserFirstNameDiv").removeClass("has-success").addClass("has-error");
						$("#newUserFirstNameLabel").html("First Name: " + errors.firstName);
					}
					else{
						$("#newUserFirstNameDiv").removeClass("has-error").addClass("has-success");
						$("#newUserFirstNameLabel").html("First Name");
					}
				
					if( errors.hasOwnProperty('lastName') ){
						$("#newUserLastNameDiv").removeClass("has-success").addClass("has-error");
						$("#newUserLastNameLabel").html("Last Name: " + errors.lastName);
					}
					else{
						$("#newUserLastNameDiv").removeClass("has-error").addClass("has-success");
						$("#newUserLastNameLabel").html("Last Name");
					}
			
					if( errors.hasOwnProperty('email') ){
						$("#newUserEmailDiv").removeClass("has-success").addClass("has-error");
						$("#newUserEmailLabel").html("Email: " + errors.email);
					}
					else{
						$("#newUserEmailDiv").removeClass("has-error").addClass("has-success");
						$("#newUserEmailLabel").html("Email");
					}
			
					if( errors.hasOwnProperty('password') ){
						$("#newUserPasswordDiv").removeClass("has-success").addClass("has-error");
						$("#newUserPasswordLabel").html("Password: " + errors.password);
					}
					else{
						$("#newUserPasswordDiv").removeClass("has-error").addClass("has-success");
						$("#newUserPasswordLabel").html("Password");
					}
				
					if( errors.hasOwnProperty('passwordConfirm') ){
						$("#newUserPasswordConfirmDiv").removeClass("has-success").addClass("has-error");
						$("#newUserPasswordConfirmLabel").html("Password Confirm: " + errors.passwordConfirm);
					}
					else{
						$("#newUserPasswordConfirmDiv").removeClass("has-error").addClass("has-success");
						$("#newUserPasswordConfirmLabel").html("Password Confirm");
					}
				}
			}
		});
	}

</script>

<?php $this->end(); ?>
