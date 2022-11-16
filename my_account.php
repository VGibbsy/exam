
<?php

session_start();
if(!isset($_SESSION['username']) || trim($_SESSION['username'])=='')
{
	//header("location:index.php");
}
else
{
	$username=$_SESSION['username'];
	$usertype=$_SESSION['usertype'];

}
?>




<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: My Page</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="form1" onsubmit="return validateForm(this)" method="post" action="my-account.php" >
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

				<table border="0" width="455" id="table6" height="117">
					<tr>
						<td width="449">
						<p align="center"><b>Welcome to eExamination</b></p>
						<p align="center">
						<img border="1" src="images/img1.jpg" width="118" height="146"></p>
						<p align="center"><b><font size="3">Online Examination 
						System</font></b></td>
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