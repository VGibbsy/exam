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
	$userid=$_SESSION['userid'];
	$username=$_SESSION['username'];
	$usertype=$_SESSION['usertype'];

}
?>

<?php


	if($_POST['BtnSubmit']=='Start Exam')
	{
            //echo $_POST['DdlExam'];
            if ($_POST['DdlExam']=='Select Examination')
            {
                $msg = urlencode("Select examination name from list. ");
                header("Location:start_exam.php?msg=$msg");
                
            }
	 	$result1=mysql_query("select e_id from exam_master where e_name='".$_POST['DdlExam']."'");	
	 	$em_id=mysql_result($result1,0,"e_id");
		
		$sql="SELECT  q.*,e.* FROM question_master q, exam_master e 
		where q.q_exam_id=e.e_id and e.e_id=".$em_id."";
                //echo($sql);
                $result=mysql_query($sql) or die(mysql_error());
		//row count
		$row_count=mysql_num_rows($result);
		if ($row_count>0)
		{

			session_start();
                        //random and insert into user question / answer table
                        $sql="delete from  user_answer_master where um_u_id =".$userid;//echo($sql);
			$result1=mysql_query($sql) or die(mysql_error());	

                        $sql="delete from  user_question_master where um_u_id =".$userid;//echo($sql);
			$result1=mysql_query($sql) or die(mysql_error());	

                        $sql="insert into user_question_master ".
                        "select ".$userid." ,q.*,0 from question_master q where q.q_exam_id=".$em_id." order by rand()  limit ".mysql_result($result,0,"e_no_of_question");
                        
                        $result1=mysql_query($sql) or die(mysql_error());
                        
                        //update squence
                        $sql="select * from user_question_master where um_u_id =".$userid  ; 
                            $result=mysql_query($sql) or die(mysql_error());
                            $count=mysql_num_rows($result);
                                    $i=0;
                                    for($i=0;$i<$count; $i++)
                                    {
                                        $j=$i+1;
                                        $sql="update user_question_master set um_seq=".$j." where um_q_id =" .mysql_result($result,$i,"um_q_id"). " and um_u_id =".$userid ;
                                        
                                        $result1=mysql_query($sql) or die(mysql_error());
                                        
                                        //insert answer
                                        $sql="insert into user_answer_master  select ".$userid.",a.*,0,0 from answer_master a where a_question_id =" .mysql_result($result,$i,"um_q_id"). " ";
                                        $result1=mysql_query($sql) or die(mysql_error());
                                        
                                        //update answer seq
                                        $sql1="select * from user_answer_master where um_u_id =".$userid." and um_a_question_id =" .mysql_result($result,$i,"um_q_id"). " order by rand()";  ; 
                                        $result2=mysql_query($sql1) or die(mysql_error());
                                        $count1=mysql_num_rows($result2);
                                        $k=0;
                                        for($k=0;$k<$count1; $k++)
                                        {
                                            $l=$k+1;
                                            $sql1="update user_answer_master set um_seq=".$l." where um_a_id=".mysql_result($result2,$k,"um_a_id")." and um_a_question_id =" .mysql_result($result,$i,"um_q_id"). " and um_u_id =".$userid ;
                                            echo($sql1. " ");
                                            $result1=mysql_query($sql1) or die(mysql_error());
             
                                            
                                        }
                        //'and um_a_question_id =1 and um_u_id =1' 
                                        
                                    }
                        
                        
			$_SESSION['currind']=0;
			header("location:exam_main.php?id=$em_id&next_id=0"); 
		}
		else
		{
			$msg = urlencode("Sorry no question avaialble for examination - ". $_POST['DdlExam']);
			header("Location:start_exam.php?msg=$msg");
		}
		
		
	}

?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Start Examination</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

<script language ="javascript" type ="text/javascript" >



	function GoBack()
	{
		
		setTimeout(function(){document.location.href = "my_account.php"},100);
	
	}
	

	
	

</script>



</head>

<body>
<form name="form1" method="post" action="start_exam.php" >
<div align="center">
	<table border="0" width="100%" cellspacing="1" height="100%" id="table1">
		<tr>
			<td  align="center" class ="td_top">
			<?php 
			include 'header.php';
			?>
			
			</td>
		</tr>
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
										<td align="left" class="td_tablecap1"><b>
										Start Examination </b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										&nbsp;</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										Select Examination</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										<select size="1" name="DdlExam" width="100%" >
										<?php
										session_start();
                                                                                echo("<option>Select Examination</option>");
									    $sql="select e_name from  exam_master order by e_name " ; 
  										$result=mysql_query($sql) or die(mysql_error());
  										$count=mysql_num_rows($result);
											$i=0;
											for($i=0;$i<$count; $i++)
											{
												$opt=mysql_result($result,$i,"e_name");

												echo("<option>$opt</option>");
												

											}
											
										?>
										</select></td>
									</tr>
									<tr>
										<td align="left" valign="top" style="padding-left: 10px" >
                                            &nbsp;</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            <input type="submit" value="Start Exam" name="BtnSubmit" class="ButtonStyle">&nbsp; 
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