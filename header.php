    <?php $site_division = isset($_SESSION['selected_division']) ? $_SESSION['selected_division'] : ''; ?>
    <header class="header header-before-off">
        <div class="main-wrapper">
            <div class="navbar navbar-expand-lg bsnav bsnav-sticky bsnav-sticky-slide bsnav-transparent">
                <span class="navbar-bar-shape"></span>
                <div class="navbar-container">
                    <div class="navbar-extra-logo">
                        <!-- <a href="index.html">
                            <img src="assets/img/rasi/logo.png" class="logo-outside" alt="thumb">
                        </a> -->
                        <!-- <h4 class="text-primary">Rasi <br>E-Connect</h4> -->
                        <img src="assets/img/rasi/rconnect.png" alt="Rconnect" width="150" height="150">
                    </div>
                    <div class="top-header-menu">
                        <div class="top-bar-area pos-rel topbar-white">
                            <span class="top-bar-shape"></span>
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-xxl-10">
                                    <div class="top-box-wrp d-flex align-items-center">
                                        <div class="top-box top-location">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <span>Rasi Enclave, Green Fields,Coimbatore, Tamil Nadu, INDIA</span>
                                        </div>
                                        <div class="top-email top-box ms-5">
                                            <i class="fa-solid fa-envelope"></i>
                                            <span>customercare@rasiseeds.com</span>
                                        </div>
                                        <div class="top-phone top-box ms-5">
                                            <i class="fa-solid fa-phone"></i>
                                            <span> +91 422 4239800</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-1 col-lg-1 col-xxl-1">
                                    <a href="index.php">
                                        <img src="assets/img/rasi/logo.png" class="logo-outside rasi_top_logo" alt="thumb">
                                    </a>
                                </div>
                                <div class="col-xl-1 col-lg-1 col-xxl-1">
                                    <div class="top-bar-social">
                                        <ul class="top-social">
                                            <li><a href="https://www.facebook.com/people/Rasi-Seeds/100070527293070/"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="https://twitter.com/Rasi_seeds"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="https://www.youtube.com/@rasiseeds4210/featured"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-menu-opt">
                            <div class="navbar-brand-tog">
                                <a class="navbar-brand g-nop" href="index.php">
                                    <img src="assets/img/rasi/logo.png" class="logo-display" alt="thumb">
                                    <img src="assets/img/rasi/logo.png" class="logo-scrolled" alt="thumb">
                                </a>
                                <button class="navbar-toggler toggler-spring">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse justify-content-md-between">
                                <a class="navbar-brand nop" href="index.php">
                                    <img src="assets/img/rasi/logo.png" class="logo-display" alt="thumb">
                                    <img src="assets/img/rasi/logo.png" class="logo-scrolled rasi_top_logo" alt="thumb">
                                </a>
                                <ul class="navbar-nav navbar-mobile justify-content-md-center w-100 navbar-links">
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img" src="assets/img/rasi/menu/home.png" alt="img">
                                            <a class="nav-link ms-3" href="index.php">Home</a>
                                        </div>

                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-2" src="assets/img/rasi/menu/product_info.png" alt="img">
                                            <a class="nav-link ms-3 lh-unset" href="#">Product Info</a>
                                        </div>
                                         <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Crop
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    New Product Details
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img" src="assets/img/rasi/menu/account_info.png" alt="img">
                                            <a class="nav-link ms-3 lh-unset" href="#">Account Info</a>
                                        </div>
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" href="Statement_of_Account.php">
                                                    Statement Of Account  
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="invoice_history.php">
                                                    Invoice History  
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="Credit_Note.php">
                                                    Credit Note 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Tax Information 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Balance Confirmation 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    R-connect Points
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" href="history_of_invoice.php">
                                                    History Of Invoice
                                                </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-2" src="assets/img/rasi/menu/scheme_new.png" alt="img">
                                            <a class="nav-link ms-3 lh-unset" href="our-products.html">Scheme & Promotional</a>
                                        </div>
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Advance Booking Scheme  
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Rasi Subha Labh (RSL)  
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Volume Discount 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Distributor Tour 
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-3" src="assets/img/rasi/menu/product_pricing.png" alt="img">
                                            <a class="nav-link ms-3 lh-unset" href="our-products.html">Product Pricing</a>
                                        </div>
                                        <ul class="navbar-nav">
                                            <?php if($site_division == 'CT01') { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Cotton  
                                                </a>
                                            </li>

                                            <?php } if($site_division == 'FC01') { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">
                                                    Field Crop  
                                                </a>
                                            </li>
                                            <?php } if($site_division == 'FR01') { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">        
                                                    Forage 
                                                </a>
                                            </li>
                                            <?php }  ?>

                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-3" src="assets/img/rasi/menu/payment_new.png" alt="img">
                                            <a class="nav-link ms-3" href="#">Payment <i class="ti-plus"></i></a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-3" src="assets/img/rasi/menu/contact_new.png" alt="img">
                                            <a class="nav-link ms-3" href="#">Contact <i class="ti-plus"></i></a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown fadeup">
                                        <div class="navbar-dropdown plant-based d-flex align-items-center">
                                            <img class="menu-img-3" src="assets/img/rasi/menu/gallery.png" alt="img">
                                            <a class="nav-link ms-3" href="#">Gallery <i class="ti-plus"></i></a>
                                        </div>
                                    </li>
                                   <!--  <li class="nav-item dropdown fadeup">
                                        <a class="nav-link" href="our-products.html">Our Products <i class="ti-plus"></i></a> -->
                                        <!-- <ul class="navbar-nav">
                                            <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                                            <li class="nav-item"><a class="nav-link" href="product-single.html">Shop Single</a></li>
                                            <li class="nav-item"><a class="nav-link" href="cart.html">Cart</a></li>
                                            <li class="nav-item"><a class="nav-link" href="checkout.html">Checkout</a></li>
                                        </ul> -->
                                    <!-- </li> -->
                                   <!--  <li class="nav-item dropdown fadeup">
                                        <a class="nav-link" href="#">Blog <i class="ti-plus"></i></a> -->
                                      <!--   <ul class="navbar-nav">
                                            <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                            <li class="nav-item"><a class="nav-link" href="blog-standard.html">Blog Standard</a></li>
                                            <li class="nav-item"><a class="nav-link" href="single.html">Blog Single</a></li>
                                        </ul> -->
                                    <!-- </li> -->
                                    <!-- <li class="nav-item">
                                        <div class="plant-based d-flex align-items-center">
                                            <img class="menu-img" src="assets/img/rasi/menu/contact.png" alt="img">
                                            <a class="nav-link ms-3" href="contact.html">Contact</a>
                                        </div>
                                    </li> -->
                                </ul>
                                <div class="search-cart nav-profile">
                                    <a class="btn text-white switch_division" style="font-size: 14px;background: blue;"><i class="fa-solid fa-rotate"></i><span class="change-content">Cotton</span></a>
                                    <input type="hidden" class="product_index" value="0">
                                    <!-- <div class="top-bar-social">
                                        <ul class="top-social">
                                            <li><a href="https://www.facebook.com/people/Rasi-Seeds/100070527293070/"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="https://twitter.com/Rasi_seeds"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="https://www.youtube.com/channel/UC_6gpMigChQQRtA4mNoO33w/videos?view_as=subscriber"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bsnav-mobile">
                <div class="bsnav-mobile-overlay"></div>
                <div class="navbar pt-4">
                    <div class="text-center">
                        <img src="assets/img/rasi/rconnect.png" alt="Rconnect" width="150" height="150">
                    </div>
                </div>
            </div>
        </div>
    </header>