<?php 
include_once('top_head.php');

include_once('header.php');  

$product_detail_sql = "SELECT * FROM Customer_portal_product_master where Id = ".base64_decode($_GET["id"])."";
if(isset($_SESSION['selected_division'])) {
    $product_detail_sql .= " AND Product_division = '".$_SESSION['selected_division']."'";
}

$sql_execute = sqlsrv_query($conn,$product_detail_sql);
$result = sqlsrv_fetch_array($sql_execute,SQLSRV_FETCH_ASSOC);
?>
    <section class="bannr-section" style="background-image: url('assets/img/rasi/crops.jpg');">
        <div class="container">
            <div class="bannr-text">
                <h2>Product Details</h2>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="index_dev.php">Home</a>
                  </li>
                    <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                </ol>
            </div>
        </div>
        <img src="assets/img/extra-images-2.png" alt="icon" class="extra-images-two">
        <img src="assets/img/dots-1.png" alt="img" class="dots">
        <img src="assets/img/hero-icon-1.png" alt="icon" class="hero-icon">
    </section>
    <section class="gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-info-img">
                        <img src="<?php echo $result['Product_image']; ?>" alt="product-info-img">
                        <img src="assets/img/cbd.png" class="info-img" alt="img">
                    </div>
                </div>
                  <div class="col-lg-6">
                    <div class="product-info">
                      <div class="d-flex align-items-center">
                        <h6><span>Available</span></h6>
                        <!-- <div class="start d-flex align-items-center">
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                        </div>
                        <span>( 1 Review )</span> -->
                      </div>
                      <h2><?php echo $result['Product_name']; ?></h2>
                      <!-- <h5>Strong / 4% / 30ml</h5> -->
                      <h5><?php echo  (int) ($result['Qty_in_kg']);  ?> kg</h5>
                      <?php 
                      $product_actual_price = $result['Price'];
                      $dicount_amount = $result['Discount'];
                      $discount_final_price = ($product_actual_price > 0 && $product_actual_price > $dicount_amount) ? ($product_actual_price - $dicount_amount) : 0;
                      ?>
                      <form class="variations_form">
                        <div class="stock">
                        <span class="price">
                        <?php if($dicount_amount > 0) { ?>
                          <del>
                          <span class="woocommerce-Price-amount">
                          <bdi>
                            <span class="woocommerce-Price-currencySymbol">₹</span><?php echo $product_actual_price;  ?></bdi>
                          </span>
                          </del> 
                        <?php } ?>
                          <ins>
                              <span class="woocommerce-Price-amount amount">
                                <bdi>
                                <span class="woocommerce-Price-currencySymbol">₹</span><?php echo ($dicount_amount > 0) ? $discount_final_price : $product_actual_price; ?></bdi>
                              </span>
                            </ins>
                        </span>
                        </div>
                        <!-- <h6><i class="fa-solid fa-check"></i>Bundle Deal Available</h6> -->
                        <div class="quantity d-flex">
                          <h6>Quantity</h6>
                          <input type="number" class="input-text" step="1" min="1" name="quantity" value="<?php echo $result['Qty_in_pkt']; ?>">
                        </div>
                         <!-- <div class="wishlist">
                          <button type="submit" class="single_add_to_cart_button btn">Add to cart</button>
                          <a href="#"><i class="fa-regular fa-heart"></i></a>
                        </div>
                        <ul class="product_meta">
                            <li><span class="theme-bg-clr">SKU:</span>
                              <ul class="pd-cat">
                                <li><a href="#">Product-1-1</a><li>          
                              </ul>
                            </li>
                            <li><span class="theme-bg-clr">Tags:</span>
                              <ul class="pd-tag">
                                 <li>
                                   <a href="#">featured products,</a>
                                   <a href="#">meat,</a>
                                   <a href="#">new products</a>
                                 </li>    
                              </ul>
                            </li>
                        </ul>
                          <a href="#"><img class="pt-3" src="assets/img/card.png" alt="card"></a> -->
                      </form>
                    </div>
                  </div>
            </div>
        </div>
    </section>
    <section class="gap no-top">
        <div class="container">
            <div class="tab-style nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Description</button>
                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Additional Information</button>
                <!-- <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Reviews</button> -->
            </div>
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <p>
                      <?php echo $result['Product_description'] ?>
                    </p>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <ul class="specification">
                        <li><h6>Type </h6>Organic</li>
                        <li><h6>Dimensions</h6>24 × 1 × 2 cm</li>
                        <li><h6>Weight</h6>0.5kg, 1.5kg, 1kg, 2.5kg, 2kg, 3kg</li>
                      </ul>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="comment">
                        <ul>
                            <li>
                                <img alt="girl" src="https://via.placeholder.com/110x110">
                                <div class="comment-data">
                                    <h4>Willimes Marko</h4>
                                    <span>January 7, 2024</span>
                                    <p>Integer sollicitudin ligula non enim sodales, non lacinia Sewid comm a us in euismod varius nullam feugiat ger sollicitudin ligula non en euismod varius nullam feugiat ultrices.</p>
                                </div>
                                <div class="start">
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                </div>
                            </li>
                            <li class="reply-comment">
                                <img alt="man" src="https://via.placeholder.com/110x110">
                                <div class="comment-data">
                                    <h4>Walkar Jamson</h4>
                                    <span>January 7, 2024</span>
                                    <p>Integer sollicitudin ligula non enim sodales, non lacinia Sewid comm a us in euismod varius nullam feugiat ger sollicitudin ligula non en euismod varius nullam feugiat ultrices.</p>
                                </div>
                                <div class="start">
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                  <i class="fa-solid fa-star"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="comment form-reviews">
                            <h3>Add Reviews</h3>
                            <p>Your email address will not be published. Required fields are marked *</p>
                            <div class="d-flex align-items-center mb-4">
                                <span>Select Rating:</span>
                                  <div class="start d-flex align-items-center ps-md-4">
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                  </div>
                                </div>
                            <form class="leave">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" name="Name" placeholder="Full Name">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" name="Email Address" placeholder="Email Address">
                                    </div>
                                </div>
                                <textarea placeholder="Your Message"></textarea>
                                <button class="btn mt-4 mb-lg-0 mb-5">Post Reviews</button>
                            </form>
                        </div>
                </div>
              </div>
        </div>
    </section>

    <?php include_once('footer.php') ?>

    <?php include_once('bottom_script.php') ?>
