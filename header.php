
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <TITLE>Street Vittles</TITLE>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" type="text/css" href="login.css"> 
        <link rel="stylesheet" href="Assets/bootstrap4/css/bootstrap.min.css">
    </head>
    <body>
        <?php
            if(isset($_SESSION["loggedin"])){
            
        ?>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="main_course.php">Street Vittles</a>
            <span class="navbar-organizer w-100"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName']; ?></span>
            
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" id="logout" href="logout.php">Log out</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <?php
                                $getCategories = "SELECT * FROM category";
                                $result = $link->query($getCategories);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                        ?>
                        <ul class="nav flex-column">
                            <li class="nav-item "><a class="nav-link <?php if($category == $row['name']) echo 'active'; ?>" href="<?php echo $row['location'];?>"><?php echo $row['name'];?></a></li>
                        </ul>
                        <?php
                                    }
                                }
                            if($_SESSION['username'] == "admin"){
                                ?>
                                <ul class="nav flex-column">
                                    <li class="nav-item "><a class="nav-link <?php if($category == "ADD" ) echo "active"; ?>" href="add.php"><?php echo "ADD";?></a></li>
                                </ul>
                                <ul class="nav flex-column">
                                    <li class="nav-item "><a class="nav-link <?php ?>" href="update.php"><?php echo "UPDATE";?></a></li>
                                </ul>
                                <ul class="nav flex-column">
                                    <li class="nav-item "><a class="nav-link <?php ?>" href="delete.php"><?php echo "DELETE";?></a></li>
                                </ul>
                                <?php
                            }
                        ?>

                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 text-light">
                    <div class="border-bottom mb-3 pt-3 pb-2">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                            <h1 class="h2"><?php  echo $category; ?></h1>
                        </div>
                        <span class="h6"></span>
                    </div>

                    <div class="mb-3 pt-3 pb-2">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        </div>
                    </div>
        <?php } ?>
