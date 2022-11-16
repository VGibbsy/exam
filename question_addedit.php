<?php
include 'include.php';
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
$sc_id=''; 
$sc_name='';
$sc_description='';
$sc_active='';
$op_mode='';

//question
$qm_id='';
$qm_text='';
$qm_active='';
$sm_active='';
//answer


session_start();
if(!isset($_SESSION['username']) || trim($_SESSION['username'])=='')
{
	header("location:index.php");
}
else
{
	$uid=$_SESSION['userid'];
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
			

			//get right option
			$chk_op1=0;
			if ($_POST['Chk1']=='ON'||$_POST['Rd1']=='V2')
			{
				$chk_op1=1;
			}
			else
			{
				$chk_op1=0;
			}

			$chk_op2=0;
			if ($_POST['Chk2']=='ON'||$_POST['Rd1']=='V3')
			{
				$chk_op2=1;
			}
			else
			{
				$chk_op2=0;
			}
			
			$chk_op3=0;
			if ($_POST['Chk3']=='ON'||$_POST['Rd1']=='V4')
			{
				$chk_op3=1;
			}
			else
			{
				$chk_op3=0;
			}
			
			$chk_op4=0;
			if ($_POST['Chk4']=='ON'||$_POST['Rd1']=='V5')
			{
				$chk_op4=1;
			}
			else
			{
				$chk_op4=0;
			}
			
			
		 	$result1=mysql_query("select e_id from exam_master where e_name='".$_POST['DdlExam']."'");	
		 	$em_id=mysql_result($result1,0,"e_id");
			$txt_question=$_POST['TxtQuestion'];
			$txt_type=$_POST['DdlAnswerType'];
			
                        $sql="update  question_master set q_exam_id=$em_id, q_text='$txt_question', q_type='$txt_type', q_active=$chk_dis where q_id=".$id; 
		  
		  echo($sql);
		  //exit();
		  
		  $result=mysql_query($sql) or die(mysql_error());
			
			//delete options
			$sql="delete from  answer_master where a_question_id=".$id; 
                        $result=mysql_query($sql) or die(mysql_error()); 
	    			
			//insert options
			$result1=mysql_query("select ifnull(max(a_id)+1,1) m from answer_master");	
		 	$o_id=mysql_result($result1,0,"m");
			//op 1
		 	$txt_opt=$_POST['TxtOption1'];		 	
			$sql="insert into answer_master values($o_id,$id,'$txt_opt',$chk_op1,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			//op 2
		 	$txt_opt=$_POST['TxtOption2'];
			$sql="insert into answer_master values($o_id,$id,'$txt_opt',$chk_op2,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());			
			//op 3
		 	$txt_opt=$_POST['TxtOption3'];
			$sql="insert into answer_master values($o_id,$id,'$txt_opt',$chk_op3,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			//op 4
		 	$txt_opt=$_POST['TxtOption4'];
			$sql="insert into answer_master values($o_id,$id,'$txt_opt',$chk_op4,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			
			header("location:question.php"); 

	 
		}
		if ($mode=='add')
		{
		 
		 //echo($_POST['Chk1']);
		 //exit;
			$chk_dis=0;	
			if ($_POST['ChkActive']=='ON')
			{
				$chk_dis=1;
			}
			else
			{
				$chk_dis=0;
			}
			
			//get right option
			$chk_op1=0;
			if ($_POST['Chk1']=='ON'||$_POST['Rd1']=='V2')
			{
				$chk_op1=1;
			}
			else
			{
				$chk_op1=0;
			}

			$chk_op2=0;
			if ($_POST['Chk2']=='ON'||$_POST['Rd1']=='V3')
			{
				$chk_op2=1;
			}
			else
			{
				$chk_op2=0;
			}
			
			$chk_op3=0;
			if ($_POST['Chk3']=='ON'||$_POST['Rd1']=='V4')
			{
				$chk_op3=1;
			}
			else
			{
				$chk_op3=0;
			}
			
			$chk_op4=0;
			if ($_POST['Chk4']=='ON'||$_POST['Rd1']=='V5')
			{
				$chk_op4=1;
			}
			else
			{
				$chk_op4=0;
			}

			
		 	$result1=mysql_query("select e_id from exam_master where e_name='".$_POST['DdlExam']."'");	
		 	$em_id=mysql_result($result1,0,"e_id");
		 	
		 	$result1=mysql_query("select ifnull(max(q_id)+1,1) m from question_master ");	
		 	$q_id=mysql_result($result1,0,"m");
		 	
			$txt_question=$_POST['TxtQuestion'];
			$txt_type=$_POST['DdlAnswerType'];
			
		  $sql="insert into question_master values($q_id,$em_id,'$txt_question','$txt_type',$chk_dis,$uid,sysdate()) "; 
		  echo($_POST['DdlExam']);

		  echo($sql);
		  //exit;
		  $result=mysql_query($sql) or die(mysql_error());
			
			//delete options
			$sql="delete from  answer_master where a_question_id=".$q_id; 
	    $result=mysql_query($sql) or die(mysql_error()); 
	    			
			//insert options
			$result1=mysql_query("select max(a_id)+1 m from answer_master");	
		 	$o_id=mysql_result($result1,0,"m");
			//op 1
		 	$txt_opt=$_POST['TxtOption1'];
		 	$filename = stripslashes($_FILES['File1']['name']);		 	
		 	$image_name=$filename;
			$newname="images/".$image_name;
			$copied = copy($_FILES['image']['File1'], $newname); 	
		 	$txt_image=$filename;
			$sql="insert into answer_master values($o_id,$q_id,'$txt_opt',$chk_op1,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			//op 2
		 	$txt_opt=$_POST['TxtOption2'];
		 	$filename = stripslashes($_FILES['File2']['name']);		 	
		 	$image_name=$filename;
			$newname="images/".$image_name;
			$copied = copy($_FILES['image']['File2'], $newname); 	
		 	$txt_image=$filename;
			$sql="insert into answer_master values($o_id,$q_id,'$txt_opt',$chk_op2,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());			
			//op 3
		 	$txt_opt=$_POST['TxtOption3'];
		 	$filename = stripslashes($_FILES['File3']['name']);		 	
		 	$image_name=$filename;
			$newname="images/".$image_name;
			$copied = copy($_FILES['image']['File3'], $newname); 	
		 	$txt_image=$filename;
			$sql="insert into answer_master values($o_id,$q_id,'$txt_opt',$chk_op3,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			//op 1
		 	$txt_opt=$_POST['TxtOption4'];
		 	$filename = stripslashes($_FILES['File4']['name']);		 	
		 	$image_name=$filename;
			$newname="images/".$image_name;
			$copied = copy($_FILES['image']['File4'], $newname); 	
		 	$txt_image=$filename;
			$sql="insert into answer_master values($o_id,$q_id,'$txt_opt',$chk_op4,$uid,now())";$o_id=$o_id+1;
			$result=mysql_query($sql) or die(mysql_error());
			
			header("location:question.php"); 

	
		}
		
	
	
		ob_end_flush();
	}


?>

<?php 

	
	if ($mode=='delete')
	{
            $sql="delete from  answer_master where a_question_id=".$id; 
	    $result=mysql_query($sql) or die(mysql_error()); 
		
	    $sql="delete from  question_master where q_id=".$id; 
	    $result=mysql_query($sql) or die(mysql_error()); 
	    
            header("location:question.php"); 
	}
	if ($mode=='edit')
	{
		$op_mode = "Edit Question";
		$sql="SELECT q.*, o.*, e.* FROM question_master q, answer_master o, exam_master e 
			where q.q_exam_id=e.e_id and o.a_question_id=q.q_id and q_id=".$id."  ";
		
		//echo $sql;
		
	    $result=mysql_query($sql);// or die(mysql_error());

	    $qm_id=mysql_num_rows($result);
	    $qm_id=mysql_result($result,0,"q_id");
	    $qm_text=mysql_result($result,0,"q_text");
	    if (mysql_result($result,0,"q_active")==1)
	    {
	    	$qm_active='Checked';
	    }
	    else
	    {
	    	$qm_active='';
	    }
	    $em_name=mysql_result($result,0,"e_name");
	    $em_active=" disabled ";
	    //get options 
	   
	    
	    $qm_type=mysql_result($result,0,"q_type");
	    
	   	$op_text1=mysql_result($result,0,"a_answer");
	  	$op_text2=mysql_result($result,1,"a_answer");
	  	$op_text3=mysql_result($result,2,"a_answer");
	  	$op_text4=mysql_result($result,3,"a_answer");
	  	

	    
	    if (mysql_result($result,0,"a_rightanswer")=="1" )
	    {
	   		$rightoption_1 ='Checked';
	   	}
	   	else
	   	{
	   		$rightoption_1 ='';
	   	}
	    if (mysql_result($result,1,"a_rightanswer")=="1" )
	    {
	   		$rightoption_2 ='Checked';
	   	}
	   	else
	   	{
	   		$rightoption_3 ='';
	   	}
	   	if (mysql_result($result,2,"a_rightanswer")=="1" )
	    {
	   		$rightoption_3 ='Checked';
	   	}
	   	else
	   	{
	   		$rightoption_3 ='';
	   	}
	   	if (mysql_result($result,3,"a_rightanswer")=="1" )
	    {
	   		$rightoption_4 ='Checked';
	   	}
	   	else
	   	{
	   		$rightoption_4 ='';
	   	}
  
	    
	    
	    if ($qm_type=="SINGLE")
	    {
                /*
	    	$text_display=" ";
	    	$chk_display="style='display:none'";
	    	$rd_display=" ";
                 * */
                 
	    	
	    }

            if ($qm_type=='MULTIPLE')
            {
                /*
                $file_display=" ";
                $chk_display=" ";
                $rd_display="style='display:none' ";
                 * 
                 */
            }
	  	



	}
	if ($mode=='add')
	{
		$op_mode = "Add New Question";
		$sm_active="";
		

	    	
    	$text_display=" ";
    	/*$chk_display="style='display:none'";*/
    	$rd_display=" ";

	    	

	}

?>



<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Questions</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

<script language ="javascript" type ="text/javascript" >



	function GoBack()
	{
		window.location.href="question.php";
	}
	
	function validateForm(theForm) 
	{
		

		
	    if (trimAll(document.form1.TxtQuestion.value).length == 0) 
	    {
	    	alert("Question text can't blank." );
	    	document.form1.TxtQuestion.focus();
	    	return false;
	
	    } 
    	return true;
	}
	
	function DisplayControl()
	{
		var sel_text=document.form1.DdlAnswerType.options[document.form1.DdlAnswerType.selectedIndex].text;
		return;
                //alert(sel_text);
		if (sel_text=='SINGLE')
		{
			
			document.form1.Chk1.style.display="none";
			document.form1.Rd1.style.display="block";
			document.form1.Chk2.style.display="none";
			//document.form1.Rd1.style.display=" ";
			document.form1.Chk3.style.display="none";
			//document.form1.Rd3.style.display=" ";
			document.form1.Chk4.style.display="none";
			//document.form1.Rd4.style.display=" ";
			
			
		}
		
                if (sel_text=='MULTIPLE')
		{
			//var rbtn = document.getElementById('Rd1');
			//rbtn.style.display = 'none';
                        
			document.form1.Chk1.style.display="";
			document.form1.Rd1.style.display="none";
			document.form1.Chk2.style.display=" ";
			//document.form1.Rd2.style.display="none";
			document.form1.Chk3.style.display="";
			//document.form1.Rd3.style.display="none";
			document.form1.Chk4.style.display="";
			//document.form1.Rd4.style.display="none";
			
			
			
		}
	
		
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
<form name="form1" onsubmit="return validateForm(this)" method="post" action="question_addedit.php?mode=<?php echo($mode)?>&id=<?php echo($id)?>" enctype="multipart/form-data" >
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
			
			
			
<table border="0" width="497" id="table9">
					<tr>
						<td width="491">
						<table border="0" width="100%" id="table10" style="border: 1px solid #A8874A">
							<tr>
								<td>
								<table border="0" width="483" id="table11" cellpadding="2">
									<tr>
										<td align="left" class="td_tablecap1" width="475" colspan="2">
										Question Bank<b> &nbsp;&nbsp; - &nbsp;&nbsp<font color="red"> <?php echo($op_mode); ?></font></b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
										Exam :
										<select size="1" name="DdlExam"   >
										<?php
											session_start();
									    $sql1="select e_name from  exam_master where e_active=1 order by e_name " ; 
  										$result=mysql_query($sql1) or die(mysql_error());
  										$count=mysql_num_rows($result);
											$i=0;
											for($i=0;$i<$count; $i++)
											{
												$opt=mysql_result($result,$i,"e_name");

												if ($em_name==$opt)
												{
													echo("<option selected >$opt</option>");
												}
												else
												{
													echo("<option>$opt</option>");
												}

											}
											
										?>
										</select></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
										Question ID :
                                            <input type="text" name="TxtQuestionID" size="11" class ="TextBoxStyle" disabled value="<?php echo($qm_id);?>" ></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
                                            Question :</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
										    <textarea rows="3" name="TxtQuestion" cols="67" class ="TextBoxArea" ><?php echo($qm_text); ?></textarea></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="165">
                                            <input type="checkbox" name="ChkActive" value="ON" <?php echo($qm_active);?> > Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
										<td align="left" valign="bottom" style="padding-left: 10px" width="312">
										Option Type :
										<select size="1" name="DdlAnswerType" onchange="DisplayControl()">
										<option <?php if ($qm_type=="SINGLE") {echo('selected');} ?> >SINGLE</option>
										<option <?php if ($qm_type=="MULTIPLE") {echo('selected');} ?> >MULTIPLE</option>
										
										</select> </td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
										Options</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" colspan="2">
										<table border="0" width="100%" id="table12">
											<tr>
												<td width="4" align="left" valign="top">
                                            A.</td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk1" value="ON" <?php echo($chk_display);  echo($rightoption_1);?> ><input  type="radio" value="V2" name="Rd1" id="Rd1"<?php echo($rightoption_1);?> <?php echo($rd_display); ?> ></td>
												<td align="left" valign="top">
                                            <textarea rows="3" name="TxtOption1" cols="63" class ="TextBoxArea" <?php echo($text_display); ?> ><?php echo($op_text1); ?></textarea>&nbsp; &nbsp; <div id="div1"><?php echo($link1); ?></div></td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            B.</td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk2" value="ON" <?php echo($chk_display); echo($rightoption_2);?> ><input type="radio" value="V3" name="Rd1" id="Rd1" <?php echo($rightoption_2);?> <?php echo($rightoption_2);?> <?php echo($rd_display); ?> ></td>
												<td align="left" valign="top">
                                            <textarea rows="3" name="TxtOption2" cols="63" class ="TextBoxArea" <?php echo($text_display); ?>><?php echo($op_text2);?></textarea>&nbsp; &nbsp; <div id="div2"><?php echo($link2); ?></div></td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            C.</td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk3" value="ON" <?php echo($chk_display); echo($rightoption_3);?> ><input type="radio" value="V4" name="Rd1" id="Rd1" <?php echo($rightoption_3);?> <?php echo($rd_display); ?> ></td>
												<td align="left" valign="top">
                                            <textarea rows="3" name="TxtOption3" cols="63" class ="TextBoxArea" <?php echo($text_display); ?>><?php echo($op_text3);?></textarea>&nbsp; &nbsp; <div id="div3"><?php echo($link3); ?></div></td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            D.</td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk4" value="ON" <?php echo($chk_display); echo($rightoption_4);?> ><input type="radio" value="V5" name="Rd1" <?php echo($rightoption_4);?> <?php echo($rd_display); ?> ></td>
												<td align="left" valign="top">
                                            <textarea rows="3" name="TxtOption4" cols="63" class ="TextBoxArea" <?php echo($text_display); ?>><?php echo($op_text4);?></textarea>&nbsp; &nbsp; <div id="div4"><?php echo($link4); ?></div> </td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px" width="467" colspan="2">
                                            &nbsp;</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px" width="467" colspan="2">
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