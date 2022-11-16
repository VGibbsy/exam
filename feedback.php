<?php
include 'include.php';
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");


session_start();
if(!isset($_SESSION['username']) || trim($_SESSION['username'])=='')
{
	header("location:index.php");
}
else
{
	$userid=$_SESSION['userid'];
	$username=$_SESSION['username'];
	$usertype=$_SESSION['usertype'];

}
?>

<?php


	if($_POST['BtnSubmit']=='Submit')
	{
	
		
	 	$result1=mysql_query("select IFNULL(max(f_id),0)+1 m from feedback_master");	
	 	$f_id=mysql_result($result1,0,"m");
		
		$t_subject=$_POST['TxtSubject'];
		$t_feedback=$_POST['TxtFeedback'];
		
		$sql="insert into feedback_master (f_id,f_date,f_subject,f_feedback,f_um_id) values($f_id,sysdate(),'$t_subject','$t_feedback',$userid)";
    echo $sql;
                $result=mysql_query($sql) or die(mysql_error());
    
    header("location:feedback_complete.php"); 
    
	}

?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Feedback</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

<script language ="javascript" type ="text/javascript" >



	function GoBack()
	{
	
		location.href("my_account.php");
	
	}
	
	function validateForm(theForm) 
	{

		var f1=trimAll(document.form1.TxtSubject.value);
		var f2=trimAll(document.form1.TxtFeedback.value);
		
	    if (f1.length == 0) 
	    {
	    	alert("Enter subject" );
	    	document.form1.TxtSubject.focus();
	    	return false;
	
	    } 
	   if (f2.length == 0) 
	    {
	    	alert("Enter feedback" );
	    	document.form1.TxtFeedback.focus();
	    	return false;
	
	    } 
    	return true;
	}
	
	function trimAll(sString)
{
while (sString.substring(0,1) == ' ')
{
sString = sString.substring(1, sString.length);
}
while (sString.substring(sString.length-1, sString.length) == ' ')
{
sString = sString.substring(0,sString.length-1);
}
return sString;
} 

</script>



</head>

<body>
<form name="form1" onsubmit="return validateForm(this)" method="post" action="feedback.php" >
<div align="center">
	<table border="0" width="100%" cellspacing="1" height="100%" id="table1">
		<tr>
			<td  align="center" class ="td_top">
			<?php 
			    include 'header.php';
			?>
                            
                        </td>
		</tr>
		<tr>
			<td  align="left" class ="td_topvav" >
			<table width ="100%" align ="left">
				<tr>
					<td width="33%" align ="left" style="padding-left: 10px" valign="top">
						Welcome <b><?php echo($username.'</b> ('.$usertype.')') ?>  
					</td>
					<td  width="64%" align="right" style="padding-right: 10px" valign="top">
					<?php
						include 'menu.php';	
					
					?>					

                                            
					</td>
				</tr>


			</table>
			
			
			
			</td>
		</tr>
		
		<tr >
			<td align="center" >
			&nbsp;

				
				<br>

			<p>
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
			
			
<table border="0" width="329" id="table9">
					<tr>
						<td width="323">
						<table border="0" width="100%" id="table10" style="border: 1px solid #00CC99">
							<tr>
								<td >

									
								<table border="0" width="100%" id="table11" cellpadding="2">
									<tr>
										<td align="left" class="td_tablecap1">
										<b>
										Send Feedback </b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Subject</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										<input type="text" name="TxtSubject" size="40"></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Your Feedback</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										<textarea rows="4" name="TxtFeedback" cols="34"></textarea></td>
									</tr>
									<tr>
										<td align="left" valign="top" style="padding-left: 10px" >
                                            &nbsp;</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="submit" value="Submit" name="BtnSubmit" class="ButtonStyle">&nbsp; 
                                            <input type="button" value=" Back " name="BtnBack" class="ButtonStyle" onclick="GoBack()"></td>
									</tr>
									</table>
								</td>
							</tr>
						</table>
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