<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid h1">
			todo
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">PHP - Simple To Do List App</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-12">
			<center>
				<form method="POST" class="form-inline" action="add_query.php">
					
					<label for="task">Task:</label>
					<input type="text" class="form-control" name="task" id="task"/>
				
					<label for="due_date">Due Date:</label>
					<input type="datetime-local" name="due_date" id="due_date" class="form-control" />
				
					<button class="btn btn-primary form-control" name="add">Add Task</button>
				</form>
			</center>
		</div>
		<br /><br /><br />
		<table class="table">
			<thead>
				<tr>
					<th>Due Date</th>
					<th>Task</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					require 'conn.php';
					$query = $conn->query("SELECT * FROM `task` ORDER BY `task_id` ASC");
					$count = 1;
					$currentDate = date("Y-m-d H:i:s");

					while($fetch = $query->fetch_array()){
						$datetime = date("Y-m-d H:i:s",strtotime($fetch["due_date"]));
						if($datetime < $currentDate && $fetch['status'] != "Done"){
							$task_id = $fetch['task_id'];
							$conn->query("UPDATE `task` SET `status` = 'Expired' WHERE `task_id` = $task_id");
							
							ini_set('SMTP', "server.com");
							ini_set('smtp_port', "25");
							ini_set('sendmail_from', "rodash0902@gmail.com");

							$msg = "First line of text\nSecond line of text";
							$msg = wordwrap($msg,70);
							mail("rodash0902@gmail.com","My subject",$msg);
						}
					}
					$query = $conn->query("SELECT * FROM `task` ORDER BY `task_id` ASC");

					while($fetch = $query->fetch_array()){
						$datetime = date("Y-m-d H:i:s",strtotime($fetch["due_date"]));
				?>
				<tr>
					<td><?php echo $fetch['due_date']?></td>
					<td style="width:200px;height:auto;  word-break: break-all; "><?php echo $fetch['task']?></td>
					<td><?php echo $fetch['status']?></td>
					<td colspan="2">
						<center>
							<?php
								if($fetch['status'] != "Done"){
									echo 
									'<a href="update_task.php?task_id='.$fetch['task_id'].'" class="btn btn-success"><span class="glyphicon glyphicon-check"></span></a> | ';
								}
								echo '<a href="delete_query.php?task_id= '.$fetch['task_id'].'" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>';
							?>

						</center>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>