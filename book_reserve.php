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
        <title>رزرو کتاب</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="..//source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="..//source/main-style.css" rel="stylesheet" type="text/css"/>
        <script src="..//source/bootstrap/js/bootstrap.min.js"></script>
    </head>

<body>
<div class="col-sm-3"></div>
<div class="col-sm-6 lib">
	<form action="book.php?type=reserve" method="post" class="form-horizontal">
		<table class="table-responsive table-bordered table-striped table-hover table-condensed" style="direction:rtl;">
			<thead>
				<tr>
					<th>ردیف</th>
					<th>عنوان</th>
					<th>نویسنده</th>
					<th>شماره</th>
					<th>رزرو کتاب</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT * FROM books WHERE Status = 1";
				$result = $conn->query($sql);

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
						<td>
							<input type="checkbox" class="checked" name="cid[]" value="<?php echo $row['ID']; ?>"/>
						</td>
					</tr>
				<?php }
				} else {
					echo "کتابی ارائه نشده است!!!";
				} ?>
			</tbody>
		</table>
		<div class="form-button">
			<button type="submit" name="btnres" class="btn btn-success reserve">رزرو</button>
			<button type="reset" class="btn btn-success reset">پاک کردن</button>
		</div>
		<input type="hidden" name="clientID" value="<?php echo $studentID; ?>"/>
	</form>
	<div class="clearfix"></div>
	<div class="clearfix"></div>
	<div class="clearfix"></div>
	<form action="book.php?type=cancel" method="post" class="form-horizontal">
		<?php
		$student_book = "SELECT book_student.bs_id, book_student.bs_status, book_student.bs_reserve_date,
		books.Title, books.Author, books.Number, books.Status From book_student INNER JOIN books on books.ID = book_student.b_id
		WHERE book_student.s_id = '".$studentID."'";
		$result = $conn->query($student_book);
		if ($result->num_rows > 0) {
		?>
		<table class="table-responsive table-bordered table-striped table-hover table-condensed" style="direction:rtl;">
			<thead>
				<tr>
					<th>ردیف</th>
					<th>عنوان</th>
					<th>نویسنده</th>
					<th>شماره</th>
					<th>تاریخ رزرو</th>
					<th>وضعیت</th>
					<th>لغو رزرو</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i = 0;
					while ($row = $result->fetch_assoc()) {
						$i++;
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['Title']; ?></td>
						<td><?php echo $row['Author']; ?></td>
						<td><?php echo $row['Number']; ?></td>
						<td>
<?php
date_default_timezone_set('Europe/London');
 echo date('Y/m/d', time($row['bs_reserve_date'])); ?>
</td>
						<td>
							<?php
							if ($row['bs_status'] == '1')
								echo 'رزرو شده';
							else if ($row['bs_status'] == '0')
								echo 'لغو شده';
							?>
						</td>
						<td>
							<?php
							if ($row['bs_status'] == '1')
							?>
							<input type="checkbox" class="checked" name="ckid[]" value="<?php echo $row['bs_id'];?>"/>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="form-button">
			<button type="submit" name="btncancel" class="btn btn-success cancel">لغو رزرو</button>
			<button type="reset" class="btn btn-success reset">پاک کردن</button>
		</div>
		<input type="hidden" name="clientID" value="<?php echo $studentID; ?>"/>
	</form>
	<?php } ?>
	<div class="link-back">
				<a href="http://172.100.100.120:80/main.html">بازگشت</a></div>
</div>
	<div class="col-sm-3"></div>


</body>
</html>
<?php $conn->close(); ?>
