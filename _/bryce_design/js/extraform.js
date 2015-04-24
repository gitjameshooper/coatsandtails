// JavaScript Document

 
	 function checkfields(num)
{       


var y=document.forms["pet_form"]["full_name"].value;
var z=document.forms["pet_form"]["email_address"].value;
 var gen_ans = false;
 var gen_ans2 = false;
 var gen_ans3 = false;
  var port_ans = false;
 var port_ans2 = false;
 var port_ans3 = false;
 
 
   if(num == 1 ){
	   var a=document.getElementsByName("gender_1")[0].checked;     
        var b=document.getElementsByName("gender_1")[1].checked;
		var a_p=document.getElementsByName("portrait_name_1")[0].checked;     
        var b_p=document.getElementsByName("portrait_name_1")[1].checked;
	    
		if( a == true || b == true) { gen_ans = true;}else{ gen_ans== false;}
	   if( a_p == true || b_p == true) { port_ans = true;}else{ port_ans== false;}
        
		var w=document.forms["pet_form"]["pet1img1"].value;
		var x=document.forms["pet_form"]["pet_name_1"].value;
		 
		if ( gen_ans==false || port_ans==false || w==null || w=="" || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		    return false;
		  }
   }else if(num== 2){
	  var a=document.getElementsByName("gender_1")[0].checked;
		var b=document.getElementsByName("gender_1")[1].checked;
       var c=document.getElementsByName("gender_2")[0].checked;
       var d=document.getElementsByName("gender_2")[1].checked;
	   
	   var a_p=document.getElementsByName("portrait_name_1")[0].checked;     
        var b_p=document.getElementsByName("portrait_name_1")[1].checked;
		var c_p=document.getElementsByName("portrait_name_2")[0].checked;     
        var d_p=document.getElementsByName("portrait_name_2")[1].checked;
		
	    if( a == true || b == true) { gen_ans = true;}else{ gen_ans== false;}
		if( c == true || d == true) { gen_ans2 = true;}else{ gen_ans2== false;}
	   if( a_p == true || b_p == true) { port_ans = true;}else{ port_ans== false;}
	   if( c_p == true || d_p == true) { port_ans2 = true;}else{ port_ans2== false;}
			 
		var u=document.forms["pet_form"]["pet1img1"].value;
		var v=document.forms["pet_form"]["pet_name_1"].value;
		var w=document.forms["pet_form"]["pet2img1"].value;
		var x=document.forms["pet_form"]["pet_name_2"].value;
		
		if (  gen_ans=false || gen_ans2==false || port_ans==false || port_ans2==false || u==null || u=="" || v==null || v=="" || w==null || w=="" || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		  return false;
		  }
   }else if(num== 3){	
       var a=document.getElementsByName("gender_1")[0].checked;
		var b=document.getElementsByName("gender_1")[1].checked;
		var c=document.getElementsByName("gender_2")[0].checked;
		var d=document.getElementsByName("gender_2")[1].checked;
		var e=document.getElementsByName("gender_3")[0].checked;
		var f=document.getElementsByName("gender_3")[1].checked;
		 var a_p=document.getElementsByName("portrait_name_1")[0].checked;
		var b_p=document.getElementsByName("portrait_name_1")[1].checked;
		var c_p=document.getElementsByName("portrait_name_2")[0].checked;
		var d_p=document.getElementsByName("portrait_name_2")[1].checked;
		var e_p=document.getElementsByName("portrait_name_3")[0].checked;
		var f_p=document.getElementsByName("portrait_name_3")[1].checked;
		
		 if( a == true || b == true) { gen_ans = true;}else{ gen_ans== false;}
		if( c == true || d == true) { gen_ans2 = true;}else{ gen_ans2== false;}
		if( e == true || f == true) { gen_ans3 = true;}else{ gen_ans3== false;}
	   if( a_p == true || b_p == true) { port_ans = true;}else{ port_ans== false;}
	   if( c_p == true || d_p == true) { port_ans2 = true;}else{ port_ans2== false;}
	    if( e_p == true || f_p == true) { port_ans3 = true;}else{ port_ans3== false;}
		
		
		  
		var r=document.forms["pet_form"]["pet1img1"].value;
		var t=document.forms["pet_form"]["pet_name_1"].value;
		var u=document.forms["pet_form"]["pet2img1"].value;
		var v=document.forms["pet_form"]["pet_name_2"].value;
		var w=document.forms["pet_form"]["pet3img1"].value;
		var x=document.forms["pet_form"]["pet_name_3"].value;
		 
		
		if ( gen_ans=false || gen_ans2==false || gen_ans3==false || port_ans==false || port_ans2==false || port_ans3==false || r==null || r=="" || t==null || t=="" || u==null || u=="" || v==null || v=="" || w==null || w=="" 
		            || x==null || x=="" || y==null || y=="" || z==null || z=="")
		  {
		  alert("Please Enter info in All * Fields");
		  return false;
		  }
   }
	 
		
		 
}
	
 