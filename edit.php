
<?php
require_once "config/database.php";

$_SESSION['location'] = 'admin';
$category = "Manage";
$categoryID = 0;

// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) && $_SESSION['username'] == "admin"){
    header("location: index.php");
    exit;
}
//get the id from the url
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM dishes where id='$id'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $cost = $row['cost'];
            $categoryID = $row['category_id'];
            $image = $row['image'];
        }
    }

}

//include the header file
include('header.php');
?>      <div class="formContainer card bg-light text-dark">
            <h2 class="formHeader"> <?php echo "EDIT DISH"; ?></h2>
            <form class="needs-validation" novalidate action="action.php" method="POST" enctype="multipart/form-data">
                <img class="mx-auto d-block" src="<?php if($image != ""){ echo $image; } else { echo "./Assets/Picture/default.jpg"; } ?>" width="400" alt="Dishes" >
                <div class="row">
                    <input type="hidden" name="update_id" id="update_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="image" id="image" value="<?php echo $image; ?>">
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
                        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                    </div>
                </div>
                
                <hr class="mb-4">
                <div class="float-right" >
                    <a href="manage.php" class="btn btn-outline-primary">Cancel</a>
                    <button class="btn btn-outline-danger" name="updateData" type="submit">Save</button>
                </div>
                
            </form>
        </div>

        
<?php
include("footer.php");
?>