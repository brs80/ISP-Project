var valid;


//validates a given field to a regular expression and changes
//border to red if it fails and black if it passes
function validate(field, re)
{
	var pos=field.value.search(re);
        if (pos!=0)
	{
		//field.style.borderColor = "red";
		$(field).addClass("Invalid");
		valid=false;
		return false;
	}
	else
	{
		$(field).removeClass("Invalid");
		//field.style.borderColor = "black";
		return true;
	}
}

//These functions validate each of the fields
function nameValidator()
{
	var name = document.getElementById("nameBox");
	var re = new RegExp(/^[A-Z][a-z]+ [A-Z][a-z]+$/);
	
	return validate(name,re);
}


function matterValidator(event)
{
	var name = event.target;
	var re = new RegExp(/^[1-9]/);
	return validate(name,re);
}

function passwordValidator()
{
	var pword = document.getElementById("password");
	var re = new RegExp(/^(\S){8}(\S)+$/);
    //var pos = pword.value.search(/^(\S){8}(\S)+$/);
	var hasnum = pword.value.search(/[0-9]/);
	//console.log(pword.style.borderColor);
	if (!validate(pword,re) != 0 || hasnum == -1) {
		pword.style.borderColor = "red";
		return false;
	} 
	else
	{
		pword.style.borderColor = "black";
		return true;
	}	
}

function emailValidator()
{
	var field = document.getElementById("email");
	var re = new RegExp(/^[\w\.]+@[a-zA-Z_]+?\.[a-zA-Z]+$/);
	return validate(field,re);
  
}


function phoneValidator()
{
	var field = document.getElementById("phone");
	var re = new RegExp(/^[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/);
	return validate(field,re);
}


function addressValidator()
{
	var field = document.getElementById("address");
	var re = new RegExp(/^[\S\s]+$/);
	return validate(field,re);
} 


function dateValidator(event)
{
	var field = event.target;
	var re = new RegExp(/^(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])\/[0-9]{4}$/);
	return validate(field,re);
}

function mySqlDateValidator(event)
{
	var field = event.target;
	var re = new RegExp(/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/);
	return validate(field,re);
}

function timeValidator()
{
	var field = document.getElementById("time");
	var re = new RegExp(/^(0[1-9]|1[012])\:[0-5][0-9] [ap]m$/);
	return validate(field,re);
}

function numericValidator(event)
{
	var field = event.target;
	var re = new RegExp(/^[0-9.]+$/);
	return validate(field,re);
}

function validateForm(formToValidate)
{
	

    valid = true;
	$('.validated').each(function(){
		try
		{
			$(this).blur();
//			console.log(elementValid);
//			valid = $(this).blur() && valid;
		}
		catch (err) {}
	});
		
	if (!valid) alert("There are invalid entries.");
	return valid;
}

