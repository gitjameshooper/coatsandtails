// JavaScript Document

 
	 function checkfields(num)
{       

var y=document.forms["pet_form"]["full_name"].value;
var z=document.forms["pet_form"]["email_address"].value;
   if(num == 1){
	    
        var w=document.forms["pet_form"]["pet1img1"].value;
		var x=document.forms["pet_form"]["pet_name_1"].value;
		if ( w==null || w=="" || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		    return false;
		  }
   }else if(num== 2){
		var u=document.forms["pet_form"]["pet1img1"].value;
		var v=document.forms["pet_form"]["pet_name_1"].value;
		var w=document.forms["pet_form"]["pet2img1"].value;
		var x=document.forms["pet_form"]["pet_name_2"].value;
		if (  u==null || u=="" || v==null || v=="" || w==null || w=="" 
		            || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		  return false;
		  }
   }else if(num== 3){	
		var r=document.forms["pet_form"]["pet1img1"].value;
		var t=document.forms["pet_form"]["pet_name_1"].value;
		var u=document.forms["pet_form"]["pet2img1"].value;
		var v=document.forms["pet_form"]["pet_name_1"].value;
		var w=document.forms["pet_form"]["pet3img1"].value;
		var x=document.forms["pet_form"]["pet_name_3"].value;
		
		
		if (r==null || r=="" || t==null || t=="" || u==null || u=="" || v==null || v=="" || w==null || w=="" 
		            || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		  return false;
		  }
   }
	 
		
		 
}
	
 