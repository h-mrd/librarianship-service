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
        <title>جستجوی کتاب</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="..//source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="..//source/main-style.css" rel="stylesheet" type="text/css"/>
        <script src="..//source/bootstrap/js/bootstrap.min.js"></script>
    </head>

<body>
<div class="col-sm-3"></div>
<div class="col-sm-6 lib">
	<form action="book_search.php" method="post" class="form-horizontal">
		<div class="" style="width: 100%; display: table;">
			<div class="col-md-6 col-md-offset-3" dir="rtl">
				<fieldset>
					<legend>جستجوی کتاب:</legend>
					عنوان:<br>
					<input type="text" name="title" autofocus>
					<br>
					نویسنده:<br>
					<input type="text" name="author">
					<br>
					موضوع:<br>
					<input type="text" name="subject">
					<br><br>
					<input type="submit" name="btnSearch" value="جستجو">
					
				</fieldset>
				<div class="link-back">
				<a href="http://172.100.100.120:80/main.html">بازگشت</a></div>
			</div>
		</div>
		<?php
		if(isset($_POST['btnSearch'])) {
			$title = trim($_POST['title']);
			$author = trim($_POST['author']);
			$subject = trim($_POST['subject']);
			
			$where_search = "";
			
			if($title){
					$where_search = "Title LIKE '%$title%'";
			}
			if($author){
				if($where_search == "")
					$where_search = "Author LIKE '%$author%'";
				else
					$where_search = " OR Author LIKE '%$author%'";
			}
			if($subject)
			{
				if($where_search == "")
				{
					$where_search = "Author LIKE '%$subject%' OR Title LIKE '%$subject%'";
				}
				else{
					$where_search = " OR Author LIKE '%$subject%' OR Title LIKE '%$subject%'";
				}
			}
			
			$search_q = "SELECT * From books";
			if($where_search){
				$search_q = "SELECT * From books 
							where $where_search";
			}
			$result_q = $conn->query($search_q);
			if ($result_q->num_rows > 0) {
			?>
				<div class="clearfix">
				<p class="result-search">نتایج جست و جو: </p>
					<table class="table-responsive table-bordered table-striped table-hover table-condensed" style="direction:rtl; margin-left:15%;">
						<thead>
							<tr>
								<th>ردیف</th>
								<th>عنوان</th>
								<th>نویسنده</th>
								<th>شماره</th>
								<th>وضعیت کتاب</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i = 0;
						while($row_q= $result_q->fetch_assoc()) {
							$i++;
							echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row_q['Title'].'</td>
									<td>'.$row_q['Author'].'</td>
									<td>'.$row_q['Number'].'</td>';
									if ($row_q['Status'] == '1')
										echo '<td>آزاد</td>';
									else if ($row_q['Status'] == '0')
										echo '<td>امانت داده شده</td>';
								echo '</tr>';
						}
						?>
						</tbody>
					</table>
				</div>
			<?php } else { ?>
				<div class="clearfix">
					<table class="table-responsive table-bordered table-striped table-hover table-condensed" style="direction:rtl;">
						<thead>
							<tr>
								<th>ردیف</th>
								<th>عنوان</th>
								<th>نویسنده</th>
								<th>شماره</th>
								<th>وضعیت کتاب</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="5" style="text-align: center;">نتیجه ای یافت نشد!!!</td>
							</tr>
						</tbody>
					</table>
				</div>
			<?php } 
	} ?>
	</form>
</div>
	<div class="col-sm-3"></div>

	</body>
</html>
