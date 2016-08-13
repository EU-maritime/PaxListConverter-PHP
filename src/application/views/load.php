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
			echo '<hr>';
		}
		if ($list) {
			echo '<h2>HTML:</h2>';
			echo $list;
			echo '<hr>';
		}
		if ($xml) {
			echo '<h2>XML:</h2>';
			$xmlhtml = htmlentities($xml);
			$pax0 = htmlentities('<Passengers>');
			$pax1 = htmlentities('<pax>');
			$pax2 = htmlentities('</pax>');
			$xml2 = str_replace([$pax0, $pax1, $pax2], ['<br/>'.$pax0, '<br/>'.$pax1, $pax2.'<br/>'], $xmlhtml);
			echo $xml2;
			echo '<hr>';
		}
		if ($json) {
			echo '<h2>JSON:</h2>';
			echo $json;
			echo '<hr>';
		}
		?>
	</body>
</html>
