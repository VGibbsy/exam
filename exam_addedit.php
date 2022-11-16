<?php
include 'include.php';
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
$sc_id=''; 
$sc_name='';
$sc_description='';
$sc_active='';
$op_mode='';

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

<?php

	$mode=$_GET["mode"]; 
	$id=$_GET["id"]; 

	if($_POST['BtnSubmit']=='Submit')
	{
		ob_start();
		if ($mode=='edit')
		{
		
			$chk_dis=0;	
			if ($_POST['ChkActive']=='ON')
			{
				$chk_dis=1;
			}
			else
			{
				$chk_dis=0;
			}
			$txt_name=$_POST['TxtExam'];
			$txt_desc=$_POST['TxtDescription'];
                        $txt_noofquestion=$_POST['TxtNoQuestion'];
                        $txt_pass=$_POST['TxtPass'];
                        
                        $sql="update  exam_master set e_name='$txt_name', e_description='$txt_desc', e_active=$chk_dis, e_no_of_question=$txt_noofquestion,e_pass_marks=$txt_pass where  e_id=".$id." " ; 
		    $result=mysql_query($sql) or die(mysql_error());
			
			header("location:exam.php"); 

	 
		}
		if ($mode=='add')
		{
		 
			$chk_dis=0;	
			if ($_POST['ChkActive']=='ON')
			{
				$chk_dis=1;
			}
			else
			{
				$chk_dis=0;
			}

			$txt_name=$_POST['TxtExam'];
			$txt_desc=$_POST['TxtDescription'];
                        $txt_noofquestion=$_POST['TxtNoQuestion'];
                        $txt_pass=$_POST['TxtPass'];

                        
			$result=mysql_query("select max(e_id)+1 as m from exam_master" );
			
			$id_=mysql_result($result,0,"m"); 
			
			$uid=$_SESSION['userid'];
			
		    $sql="insert into  exam_master values($id_,'$txt_name','$txt_desc',10,$txt_noofquestion,100,$txt_pass,$chk_dis,$uid,now())"; 
		    
		    $result=mysql_query($sql) or die(mysql_error());
			
			header("location:exam.php"); 

	
		}
		
	
	
		ob_end_flush();
	}


?>

<?php 

	
	if ($mode=='delete')
	{
	    $sql="delete from  exam_master where  e_id=".$id." ".$cond ;  
	    $result=mysql_query($sql) or die(mysql_error()); 
	    
		header("location:exam.php"); 
	}
	if ($mode=='edit')
	{
		$op_mode = "Edit Examination";
	    $sql="select * from  exam_master where e_id=".$id." "; 
	    $result=mysql_query($sql) or die(mysql_error());
	    
	    $em_id=mysql_result($result,0,"e_id"); 
	    
	    $em_name=mysql_result($result,0,"e_name");
	    $em_description=mysql_result($result,0,"e_description");
	    if (mysql_result($result,0,"e_active")==1)
	    {
	    	$em_active='Checked';
	    }
	    else
	    {
	    	$em_active='';

	    }
            $em_no_questions=mysql_result($result,0,"e_no_of_question");
            $em_pass=mysql_result($result,0,"e_pass_marks");
	}
	if ($mode=='add')
	{
		$op_mode = "Add New Exam";

	}

?>



<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Add / Edit Examination</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

<script language ="javascript" type ="text/javascript" >



	function GoBack()
	{
	
		window.location.href="exam.php";
	
	}
	
	function validateForm(theForm) 
	{
		
	    if (trimAll(document.form1.TxtSurvey.value).length == 0) 
	    {
	    	alert("Exam name can't blank." );
	    	document.form1.TxtSurvey.focus();
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
<form name="form1" onsubmit="return validateForm(this)" method="post" action="exam_addedit.php?mode=<?php echo($mode)?>&id=<?php echo($id)?>" >
<div align="center">
	<table border="0" width="100%" cellspacing="1" height="70" id="table1">
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
			
			
			
<table border="0" width="329" id="table9">
					<tr>
						<td width="323">
						<table border="0" width="100%" id="table10" style="border: 1px solid #00CC99">
							<tr>
								<td>
								<table border="0" width="100%" id="table11" cellpadding="2">
									<tr>
										<td align="left" class="td_tablecap1">Exam<b> &nbsp;&nbsp; - &nbsp;&nbsp<font color="red"> <?php echo($op_mode); ?></font></b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Exam ID</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
                                            <input type="text" name="TxtExamID" size="25" class ="TextBoxStyle" disabled value="<?php echo($em_id);?>" ></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Exam Name</td>
									</tr>
									<tr>
										<td align="left" valign="top" style="padding-left: 10px" >
                                            <input type="text" name="TxtExam" size="25" class ="TextBoxStyle" value="<?php echo($em_name);?>" ></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Exam
										Description</td>
									</tr>
									<tr>
										<td align="left" valign="top" style="padding-left: 10px">
                                            <textarea rows="3" name="TxtDescription" cols="24" class ="TextBoxArea" ><?php echo($em_description);?></textarea></td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            Exam Questions</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="text" name="TxtNoQuestion" size="25" class ="TextBoxStyle" value="<?php echo($em_no_questions);?>" ></td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            Exam
                                            Pass Percentage</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="text" name="TxtPass" size="25" class ="TextBoxStyle" value="<?php echo($em_pass);?>" ></td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="checkbox" name="ChkActive" value="ON" <?php echo($em_active);?> >Exam 
											is Active</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="submit" value="Submit" name="BtnSubmit" class="ButtonStyle">&nbsp; 
                                            <input type="reset" value="Reset" name="BtnReset" class="ButtonStyle">&nbsp;&nbsp; 
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