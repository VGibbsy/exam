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
	$username=$_SESSION['username'];
	$usertype=$_SESSION['usertype'];

}
?>




<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: User Feedback</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="form1"   method="post" action="feedback_admin.php" >
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
&nbsp;<?php
				
					//get feedback
					$result = mysql_query("select f.*,u.* from feedback_master f,member_master u where f.f_um_id=u.m_id order by f.f_date desc");
					$count=mysql_num_rows($result);
					
				?>
			<table border="1" width="660" cellspacing="1" id="table12" style="border-collapse: collapse">
				<tr>
					<td colspan="4" class="td_tablecap"><?php echo($count); ?> 
					User Feedback&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				</tr>
				<tr>
					<td width="170" class="td_tablehead">Date</td>
					<td width="200" class="td_tablehead">Subject</td>
					<td width="205" class="td_tablehead">Feedback</td>
					<td width="98" class="td_tablehead">Member</td>
				</tr>
				
				<?php
				
				if ($count>0)
				{
					$i=0;
					$j='';
					for($i=0;$i<$count; $i++)
					{
						$j=$i+1;
						echo("<tr>");
							echo("<td width='170' align ='center' valign ='top'>".mysql_result($result,$i,"f_date")."</td>");
							echo("<td width='200' align ='left' valign ='top'>".mysql_result($result,$i,"f_subject")."</td>");
							echo("<td width='305' align ='left' valign ='top'>".mysql_result($result,$i,"f_feedback")."</td>");
							echo("<td width='98' align ='left' valign ='top'>".mysql_result($result,$i,"m_name")."</td>");
						echo("</tr>");
					}
				}
				else
				{
							echo("<td width='51' align ='center' valign ='top'>&nbsp;</td>");
							echo("<td width='205' align ='left' valign ='top'>&nbsp;</td>");
							echo("<td width='98' align ='left' valign ='top'>&nbsp;</td>");
				}
				
				?>
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