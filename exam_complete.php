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

	$uid=$_SESSION['userid'];
	$username=$_SESSION['username'];
	$usertype=$_SESSION['usertype'];
        $id=$_GET["id"];
        $sql="SELECT * FROM exam_master e 
        where e.e_id=".$id."";
        $result=mysql_query($sql) or die(mysql_error());
        $examname=mysql_result($result,0,"e_name");
        $noquestion=mysql_result($result,0,"e_no_of_question");
        $totalmarks=mysql_result($result,0,"e_max_marks");
        $passmarks=mysql_result($result,0,"e_pass_marks");
        
        //get right answer
        $sql="SELECT * FROM user_question_master  
        where um_u_id=".$uid." and um_q_exam_id =".$id." order by um_q_id ";
        $result=mysql_query($sql) or die(mysql_error());
        $count=mysql_num_rows($result);
        $i=0;
        $t=0;
        for($i=0;$i<$count; $i++)
        {
            $t1=0;
            $sql1="select * from user_answer_master where um_u_id =".$uid." and um_a_question_id =" .mysql_result($result,$i,"um_q_id"). " ";  ; 
            $result2=mysql_query($sql1) or die(mysql_error());
            $count1=mysql_num_rows($result2);
            $k=0;
            for($k=0;$k<$count1; $k++)
            {
                if (mysql_result($result2,$k,"um_a_rightanswer")<>mysql_result($result2,$k,"um_selected"))
                {
                	echo("B");

                    $t1=1;
                }
                else
                {
                echo("A");
                    //$t1=1;
                }

            }
            if ($t1==0)
            {   
            	echo("C");
         
            	$t++;
            }
        }
        echo($t);

        $p=$t/$noquestion*100;
        if ($p>=$passmarks)
        {
            $result="Pass";
        }
        else
        {
            $result="Fail";
        }
        
        //insert result into db
        $sql="insert into result_master (res_e_id,res_mem_id,res_result,res_date) values(".$id.",".$uid.",'".$result."',sysdate())";

        $result1=mysql_query($sql) or die(mysql_error());
  
?>




<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>eExamination :: Examination Complete</title>
<link href="style/Style1.css" rel="stylesheet" type="text/css" />

<script language ="javascript" type ="text/javascript" >



	function GoBack()
	{
	
		location.href("my_account.php");
	
	}
	

	
	

</script>



</head>

<body>
<form name="form1" method="post" action="start_survey.php" >
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

			
			
<table border="0" width="329" id="table9">
					<tr>
						<td width="323">
						<table border="0" width="100%" id="table10" style="border: 1px solid #00CC99">
							<tr>
								<td >

									
								<table border="0" width="100%" id="table11" cellpadding="2">
									<tr>
										<td align="left" class="td_tablecap1">
										Examination Result<b>
										</b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										&nbsp;</td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										<p align="center"><b>Thanks for giving the 
										examination.</b></td>
									</tr>
									<tr>
										<td align="left" valign="bottom" style="padding-left: 10px">
										<p align="center">Exam Name : <b><?php echo $examname; ?></b><br>
										No of question : <b><?php echo $noquestion; ?><br>
										</b>No of right answer : <b><?php echo $t;?></b><br>
										Result : <b><?php echo $result;?> <br>
&nbsp;</b></td>
									</tr>
									<tr>
										<td align="left" valign="top" style="padding-left: 10px" >
                                            <p align="center">Click here to go
											<a href="my_account.php"><u>back</u></a> 
											to Main Page</td>
									</tr>
									<tr>
										<td align="left" style="padding-left: 10px">
                                            &nbsp; 
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