<?php
/* display message saved in session if any */
echo $this->Session->flash();
?>
<div class="findUserForm">
    <?php echo $this->Form->create('User', array('type'=>'post', 'action' => 'findUser', 'id' => 'userSearchForm')); ?>
    <fieldset>
        <legend><?php echo __('Find User'); ?></legend>
        <?php
        echo $this->Form->input('name', array(
        						'id' => 'userSearchText',
        						'autocomplete' => 'on',
        						));
        ?>
    </fieldset>
</div>

<table id="userResults">
<form id="hide"><input id="hide" type="submit"></form>
</table>
<form id="postUser" action="../../Wallets" method="post">
</form>

<script>
	function addUser(userID){
		
		if(<?php echo $wallet_id; ?> > 0){
			document.getElementById('postUser').action = "../../WalletRelations/addUser/"+<?php echo $wallet_id; ?>+'/'+userID+'/';	
			document.getElementById('postUser').submit();
		}
		else if(<?php echo $wallet_id; ?> == 0){
			document.getElementById('postUser').action = "../../Friends/add/"+userID+'/';
			document.getElementById('postUser').submit();
		}
	}
	
	$("#hide").hide();

	$(function(){
		
		var $input = $("#userSearchText").autocomplete({
			source: '../../users/findUserDrop/'+<?php echo $wallet_id; ?>+'',
		});
		$input.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			if(item['User']['inWallet'] == 0){
				return $( '<li onclick="addUser('+item['User']['id']+')">' ).append( '<a><center><div id="userSearchDropDown">\
						'+item['User']['username']+' | '+item['User']['firstName']+' '+item['User']['lastName']+'</div></center></a>' )
					.appendTo( ul );
			}
			else{
				return $( '<li>' ).append( '<a><center><div id="userSearchDropDown">\
						Previous Relationship: '+item['User']['username']+' | '+item['User']['firstName']+' '+item['User']['lastName']+'</div></center></a>' )
					.appendTo( ul );
			}
		};
		
		//Override close method 
 		var originalCloseMethod = $input.data("uiAutocomplete").close;
  		$input.data("uiAutocomplete").close = function(event) {
  	    	if (!selected){
  	        	//close requested by someone else, let it pass
   	         	originalCloseMethod.apply( this, arguments );
   	     	}
			selected = false;
  	 	};
  		 
	});

</script>