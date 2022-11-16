

<?php

include 'include.php';

if($_POST['BtnLogin']=='Login')
{
	ob_start();
	

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// Define $myusername and $mypassword 
	$myusername=$_POST['TxtUserName']; 
	$mypassword=$_POST['TxtPassword'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	
	$sql="SELECT * FROM member_master WHERE m_emailid='$myusername' and m_password='$mypassword' and m_active=1";
	$result=mysql_query($sql);
	
	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row
	
	if($count==1)
	{

		session_start();

		$_SESSION['username']= mysql_result($result,0,"m_name"); //$myusername; //
		$_SESSION['usertype']= mysql_result($result,0,"m_type");
		$_SESSION['useremail']= mysql_result($result,0,"m_emailid");
		$_SESSION['userid']= mysql_result($result,0,"m_id");

		header("location:my_account.php");
		}
	else 
	{
	
			$msg = urlencode("Invalid Login. Please try again with correct user name and password. ");
			header("Location:index.php?msg=$msg");
	
	}
	
	ob_end_flush();

}


?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Home</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">

	function validateForm(theForm) 
	{
		
    if (document.form1.TxtUserName.value.length == 0) 
    {
    	alert("Username can't blank." );
    	document.form1.TxtUserName.focus();
    	return false;

    } 
    
    if (document.form1.TxtPassword.value.length == 0) 
    {
    	alert("Password can't blank." );
    	document.form1.TxtUserName.focus();
    	return false;
    } 
     
	}
	
	function GoRegister()
	{
		
		window.location.href="register.php";
	}


</script>
</head>

<body>
<form name="form1" onsubmit="return validateForm(this)" method="post" action="index.php" >
<div align="center">
	<table border="0" width="100%" cellspacing="1" height="100%" id="table1">
		<tr>
			<td  align="center" class ="td_top">
			
			
			<?php 
			include 'header.php';
			?>
			
			</td>
		</tr>
		<tr >
			<td align="center" >
			&nbsp;
			<p>
				  <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages 
	  **************************************************************************/
      if (isset($_GET['msg'])) {
	  $msg =$_GET['msg'];// mysql_real_escape_string($_GET['msg']);
	  echo "<div class=\"msg\"><p class='Errortext'>$msg</p></div>";
	  }
	  /******************************* END ********************************/
			?>
			
			</p>
				<table border="0" width="600" id="table6">
					<tr>
						<td width="153">
						<img border="0" src="images/img1.jpg" width="144" height="183"></td>
						<td width="211">
						<table border="0" width="100%" id="table7" >
							<tr>
								<td>
								<table border="0" width="100%" id="table8" cellpadding="2">
									<tr>
										<td align="left"><b>Already a 
										Member? Login</b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom">
										Username</td>
									</tr>
									<tr>
										<td align="left" valign="top" >
                                            <input type="text" name="TxtUserName" size="20" class ="TextBoxStyle"></td>
									</tr>
									<tr>
										<td align="left" valign="bottom">
										Password</td>
									</tr>
									<tr>
										<td align="left" valign="top">
                                            <input type="password" name="TxtPassword" size="20"  class ="TextBoxStyle"></td>
									</tr>
									<tr>
										<td align="left">
                                            <input type="submit" value="Login" name="BtnLogin" class="ButtonStyle">&nbsp; </td>
									</tr>
									<tr>
										<td align="left">
										<a href="forget_password.php">Forget 
										Password</a></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
						<td width="3">&nbsp; </td>
						<td width="4" style="border-left-width: 2px; border-right-style: dotted; border-right-width: 2px; border-top-width: 2px; border-bottom-width: 2px">&nbsp;</td>
						<td width="0">&nbsp;</td>
						<td width="200" align="left" valign="top">&nbsp;<b><font face="Tahoma">New 
						User? Register Now</font></b><p>To start the test, 
						click here to register first.</p>
						<p>
                            <input type="button" value="Register" name="BtnRegister" class="ButtonStyle"  onclick="GoRegister()" >&nbsp;<p>
                                &nbsp;</p>
                        </td>
					</tr>
				</table>
				<p>&nbsp;</td>
		</tr>
		<tr>
			<td  align="center" class ="td_copyright">
			<?php 
			include 'footer.php';
			?>
			
			</td>
		</tr>
		
		
	</table>
</div>
</form>
</body>

</html>