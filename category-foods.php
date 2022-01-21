<?php include('partials-front/menu.php'); ?>
<?php
    //Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        //category id is set and get the id
        $category_id = $_GET['category_id'];

        //get the category title based on category ID
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //executed the query
        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($res);
        //get the title
        $category_title = $row['title'];

    }
    else
    {
        //category not passed
        header('location:'.SITEURL); // redirect
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2 class="text-white">Foods on <a href="#" class="text-red"><?php echo $category_title;?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //Category SQL Query to get foods based on selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Executed the query
                $res2 = mysqli_query($conn, $sql2);

                //Count the rows 
                $count2 = mysqli_num_rows($res2);

                //Check wheteher food is available or not
                if($count2>0)
                {
                    //Food is available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                       $id = $row2['id'];
                       $title = $row2['title'];
                       $price = $row2['price'];
                       $descriptio = $row2['description'];
                       $image_name = $row2['image_name'];
                       ?>
                       <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name=="")
                                    {
                                        //Image not available
                                        echo "<div class='error'>Image not available</div>";
                                    }
                                    else
                                    {
                                        ?>
                                         <img src="<?php SITEURL;?>images/food/<?php echo $image_name?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">$<?php echo $price;?></p>
                                <p class="food-detail">
                                    <?php echo $descriptio; ?>
                                </p>
                                <br>

                                <a href="<?php SITEURL;?>order.php?food_id=<?php echo $id ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                       <?php

                    }
                }
                else
                {
                    //food not available
                    echo "<div class='error'>Food not available</div>";
                }


            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>