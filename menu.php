<?php
if ($usertype=='administrator')
{
    echo('<a href=my_account.php>My Account</a>
    | <a href="exam.php">Examination</a>
    | <a href="question.php">Question</a> 
    | <a href="results.php">Results</a>  
    | <a href="activate_user.php">Users</a> 
    | <a href="feedback_admin.php">Feedback</a> 
    | <a href="logout.php">Logout</a>');

}

if ($usertype=='member')
{
        echo('<a href=my_account.php>My Account</a>
            | <a href="myresult.php">My Result</a> 
    | <a href="start_exam.php">Start Exam</a> 
    | <a href="edit_profile.php">Edit Profile</a> 
    | <a href="feedback.php">Feedback</a> 
    | <a href="logout.php">Logout</a>');

}
?>