<?php header("Location:book_reserve.php");

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

$type = $_GET['type'];

if ($type == 'reserve') {
	$student_id = $_POST['clientID'];
	$status = '1';
	$resStr = "";
	$bookIdStr="";

	if (isset($_POST['btnres'])) {
		if (!empty($_POST['cid'])) {
			$resDate = time();
			foreach($_POST['cid'] as $book_id) {
				if($resStr == "") {
					$resStr = "('$book_id','$student_id','$status', '$resDate')";
				} else {
					$resStr .= ",('$book_id','$student_id','$status', '$resDate')";
				}
				if($bookIdStr == "") {
					$bookIdStr = $book_id;
				} else {
					$bookIdStr .= ','.$book_id;
				}
			}
			$sql = "INSERT INTO book_student (b_id, s_id, bs_status, bs_reserve_date) VALUES $resStr";
			//$conn->exec($sql);
			if ($conn->query($sql) === TRUE) {
				$q = "UPDATE books
					 SET Status = '0'
					 WHERE ID IN ($bookIdStr)";
				$conn->query($q);
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}

if ($type == 'cancel') {
	$student_id = $_POST['clientID'];
	$cancStr = "";
	if (isset($_POST['btncancel'])) {
		if (!empty($_POST['ckid'])) {
			foreach($_POST['ckid'] as $bs_id) {
				if($cancStr == "") {
					$cancStr = $bs_id;
				} else {
					$cancStr .= ",".$bs_id;
				}
			}
			$sql = "UPDATE book_student
					SET bs_status = '0'
					WHERE bs_id IN ($cancStr)";
			//$conn->exec($sql);
			if ($conn->query($sql) === TRUE) {
				$bIdStr = "";
				$q1 = "SELECT b_id from book_student WHERE bs_id IN ($cancStr)";
				$result1 = $conn->query($q1);
				
				while($row1= $result1->fetch_assoc())
				{
 					if($bIdStr == "") {
						$bIdStr = $row1['b_id'];
					} else {
						$bIdStr .= ",".$row1['b_id'];
					}
				}
				$q2 = "UPDATE books
					  SET Status = '1'
					  WHERE ID IN ($bIdStr)";
				$conn->query($q2);
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}

redirect(base_url().'book_reserve.php');

?>
