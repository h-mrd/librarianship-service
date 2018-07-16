<?php
	$studentID = 1;
	//$studentID = $_SESSION['user_id'];
	//$servername = "localhost";
	$servername = "db_service_host:3306";
	$dbname = "cc_project_database";
	$username = "auth_service_user";
	//$password = "";
	$password = "Auth_service@1397";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>

<!doctype html>
<html>
	<head>
        <title>لیست کتاب های امانتی</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="..//source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="..//source/main-style.css" rel="stylesheet" type="text/css"/>
        <script src="..//source/bootstrap/js/bootstrap.min.js"></script>
    </head>

<body>
<div class="col-sm-3"></div>
<div class="col-sm-6 lib">
	<table class="table-responsive table-bordered table-striped table-hover table-condensed" style="direction:rtl;">
		<thead>
			<tr>
				<th>ردیف</th>
				<th>عنوان</th>
				<th>نویسنده</th>
				<th>شماره</th>
				<th>وضعیت</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = "SELECT * FROM books";
			$result = $conn->query($sql);
			//var_dump($result);

			if ($result->num_rows > 0) {
				// output data of each row
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					$i++;
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['Title']; ?></td>
					<td><?php echo $row['Author']; ?></td>
					<td><?php echo $row['Number']; ?></td>
					<td><?php
						if ($row['Status'] == '0')
							echo 'امانت';
						else if ($row['Status'] == '1')
							echo 'پس داده شده';
						?>
					</td>
				</tr>
			<?php }
			} else {
				echo "کتابی موجود نیست!!!";
			} ?>
		</tbody>
	</table>
	<div class="link-back">
				<a href="http://172.100.100.120:80/main.html">بازگشت</a></div>
</div>
	<div class="col-sm-3"></div>
</body>
</html>
<?php $conn->close(); ?>
