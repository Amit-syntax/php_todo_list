<?php
	require_once 'conn.php';
	if(isset($_POST['add'])){
		if($_POST['task'] != "" && $_POST['due_date']){
			$task = $_POST['task'];
			$datetime = $_POST['due_date'];
			$datetime = date("Y-m-d H:i:s",strtotime($datetime));

			$conn->query("
			INSERT INTO `task` ( status,task,due_date) 
			VALUES('', 
				'$task', 
				'$datetime')
			");
			header('location:Main.php');
		}
	}
?>