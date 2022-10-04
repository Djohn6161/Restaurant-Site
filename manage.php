
<?php
require_once "config/database.php";

$_SESSION['location'] = 'admin';
$category = "Manage";
$categoryID = 0;

if(!isset($_SESSION["loggedin"]) && $_SESSION['username'] == "admin"){
    header("location: index.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        
        $v1=rand(1111,9999);
        $v2=rand(1111,9999);
        $v3=$v1.$v2;
        $v3=md5($v3);
        $fnm = $_FILES["fileToUpload"]["name"];
        print_r($fnm);
        $dst="./Assets/Uploadedimg/".$v3.$fnm;
        $dst1="./Assets/Uploadedimg/".$v3.$fnm;
        $insertDish = "INSERT INTO dishes(name, cost, category_id, image) VALUES ('$name', '$cost', '$categoryID', '$dst1')";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$dst);
        if ($link->query($insertDish) === TRUE) {
            $_SESSION['status'] = "New Dish created successfully";
           
          } else {
            $_SESSION['statusF'] = "New Dish not created";
          }
    }
}
include('header.php');
?>      <div class="formContainer card bg-light text-dark">
            <h2 class="formHeader"> <?php echo "Add Dish"; ?></h2>
            <form class="needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="inpuName">Name</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control <?php if(!empty($name_err)){ echo 'is-invalid';} ?>" id="inputName" name="name" placeholder="" value="<?php if(!empty($name)){ echo $name;} ?>">
                        <div class="invalid-feedback">
                        <?php echo $name_err; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="inputCost">Cost</label>
                        <input type="number" class="form-control <?php if(!empty($cost_err)){ echo 'is-invalid';} ?>" id="inputCost" name="cost" placeholder="" value="<?php if(!empty($cost)){ echo $cost;} ?>">
                        <div class="invalid-feedback">
                        <?php echo $cost_err; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="selectCategory">Category</label>
                        <select class="form-control" id="selectCategory" name="category">
                        <?php 
                        $sql = "SELECT * FROM category";
                        $i = 1;
                        $result = $link->query($sql);
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['id']; ?>" <?php if($categoryID==$i){ echo "selected";} ?> ><?php echo $row['name'];?></option>
                            <?php
                            $i++;
                        }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" >
                    </div>
                </div>
                
                <hr class="mb-4">
                <div class="float-right" >
                    <button class="btn btn-primary" type="submit">Save session</button>
                </div>
                
            </form>
        </div>
        <div class="border-bottom d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-5">
            <h1 class="h2" ><?php  echo "DISHES" ?></h1>
        </div>
        <div class="container">
                <?php
                    $getdishes = "SELECT dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id ORDER BY category_id";
                    $result2 = $link->query($getdishes);
                    if ($result2->num_rows > 0) {
                        $column_num = 3;
                        $i = $column_num;
                        // ECHO $result2->num_rows;
                        $num_rows = $result2->num_rows + $column_num;
                        while($row = $result2->fetch_assoc()) {
                            $x = $i % $column_num;
                            if($x==0){
                                echo "<div class='row'>";
                                $j = $i + $column_num;
                            }
                            $i++;
                ?>
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm" style="margin:0px 10px 10px 5px;">
                                    <img class="card-img-top" src="<?php if($row['image'] != ""){ echo $row['image']; } else { echo "./Assets/Picture/default.jpg"; } ?>" alt="avatar" >
                                    <div class="card-body">
                                        <h4 class="card-title text-dark"><?php echo $row['name'];?></h4>
                                        <p class="card-text text-dark" ><?php echo $row['cost'];?></p>
                                        <button type="button" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#deleteModal">
                                            Delete
                                        </button>
                                        <button type="button" class="mr-3 btn btn-outline-warning float-right" data-toggle="modal" data-target="#editModal">
                                            Edit
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                <?php
                            if($i==$j || $i == $num_rows){
                                echo "</div>";
                            }  
                        }
                    }
                ?>
                <!-- The Modal -->
                <div class="modal text-dark" id="editModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Modal Heading</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Modal body..
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
            

        
<?php
include("footer.php");
?>