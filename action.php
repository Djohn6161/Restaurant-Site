
<?php
require_once "config/database.php";
// For inserting data
if(isset($_POST["insertData"])){
    $image = "";
    if(empty($_POST["name"])){
        $name_err = "Name is required.";
        $name = $_POST["name"];
    } else {
        $name = $_POST["name"];
        $name_err = "";
    }
    if(empty($_POST["cost"])){
        $cost_err = "Cost is required.";
        $cost = $_POST["cost"];
    } else {
        $cost = $_POST["cost"];
        $cost_err = "";
    }
    $categoryID = $_POST["category"];
    if(empty($name_err)){
        if(!empty($_FILES['fileToUpload']["name"])){
            $v1=rand(1111,9999);
            $v2=rand(1111,9999);
            $v3=$v1.$v2;
            $v3=md5($v3);
            $fnm = $_FILES["fileToUpload"]["name"];
            print_r($fnm);
            $image = "./Assets/Uploadedimg/".$v3.$fnm;
        }
        $insertDish = "INSERT INTO dishes(name, cost, category_id, image) VALUES ('$name', '$cost', '$categoryID', '$image')";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$image);
        if ($link->query($insertDish) === TRUE) {
            $_SESSION['status'] = "New Dish created successfully";
            header('Location: manage.php');
           
          } else {
            $_SESSION['statusF'] = "New Dish not created";
            header('Location: manage.php');
          }
    } else{
        $_SESSION['statusF'] = "Dish needs Name";
        header('Location: manage.php');
    }
}

//For Eiditing data
if(isset($_POST["updateData"])){
    $id = $_POST["update_id"];
    $image = $_POST["image"];
    if(empty($_POST["name"])){
        $name_err = "Name is required.";
        $name = $_POST["name"];
    } else {
        $name = $_POST["name"];
        $name_err = "";
    }
    if(empty($_POST["cost"])){
        $cost_err = "Cost is required.";
        $cost = $_POST["cost"];
    } else {
        $cost = $_POST["cost"];
        $cost_err = "";
    }
    $categoryID = $_POST["category"];
    if(empty($name_err) && empty($cost_err)){
        if(!empty($_FILES['fileToUpload']["name"])){
            $v1=rand(1111,9999);
            $v2=rand(1111,9999);
            $v3=$v1.$v2;
            $v3=md5($v3);
            $fnm = $_FILES["fileToUpload"]["name"];
            print_r($fnm);
            $image = "./Assets/Uploadedimg/".$v3.$fnm;
        }
        $updateDish = "UPDATE dishes SET name='$name', cost='$cost', category_id='$categoryID', image='$image' WHERE id='$id'";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$image);
        if ($link->query($updateDish) === TRUE) {
            $_SESSION['status'] = "Dish updated successfully";
            header('Location: manage.php');
           
          } else {
            $_SESSION['statusF'] = "Dist not updated";
            header('Location: edit.php');
          }
    }
    else{
        $_SESSION['statusF'] = "Dish needs Name";
        header('Location: edit.php');
    }
}
if(isset($_POST["deleteData"])){
    $id = $_POST["delete_id"];

    $query = "DELETE FROM dishes WHERE id='$id'";
        $query_run = mysqli_query($link, $query);
        if($query_run){
            $_SESSION['status'] = "Deleted successfully";
            header('Location: manage.php');
        }else {
            $_SESSION['statusF'] = "Deletion Failed";
            echo '<script> alert("Data Not Deleted '. $query .'"); </script>';
        }
}
if(isset($_POST["orderDish"])){
    $dishID = $_POST["dish_id"];
    $userID = $_SESSION["user_id"];
    $directory = $_SESSION['location'];
    $insertDish = "INSERT INTO orders(user_id, dishes_id) VALUES ('$userID', '$dishID')";
    $query_run = mysqli_query($link, $insertDish);
    if($query_run){
    $_SESSION['status'] = "Ordered successfully";
        header('Location: ' . $directory);
    }else {
        $_SESSION['statusF'] = "Order Failed";
        echo '<script> alert("Order failed '. $insertDish .'"); </script>';
    }
}
if(isset($_POST["finishOrder"])){
    $orderID = $_POST["order_id"];
    $directory = $_SESSION['location'];
    $date = date("Y-m-d h:i:s");
    $updateOrder = "UPDATE orders SET date_finished='$date', status='finished' WHERE id='$orderID'";
    $query_run = mysqli_query($link, $updateOrder);
    if($query_run){
    $_SESSION['status'] = "order successful";
        header('Location: '. $directory);
    }else {
        $_SESSION['statusF'] = "order Failed";
        echo '<script> alert("Order failed '. $updateOrder .'"); </script>';
    }
}
if(isset($_POST["cancelOrder"])){
    $orderID = $_POST["order_id"];
    $directory = $_SESSION['location'];
    $date = date("Y-m-d h:i:s");
    $updateOrder = "UPDATE orders SET date_finished='$date', status='canceled' WHERE id='$orderID'";
    $query_run = mysqli_query($link, $updateOrder);
    if($query_run){
    $_SESSION['status'] = "Successful";
        header('Location: '. $directory);
    }else {
        $_SESSION['statusF'] = "order Failed";
        echo '<script> alert("Order failed '. $updateOrder .'"); </script>';
    }
}
?>