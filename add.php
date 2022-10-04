
<?php
require_once "config/database.php";

$_SESSION['location'] = 'admin';
$category = "ADD";

if(!isset($_SESSION["loggedin"]) && $_SESSION['username'] == "admin"){
    header("location: index.php");
    exit;
}

include('header.php');
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

        
<?php
include("footer.php");
?>