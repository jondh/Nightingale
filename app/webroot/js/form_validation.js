
function FormValidation(formNameI, submitUrlI, fieldArrayI, successFunctionI){
	
	var formName = formNameI;
	var submitUrl = submitUrlI;
	var fieldArray = fieldArrayI;
	var successFunction = successFunctionI;
	
	
	this.setInputOptions = function(){
		$("#"+formName+"Phone").mask("(999) 999-9999");
	}
	
	this.clearForm = function(){
		for(var i = 0; i < fieldArray.length; i++){
			$("#"+formName+fieldArray[i].name+"Div").removeClass("has-success has-error");
			$("#"+formName+fieldArray[i].name+"Label").html(fieldArray[i].displayName);
		}
		$("#"+formName+"Form").trigger('reset');
	}
	
	this.validateForm = function(){
		$("#"+formName+"Submit").click(function(){
			var btn = $(this);
			btn.button('loading');
			$.post( submitUrl, $("#"+formName+"Form").serialize(), function(data){
				btn.button('reset');
				var result = JSON.parse(data);
				var resultStr = result.result;
				if(resultStr.indexOf("success") >= 0){
					if(result.hasOwnProperty("data")){
						var resultData = result.data;
		
						for(var i = 0; i < fieldArray.length; i++){
							$("#"+formName+fieldArray[i].name).attr('value', resultData[fieldArray[i].dataName]);
						}
					}
					for(var i = 0; i < fieldArray.length; i++){
						$("#"+formName+fieldArray[i].name+"Div").removeClass("has-success has-error");
						$("#"+formName+fieldArray[i].name+"Label").html(fieldArray[i].displayName);
					}
					successFunction(result);
				}
				else{
					if( result.hasOwnProperty('errors') ){
						var errors = result.errors;
					
						for(var i = 0; i < fieldArray.length; i++){
							if( errors.hasOwnProperty( fieldArray[i].dataName ) ){
								$("#"+formName+fieldArray[i].name+"Div").removeClass("has-success").addClass("has-error");
								$("#"+formName+fieldArray[i].name+"Label").html(fieldArray[i].displayName + ": " + errors[fieldArray[i].dataName]);
							}
							else{
								$("#"+formName+fieldArray[i].name+"Div").removeClass("has-error").addClass("has-success");
								$("#"+formName+fieldArray[i].name+"Label").html(fieldArray[i].displayName);
							}
						}
					
					}
				}
		
			});
		});
	
	}
	
}
