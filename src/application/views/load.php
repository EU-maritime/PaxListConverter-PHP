<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Welcome to Maritime Passenger List Loader</title>
	</head>
	<body>
		<hr>
		<h1>
			Welcome to Maritime Passenger Loader
		</h1>
		<hr>
		<form enctype="multipart/form-data" 
		      action="" 
		      method="post"
		>  
			<input type="hidden"  name="MAX_FILE_SIZE" value="5000000"/><br/>
			 <input type="file" name="filedata"/><br/><br/>
			<input type="submit" value="Upload File"/>
		 </form>
		<hr>
		<?php
		if ($name != ''){
			echo '<table>';
			echo '<tr><td>error</td><td>'.$error.'</td>'.'</tr>';
			echo '<tr><td>name</td><td>'.$name.'</td>'.'</tr>';
			echo '<tr><td>type</td><td>'.$type.'</td>'.'</tr>';
			echo '<tr><td>size</td><td>'.$size.'</td>'.'</tr>';
			echo '<tr><td>allowed</td><td>'.$allowed.'</td>'.'</tr>';
			echo '</table>';
		}
			echo $list;
		?>
	</body>
</html>
