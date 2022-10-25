
<?php
require_once "config/database.php";

$_SESSION['location'] = 'main_course.php';
$category = "Main Course";

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

include('header.php');
?>

            <div class="container">
                <?php
                    $getdishes = "SELECT dishes.id, dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id WHERE category.name = '$category';";
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
                                        <button type="button" class="btn btn-outline-primary float-right orderbtn">
                                        Order
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
            </div>
            <!---- MODAL FOR Order Button----->
            <div class="modal fade " id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="orderModal">Order Dish</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="needs-validation p-3" novalidate action="action.php" method="POST" enctype="multipart/form-data">
                        <img id="image" class="mx-auto rounded d-block mb-3" src="<?php if($image != ""){ echo $image; } else { echo "./Assets/Picture/default.jpg"; } ?>" width="400" alt="Dishes" >
                        <h4 id="orderName" class="card-title text-dark px-5"></h4>
                        <p id="cost" class="card-text text-dark px-5"></p>
                        <div class="row px-5">
                            <input type="hidden" name="dish_id" id="dish_id" value="<?php echo $id; ?>">
                        </div>
                        <div class="float-right" >
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-outline-primary" name="orderDish" type="submit">Order</button>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('.dishId').hide();
                    $('.orderbtn').on('click', function(){
                        $('#orderModal').modal('show');
                        $image = $(this).closest('.card');
                        var imageData = $image.children("img").map(function(){
                            return $(this).attr("src");
                        }).get();
                        console.log(imageData);

                        $card = $(this).closest('.card-body');
                        var data = $card.children("h4,p").map(function(){
                            return $(this).text();
                        }).get();
                        console.log(data);
                        $('#dish_id').val(data[0]);
                        $('#orderName').text(data[1]);
                        $('#cost').text(data[2]);
                        $('#image').attr("src",imageData[0]);
                    });
                });
        </script>
<?php
include("footer.php");
?>
