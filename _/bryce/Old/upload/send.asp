<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
Set Upload = Server.CreateObject("Persits.Upload")
Upload.OverwriteFiles = False

'set the path to upload files to --- special permissions will have to be set on this folder to allow upload
Upload.Save Server.MapPath("upload")
%>
<% 'set up and send email
	Dim objCDO
	Set objCDO = Server.CreateObject("CDONTS.NewMail")
	'----edit these lines to fit your needs-----
	objCDO.From = cStr(Upload.Form("EMAIL")) 			'email sent from
	objCDO.To = "EMAIL@gmail.com" 				'email sent to
	objCDO.Subject = "This is the subject line"				'subject line
	objCDO.Body = cStr(Upload.Form("EMAIL_MESSAGE")) 		'body of email
	'----do not edit these lines----------
	objCDO.Send() 						'send mail
	Set objCDO = Nothing 
	
	'----edit this lines to fit your needs-----
	Response.Write("Upload was successful and email was sent<br>") 	'send a message to the user
%>

<% 'here are all your varuables
Response.Write(Upload.Form("EMAIL")&"<br>")
Response.Write(Upload.Form("EMAIL_MESSAGE"))
%>