
<?php
require_once "config/database.php";

$_SESSION['location'] = 'order.php';
$category = "Order";
$userID = $_SESSION["user_id"];

if(!isset($_SESSION["loggedin"])){
    header("location: index.php");
    exit;
}

include('header.php');
?>

            <div class="container">
                <?php
                    if($_SESSION['username'] == "admin"){
                        $getOrders = "SELECT  orders.id, orders.date_ordered, orders.date_finished, CONCAT(user.firstName,' ', user.lastName) as Fullname, orders.status, dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id JOIN orders on orders.dishes_id = dishes.id JOIN user on orders.user_id = user.id";
                    }else{
                        $getOrders = "SELECT  orders.id, orders.date_ordered, orders.date_finished, CONCAT(user.firstName,' ', user.lastName) as Fullname, orders.status, dishes.name, dishes.cost, dishes.image FROM category JOIN dishes on category.id = dishes.category_id JOIN orders on orders.dishes_id = dishes.id JOIN user on orders.user_id = user.id WHERE user.id = '$userID';";
                    }
                    $result2 = $link->query($getOrders);
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
                                        <?php
                                            if($_SESSION['username'] == "admin"){
                                        ?>
                                                <p class="card-title text-dark"><b>Costumer Name:</b> <?php echo $row['Fullname'];?></p>
                                                <p class="card-text text-dark" ><b>Date Ordered:</b> <?php echo $row['date_ordered'];?></p>
                                                <p class="card-text text-dark" ><b>Date Finished:</b> <?php echo $row['date_finished'];?></p>
                                                <p class="card-text text-dark" ><b>Status:</b> <?php echo $row['status'];?></p>
                                                <button type="button" class="btn btn-outline-primary float-right manageOrder">Manage</button>
                                        <?php
                                            } else{
                                                ?>
                                                <form class="needs-validation p-3" novalidate action="action.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['id']; ?>">
                                                    <div class="float-right" >
                                                        <button class="btn btn-outline-danger" name="cancelOrder" type="submit">Cancel Order</button>
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                        ?>
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
                        <h5 class="modal-title text-dark" id="orderModal">Manage Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="needs-validation p-3" novalidate action="action.php" method="POST" enctype="multipart/form-data">
                        <img id="image" class="mx-auto rounded d-block mb-3" src="<?php if($image != ""){ echo $image; } else { echo "./Assets/Picture/default.jpg"; } ?>" width="400" alt="Dishes" >
                        <h4 id="orderName" class="card-title text-dark px-5"></h4>
                        <p id="cost" class="card-text text-dark px-5"></p>
                        <div class="row px-5">
                            <input type="hidden" name="order_id" id="order_id" value="<?php echo $id; ?>">
                        </div>
                        <div class="float-right" >
                            <button class="btn btn-outline-danger" name="cancelOrder" type="submit">Cancel Order</button>
                            <button class="btn btn-outline-primary" name="finishOrder" type="submit">Finish Order</button>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('.dishId').hide();
                    $('.manageOrder').on('click', function(){
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
                        $('#order_id').val(data[0]);
                        $('#orderName').text(data[1]);
                        $('#cost').text(data[2]);
                        $('#image').attr("src",imageData[0]);
                    });
                });
        </script>
<?php
include("footer.php");
?>
