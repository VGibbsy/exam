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
$row_count=0;

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
	session_start();
	$currind=0;
	$currind=$_SESSION['currind'];
	$next_id=$currind;//$_GET["next_id"]; 
	$id=$_GET["id"]; 
	
	if($_POST['BtnNext']=='  Next >  ')
	{
		$row_count=0;
		$next_id=0;
		$currind=0;
		$currind=$_SESSION['currind'];
		$next_id=$currind;
		

	
	
		$next_id=$next_id+1;
		$_SESSION['currind']=$next_id;
		
		
		$sql="SELECT  q.*,e.* FROM user_question_master q, exam_master e 
		where q.um_q_exam_id=e.e_id and e.e_id=".$id." and um_u_id=".$uid;
                //echo($id);
                 $result=mysql_query($sql) or die(mysql_error());
		//row count
		$row_count=mysql_num_rows($result);
		//echo($row_count-1);
		
		
		//-----------------
                //update answers
                for($i=1;$i<=4;$i++)
                {					
                        $checkbox="Chk".$i;
                        $radiobutton="Rd".$i;
                        //check the question type and save					
                        //if ( $_POST[$radiobutton]='ON' || $_POST[$checkbox]!='' )
                        if ( $_POST['Rd1']==$i || $_POST[$checkbox]=='1' )
                        {
                                $chk_dis=1;
                        }
                        else
                        {
                                $chk_dis=0;
                        }
                
                    $sql=" update user_answer_master set um_selected = ".$chk_dis." where um_seq=". $i." and um_u_id=".$uid." and um_a_question_id= ".$_SESSION['currentqstid'];
                        
                
                    $result1=mysql_query($sql) or die(mysql_error());	
                    //s.`usd_id`, s.`usd_us_id`, s.`usd_o_id`, s.`usd_o_select`, s.`usd_text` 
                    $last_detail_id=$last_detail_id+1;					
                }				
                
         	//echo (" >>> ". $next_id." ...".$row_count);
		if($next_id> $row_count-1)
		{
                        //echo (" >>> ". $next_id);
			header("location:exam_complete.php?id=".$id); 
			 
		}
		


		
		
	}
	
	if($_POST['BtnPrevious']=='< Previous')
	{
		
		$currind=0;
		$currind=$_SESSION['currind'];
		$next_id=$currind;
		if ($next_id>0)
		{
		
			$next_id=$next_id-1;
			$_SESSION['currind']=$next_id;
                        
                        
                                        //update answers
                    for($i=1;$i<=4;$i++)
                    {					
                            $checkbox="Chk".$i;
                            $radiobutton="Rd".$i;
                            //check the question type and save					
                            //if ( $_POST[$radiobutton]='ON' || $_POST[$checkbox]!='' )
                            if ( $_POST['Rd1']==$i || $_POST[$checkbox]=='1' )
                            {
                                    $chk_dis=1;
                            }
                            else
                            {
                                    $chk_dis=0;
                            }

                        $sql=" update user_answer_master set um_selected = ".$chk_dis." where um_seq=". $i." and um_u_id=".$uid." and um_a_question_id= ".$_SESSION['currentqstid'];

//echo($sql);
//exit;
                        $result1=mysql_query($sql) or die(mysql_error());	
                        //s.`usd_id`, s.`usd_us_id`, s.`usd_o_id`, s.`usd_o_select`, s.`usd_text` 
                        $last_detail_id=$last_detail_id+1;					
                    }
			
		}

	}
	


?>

<?php 
    $sql="SELECT  q.*,e.* FROM user_question_master q, exam_master e 
		where q.um_q_exam_id=e.e_id and um_u_id =".$uid;
    //echo($sql);
    $result=mysql_query($sql) or die(mysql_error());
    //row count
    $row_count_disp=mysql_num_rows($result);


    $id=$_GET["id"];
    
    session_start();
    $currind=0;
    $currind=$_SESSION['currind'];
    $next_id=$currind;
		 
		
    $sql="SELECT  q.*,e.* FROM user_question_master q, exam_master e 
		where q.um_q_exam_id=e.e_id and um_u_id =".$uid;
    //echo($sql);
    $result=mysql_query($sql) or die(mysql_error());
    //row count
    $row_count=mysql_num_rows($result);
    
    //$qm_id=mysql_num_rows($result);
    $qm_id=mysql_result($result,$next_id,"um_q_id");
    $_SESSION['currentqstid']=$qm_id;
    $qm_text=mysql_result($result,$next_id,"um_q_text");
    $qm_type=mysql_result($result,$next_id,"um_q_type");
    $e_name=mysql_result($result,$next_id,"e_name");
    //echo($sql);
    
    $sql="SELECT  * FROM user_answer_master  
		where um_a_question_id=".$qm_id." and um_u_id=".$uid." order by um_seq";
    
    //echo($sql);
		$result=mysql_query($sql) or die(mysql_error());
		
		$op_text1=mysql_result($result,0,"um_a_answer");
  	$op_text2=mysql_result($result,1,"um_a_answer");
  	$op_text3=mysql_result($result,2,"um_a_answer");
  	$op_text4=mysql_result($result,3,"um_a_answer");
  	
	
		$is_checked1="";
		$is_checked2="";
		$is_checked3="";
		$is_checked4="";
		
		$sql2=" select * from user_answer_master 
			 where um_u_id=".$uid." and um_a_question_id= ".$qm_id." order by um_seq " ;
		
                echo($sql12);
                $result2=mysql_query($sql2) or die(mysql_error());
		$row_count2=mysql_num_rows($result2);
		//echo($row_count2);
		if ($row_count2>0)
		{
			if (mysql_result($result2,0,"um_selected")==1)
			{
				$is_checked1="checked";
			}
			if (mysql_result($result2,1,"um_selected")==1)
			{
				$is_checked2="checked";
			}
			if (mysql_result($result2,2,"um_selected")==1)
			{
				$is_checked3="checked";
			}
			if (mysql_result($result2,3,"um_selected")==1)
			{
				$is_checked4="checked";
			}
			
		}
		//echo ("type =".$qm_type);
		if ($qm_type=='SINGLE')
		{
	    	$text_display=" ";
	    	$file_display="style='display:none'";
	    	$chk_display="style='display:none'";
	    	$rd_display=" ";
			
				$link1=" ";
		  	$link2=" ";
		  	$link3=" ";
		  	$link4=" ";
		}
		
		
		if ($qm_type=='MULTIPLE')
		{
		$text_display=" ";
	    	$file_display="style='display:none'";
	    	$chk_display=" ";
	    	$rd_display="style='display:none'";
			
                    $link1=" ";
		  	$link2=" ";
		  	$link3=" ";
		  	$link4=" ";
			
		}
		
 


?>



<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Examination Main</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />





</head>

<body>
<form name="form1"  method="post" action="exam_main.php?id=<?php echo($id)?>&next_id=<?php echo($next_id)?>" >
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
						<table border="0" width="100%" id="table10" style="border: 2px dotted #FFF;">
							<tr>
								<td>
								<table border="0" width="483" id="table11" cellpadding="2" style="background: grey;">

									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467" class="td_tablecap1" >
										<b>Examination</b> :  <?php  echo($e_name) ?>
										</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467">
										<b>Question No</b> : <?php echo($next_id+1);?>
                                            </td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467">
                                            <b>Question</b> : <?php echo($qm_text); ?></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467">
										&nbsp;
										</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467">
										<u><b>Options</b></u></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px" width="467">
										<table border="0" width="100%" id="table12">
											<tr>
												<td width="4" align="left" valign="top">
                                            <b>A.</b></td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk1" value="1"  <?php echo($chk_display); echo(" "); echo($is_checked1);?> ><input type="radio" value="1" name="Rd1"  <?php echo($rd_display); echo(" "); echo($is_checked1);?> ></td>
												<td align="left" valign="top"> <?php echo($op_text1); ?> <div id="div1"><?php echo($link1); ?></div></td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            <b>B.</b></td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk2" value="1" <?php echo($chk_display); echo(" "); echo($is_checked2); ?> ><input type="radio" value="2" name="Rd1"  <?php echo($rd_display); echo(" "); echo($is_checked2); ?> ></td>
												<td align="left" valign="top"> <?php echo($op_text2);?><div id="div2"><?php echo($link2); ?></div> </td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            <b>C.</b></td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk3" value="1" <?php echo($chk_display); echo(" "); echo($is_checked3); ?> ><input type="radio" value="3" name="Rd1"  <?php echo($rd_display); echo(" "); echo($is_checked3); ?> ></td>
												<td align="left" valign="top"><?php echo($op_text3);?><div id="div3"><?php echo($link3); ?>
												</td>
											</tr>
											<tr>
												<td width="4" align="left" valign="top">
                                            <b>D.</b></td>
												<td width="4" align="left" valign="top">
                                            <input type="checkbox" name="Chk4" value="1" <?php echo($chk_display); echo(" "); echo($is_checked4); ?> ><input type="radio" value="4" name="Rd1"  <?php echo($rd_display); echo(" "); echo($is_checked4); ?> ></td>
												<td align="left" valign="top"> <?php echo($op_text4);?><div id="div4"><?php echo($link4); ?></div>
												 </td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px" width="467">
                                            &nbsp;</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px" width="467">
                                            <input type="submit" value="< Previous" name="BtnPrevious" class="ButtonStyle">&nbsp; &nbsp; <?php echo(($next_id+1)."/".$row_count_disp) ?> &nbsp; &nbsp; 
                                            <input type="submit" value="  Next >  " name="BtnNext" class="ButtonStyle">&nbsp;&nbsp; 
                                            </td>
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