<?php
require_once "config/database.php";

$_SESSION['location'] = 'desserts.php';
$category = "Dessert";

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

include('header.php');
?>
	<div class="container">
                <?php
                    $getdishes = "SELECT dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id WHERE category.name = '$category';";
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
                                        <a href="#" class="btn btn-primary float-right">Order</a>
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
            </div>
<?php
include("footer.php");
?>
