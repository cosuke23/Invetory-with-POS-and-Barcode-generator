<?php
/*database connection*/
include "asset/connection/mysqli_dbconnection.php";

    if(isset($_GET['id']))
	{
		$user = $_COOKIE['uid'];
		$usertype = $_COOKIE['ut'];
		$id = $_GET['id'];
		//fetch all the messages of $user_id(loggedin user) and $user_two from their conversation
        $select_query = mysqli_query($dbc, "SELECT * FROM conversations_data WHERE id='$id' ORDER BY conv_id");
        //check their are any messages
        if(mysqli_num_rows($select_query) > 0)
		{
            while ($m = mysqli_fetch_assoc($select_query))
			{
                //format the message and display it to the user
                $id = $m['id'];
				$sender = $m['sender'];
                $message = $m['message'];
				$conv_id = $m['conv_id'];
				
				date_default_timezone_set("Asia/Manila");
				$timestamp = date("m/d/Y h:i:s A", $m['timestamp']);
  
				//display the message
				if($user == $sender)
				{
					if($usertype==1)
					{
						$query = "SELECT * FROM admin_info WHERE admin_id='$user'";
						$result = mysqli_query($dbc, $query);
						if(mysqli_num_rows($result)>0)
						{
							$row = mysqli_fetch_assoc($result);
							$fname=$row['fname'];
							$lname=$row['lname'];
							
							print '<li class="by-other">
							<div class="avatar2 pull-right">
							<img src="../files/admin_pics/'.$user.'.jpg" width="50px" height="50px" alt=""/>
							</div>
							
							<div class="chat-content">
							<div class="chat-meta">'.$fname.' '.$lname.'<span class="pull-right">'.$timestamp.'</span></div><span style="white-space:pre-line;width:150px;word-wrap:break-word"><strong>'.$message.'</strong</span><div class="clearfix"></div></div>
							</li>';
						}
					}
					else
					{
						$query = "SELECT * FROM adviser_info WHERE adviser_id='$user'";
						$result = mysqli_query($dbc, $query);
						if(mysqli_num_rows($result)>0)
						{
							$row = mysqli_fetch_assoc($result);
							$fname=$row['fname'];
							$lname=$row['lname'];

							print '<li class="by-other">
							<div class="avatar2 pull-right">
							<img src="../files/admin_pics/'.$user.'.jpg" width="50px" height="50px" alt=""/>
							</div>
							
							<div class="chat-content">
							<div class="chat-meta">'.$fname.' '.$lname.'<span class="pull-right">'.$timestamp.'</span></div><span style="white-space:pre-line;width:150px;word-wrap:break-word"><strong>'.$message.'</strong</span><div class="clearfix"></div></div>
							</li>';
						}
					}
				}
				else
				{
					$query = "SELECT * FROM student_info WHERE stud_no='$sender'";
					$result = mysqli_query($dbc, $query);
					if(mysqli_num_rows($result)>0)
					{
						$row = mysqli_fetch_assoc($result);
						$fname=$row['fname'];
						$lname=$row['lname'];
						print '<li class="by-me">
						<div class="avatar3 pull-left">
						<img src="../files/student_pics/'.$sender.'.jpg" width="50px" height="50px" alt=""/>
						</div>

						<div class="chat-content">
						<div class="chat-meta">'.$timestamp.'<span class="pull-left" >'.$fname.' '.$lname.'</span></div><span style="white-space:pre-line;width:150px;word-wrap:break-word"><strong>'.$message.'</strong></span><div class="clearfix"></div></div>
						</li>';
					}
					else
					{
						if($usertype==1)
						{
							$query = "SELECT * FROM adviser_info WHERE adviser_id='$sender'";
							$result = mysqli_query($dbc, $query);
							if(mysqli_num_rows($result)>0)
							{
								$row = mysqli_fetch_assoc($result);
								$fname=$row['fname'];
								$lname=$row['lname'];
								
								
								print '<li class="by-me">
								<div class="avatar3 pull-left">
								<img src="../files/admin_pics/'.$sender.'.jpg" width="50px" height="50px" alt=""/>
								</div>

								<div class="chat-content">
								<div class="chat-meta">'.$timestamp.'<span class="pull-left" >'.$fname.' '.$lname.'</span></div><span style="white-space:pre-line;width:150px;word-wrap:break-word"><strong>'.$message.'</strong></span><div class="clearfix"></div></div>
								</li>';
							}
						}
						else
						{
							$query = "SELECT * FROM admin_info WHERE admin_id='$sender'";
							$result = mysqli_query($dbc, $query);
							if(mysqli_num_rows($result)>0)
							{
								$row = mysqli_fetch_assoc($result);
								$fname=$row['fname'];
								$lname=$row['lname'];
								
								print '<li class="by-me">
								<div class="avatar3 pull-left">
								<img src="../files/admin_pics/'.$sender.'.jpg" width="50px" height="50px" alt=""/>
								</div>

								<div class="chat-content">
								<div class="chat-meta">'.$timestamp.'<span class="pull-left" >'.$fname.' '.$lname.'</span></div><span style="white-space:pre-line;width:150px;word-wrap:break-word"><strong>'.$message.'</strong></span><div class="clearfix"></div></div>
								</li>';
							}
						}
					}
				}
			}
		}
		else
		{
            print '<div class="text-center" style="padding:100px;">No message(s)</div>';
        }
	}
?>