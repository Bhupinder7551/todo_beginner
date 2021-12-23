
<?php 

session_start();
    // initialize errors variable
	$errors = "";
    $task = "";
	$name="";
    $id=0;
   // $update = false;

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// insert a quote if submit button is clicked

    if (isset($_POST['submit'])) {
        if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
        $task = $_POST['task'];
        $name = $_POST['name'];
        
			$sql = "INSERT INTO tasks (task,name) VALUES ('$task','$name')";
			mysqli_query($db, $sql);
			header('location: index.php');
    }
}else{
    
    echo "working submit not fine____________";
}
	// ...
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
    
        mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
        header('location: index.php');
    }
    


      
        	
if (isset($_POST['update'])) {
    echo "working fine";
	$id = $_POST['id'];
	$task = $_POST['task__'];
	$name = $_POST['name__'];


	
	
		mysqli_query($db, "UPDATE tasks SET task='$task',name='$name' WHERE id=$id");
	


        header('location: index.php');
	}
  
    
        if (isset($_GET['edit_task'])) {
            $id = $_GET['edit_task'];	
            //$update = true;
            $record = mysqli_query($db, "SELECT * FROM tasks WHERE id=".$id);
        
            if ($record) {
                $row = mysqli_fetch_array($record);
                $task__ = $row['task'];
                $name__=  $row['name'];
            } else {
                // UPDATE failed
                echo mysqli_error($db);
                db_disconnect($db);
                exit;
              }
        }
        



    ?>


<!DOCTYPE html>
<html>
<head>
	<title>ToDo List Application PHP and MySQL</title>
    <style>
        form p {
	color: red;
	margin: 0px;
}
        </style>
</head>
<body>
	<div >
		<h2>ToDo List Application PHP and MySQL database</h2>
	</div>
  
	<form method="post" action="index.php">
    <?php if (isset($errors)) { ?>
	<p><?php  echo $errors; ?></p>
<?php } ?>

<input type="text" name="task__"  value="<?php echo $task__; ?>">        
		<input type="text" name="name__" value="<?php echo $name__; ?> " >
	
<button type="submit" name="update" >Update</button>

<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="text" name="task"  >        
		<input type="text" name="name" >
	  

	


<button type="submit" name="submit" >Add Task</button>

	</form>
    
<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th>Name</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT * FROM tasks");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row['task']; ?> </td>
				<td> <?php echo $row['name']; ?> </td>
				<td > 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
					<a href="index.php?edit_task=<?php echo $row['id'] ?>">Edit</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>
</body>
</html>