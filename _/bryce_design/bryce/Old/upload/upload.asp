<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Upload Photos</TITLE>

</HEAD>
<BODY>
<form action="send.asp" method="POST" enctype="multipart/form-data" name="ADD_PHOTO" id="ADD_PHOTO">
  Your Email 
    <input name="EMAIL" type="text" id="EMAIL">
    <br>
  Message: 
  <textarea name="EMAIL_MESSAGE" cols="40" id="EMAIL_MESSAGE"></textarea>
  <br>
  Browse:
  <input name="FILE_NAME" type="file" id="FILE_NAME"> 
  <input name="Submit" type="submit" value="Upload"> 
</form>
</BODY>
</HTML>