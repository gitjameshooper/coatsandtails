// JavaScript Document

 
	 function checkfields(num)
{       


var y=document.forms["pet_form"]["full_name"].value;
var z=document.forms["pet_form"]["email_address"].value;
 
   
   if(num == 1 ){
	    
        
		var w=document.forms["pet_form"]["pet1img1"].value;
		var x=document.forms["pet_form"]["pet_name_1"].value;
		 
		if (  w==null || w=="" || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		    return false;
		  }
     
   }
	 	 
}
	
 