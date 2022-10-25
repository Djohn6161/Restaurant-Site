
<?php
require_once "config/database.php";

$_SESSION['location'] = 'admin';
$category = "Manage";
$categoryID = 0;
$image = "";
if(!isset($_SESSION["loggedin"]) && $_SESSION['username'] == "admin"){
    header("location: index.php");
    exit;
}

include('header.php');
?>      <div class="formContainer card bg-light text-dark">
            <h2 class="formHeader"> <?php echo "ADD DISH"; ?></h2>
            <form class="needs-validation" novalidate action="action.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="inpuName"></label>
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
                    <button class="btn btn-primary" name="insertData" type="submit">ADD</button>
                </div>
                
            </form>
        </div>
        <div class="border-bottom d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-5">
            <h1 class="h2" ><?php  echo "DISHES" ?></h1>
        </div>
        <div class="container">
                <?php
                    $getdishes = "SELECT dishes.id, dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id ORDER BY category_id";
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
                                        <p class="dishId"> <?php echo $row['id']; ?></p>
                                        <h4 class="card-title text-dark"><?php echo $row['name'];?></h4>
                                        <p class="card-text text-dark" ><?php echo $row['cost'];?></p>
                                        <button type="button" class="btn btn-outline-danger float-right deletebtn">
                                            Delete
                                        </button>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>"  type="button" class="mr-3 btn btn-outline-warning float-right">
                                            Edit
                                        </a>
                                        
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
                <!-- Modal for delete confirmation -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger text-center" id="deleteModal">Delete Dish</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form action="action.php" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="delete_id" id="delete_id" >
                                    <h4 class="text-dark">Do you want to delete this Dish? </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">NO</button>
                                    <button type="submit" name="deleteData" class="btn btn-outline-danger">YES</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <script>
                $(document).ready(function(){
                    $('.dishId').hide();
                    $('.deletebtn').on('click', function(){
                        $('#deleteModal').modal('show');
                        
                        $card = $(this).closest('.card-body');
                        var data = $card.children("p").map(function(){
                            return $(this).text();
                        }).get();
                        $('#delete_id').val(data[0]);
                        console.log(data[0]);
                    });
                });
        </script>
        
<?php
include("footer.php");
?>