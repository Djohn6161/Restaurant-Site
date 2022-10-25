<?php
	include('config/database.php');

	$_SESSION['location'] = 'login';

	include('header.php');

	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: main_course.php");
		exit;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user = mysqli_real_escape_string($link, $_POST['username']);
		$pass = mysqli_real_escape_string($link, $_POST['password']);

		$row = array();
		$sql = "SELECT * FROM user WHERE user.username = '$user' AND user.password = '$pass' ";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$_SESSION['firstName'] = $row['firstName'];
				$_SESSION['lastName'] = $row['lastName'];
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $row['username'];
				$_SESSION['user_id'] = $row['id'];
					
				header("Location: main_course.php");
			}
		} else {
			$login_err = "Username or password not correct";
		}
	}
?>

	<div class="login">  
		<h2 class="login-header"> Street Vittles</h2>  
		<?php 
			if(!empty($login_err)){
				echo '<div class="alert alert-danger text-center">' . $login_err . '</div>';
			}        
		?>
	    <form id="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<div class="form-group">
			<label for="user">Username:</label>
			<input type="text" class="form-control inputs" placeholder="Username" name="username" id="username">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control inputs"  placeholder="Password" name="password" id="password" >
		</div>   
		<div class="form-group form-check">
			<label class="form-check-label">
			<input class="form-check-input" type="checkbox"> Remember me
			</label>
		</div>
		<button type="submit" class="btn btn-outline-primary float-right">Submit</button>
	    </form>     
	</div>
	<script src="Resources/bootstrap4/js/bootstrap.bundle.min.js"></script>
</body>
</html>