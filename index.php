<?php 
if(isset($_POST['action']) && $_POST['action'] == 'division_select') {
    include '../auto_load.php';
  $_SESSION['selected_division'] = $_POST['division'];
  $res['status'] = 200;
  $res['message'] = "You have choosed division ".$_POST['division_name']."";
  echo json_encode($res);exit;
}

include_once('top_head.php')

?>
<?php 
$product_slider_list_sql = "SELECT * FROM Customer_portal_product_master where Region = '".$_SESSION['region_code']."'";
if(isset($_SESSION['selected_division'])) {
    $product_slider_list_sql .= " AND Product_division = '".$_SESSION['selected_division']."'";
}
// $product_slider_list_sql = "SELECT * FROM Customer_portal_product_master";
 
$product_execute = sqlsrv_query($conn,$product_slider_list_sql);

$path = (isset($_SESSION['selected_division']) && $_SESSION['selected_division'] == 'CT01') ? 'assets/img/rasi/products/cotton/' : ((isset($_SESSION['selected_division']) && $_SESSION['selected_division'] == 'FC01') ? 'assets/img/rasi/products/field_crops/' : 'assets/img/rasi/products/forage/');
?>

    <!-- preloader end -->
    <!-- header -->
<!--     <header>
        <div class="container">
            <div class="top-bar">
                <div class="content-header">
                    <i>
                        <svg id="outline" height="512" viewBox="0 0 48 48" width="512"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m41.211 37.288a4.112 4.112 0 1 1 4.109-4.112 4.114 4.114 0 0 1 -4.109 4.112zm0-6.724a2.612 2.612 0 1 0 2.609 2.612 2.613 2.613 0 0 0 -2.609-2.612z" />
                            <path
                                d="m19.542 37.288a4.112 4.112 0 1 1 4.108-4.112 4.115 4.115 0 0 1 -4.108 4.112zm0-6.724a2.612 2.612 0 1 0 2.608 2.612 2.614 2.614 0 0 0 -2.608-2.612z" />
                            <path
                                d="m46.621 33.926h-2.051a.75.75 0 0 1 0-1.5h1.839v-3.977a3.16 3.16 0 0 0 -.4-1.536l-4.06-7.279a.4.4 0 0 0 -.349-.205h-5.533v13h1.786a.75.75 0 0 1 0 1.5h-2.536a.75.75 0 0 1 -.75-.75v-14.5a.75.75 0 0 1 .75-.75h6.283a1.9 1.9 0 0 1 1.66.974l4.059 7.28a4.662 4.662 0 0 1 .589 2.266v4.19a1.289 1.289 0 0 1 -1.287 1.287z" />
                            <path
                                d="m16.183 33.926h-7.191a.75.75 0 0 1 -.75-.75v-5.768a.75.75 0 0 1 1.5 0v5.018h6.441a.75.75 0 0 1 0 1.5z" />
                            <path
                                d="m8.992 24.747a.75.75 0 0 1 -.75-.75v-5.036a.75.75 0 0 1 1.5 0v5.039a.75.75 0 0 1 -.75.747z" />
                            <path
                                d="m35.317 33.926h-12.417a.75.75 0 0 1 0-1.5h11.667v-19.621h-24.825v3.089a.75.75 0 0 1 -1.5 0v-3.227a1.364 1.364 0 0 1 1.363-1.362h25.1a1.364 1.364 0 0 1 1.362 1.362v20.509a.75.75 0 0 1 -.75.75z" />
                            <path d="m11.957 28.158h-9.519a.75.75 0 0 1 0-1.5h9.519a.75.75 0 0 1 0 1.5z" />
                            <path d="m19.542 24.747h-13.283a.75.75 0 0 1 0-1.5h13.283a.75.75 0 0 1 0 1.5z" />
                            <path d="m5.846 20.787h-5.187a.75.75 0 1 1 0-1.5h5.187a.75.75 0 0 1 0 1.5z" />
                            <path d="m14.163 16.644h-9.156a.75.75 0 1 1 0-1.5h9.156a.75.75 0 0 1 0 1.5z" />
                        </svg>
                    </i>
                    <h4>Free UK delivery on orders over £25.<a href="#">See Our Shipping</a></h4>
                </div>
                <ul class="social-media">
                    <li><a href="#"><i class="fab fa-facebook-f icon"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter icon"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                </ul>
                <div class="collnumber">
                    <i>
                        <svg version="1.1" xml:space="preserve" width="682.66669" height="682.66669"
                            viewBox="0 0 682.66669 682.66669" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse">
                                    <path d="M 0,512 H 512 V 0 H 0 Z" />
                                </clipPath>
                            </defs>
                            <g transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)">
                                <g>
                                    <g clip-path="url(#clipPath3824)">
                                        <g transform="translate(409.9102,69.6396)">
                                            <path
                                                d="m 0,0 c 0,-32.939 -26.7,-59.64 -59.641,-59.64 h -64.599 c -22.59,0 -43.24,12.76 -53.34,32.97 L -190.92,0 -220.74,-59.64 -250.561,0 -280.38,-59.64 -310.2,0 -340.021,-59.64 -369.84,0 -399.66,-59.64"
                                                style="fill:none;stroke:#000000;stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" />
                                        </g>
                                        <g transform="translate(266.25,246)">
                                            <path
                                                d="m 0,0 c 0,-5.522 -4.478,-10 -10,-10 -5.522,0 -10,4.478 -10,10 0,5.522 4.478,10 10,10 C -4.478,10 0,5.522 0,0"
                                                style="fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none" />
                                        </g>
                                        <g transform="translate(224.9414,278.2939)">
                                            <path
                                                d="m 0,0 c -12.175,14.184 -23.106,28.649 -32.062,42.666 -7.379,11.54 -5.149,26.83 4.541,36.521 l 33.66,33.659 c 7.24,7.24 7.24,18.98 0,26.22 l -79.21,79.21 c -7.241,7.24 -18.981,7.24 -26.231,0 l -20.04,-20.05 c -32.529,-32.53 -41.33,-82.16 -20.909,-123.39 36.34,-73.35 123.1,-197.78 267.149,-268.41 41.34,-20.27 91.92,-11.67 124.481,20.88 l 20.5,20.5 c 7.239,7.25 7.239,18.99 0,26.23 l -79.91,79.2 c -7.25,7.25 -18.99,7.25 -26.231,0 l -33.66,-33.65 c -9.68,-9.69 -24.97,-11.92 -36.519,-4.54 -10.185,6.506 -20.61,14.058 -30.994,22.375"
                                                style="fill:none;stroke:#000000;stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </i><a href="callto:+34640225587">+34640225587</a>
                    <div class="login">
                        <a href="#">Email Us</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="container">
                <div class="two-bar">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.html">
                                <img alt="logo" src="assets/img/logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="bar-menu">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <nav class="navbar">
                        <ul class="navbar-links">
                            <li class="navbar-dropdown">
                                <a href="#">home</a>
                                <div class="dropdown">
                                    <a href="index.html">home 1</a>
                                    <a href="index-2.html">home 2</a>
                                    <a href="index-3.html">home 3</a>
                                </div>
                            </li>
                            <li class="navbar-dropdown">
                                <a href="about.html">About</a>
                            </li>
                            <li class="navbar-dropdown">
                                <a href="#">Services</a>
                                <div class="dropdown">
                                    <a href="service.html">service</a>
                                    <a href="service-details.html">service details</a>
                                </div>
                            </li>
                            <li class="navbar-dropdown">
                                <a href="#">Pages</a>
                                <div class="dropdown">
                                    <a href="team-details.html">team details</a>
                                    <a href="pricing-plans.html">Pricing Plans</a>
                                    <a href="faqs.html">faqs</a>
                                    <a href="404.html">404</a>
                                </div>
                            </li>
                            <li class="navbar-dropdown">
                                <span>new</span>
                                <a href="#">Shop</a>
                                <div class="dropdown">
                                    <a href="our-products.html">our products</a>
                                    <a href="product-details.html">product details</a>
                                    <a href="shop-cart.html">shop cart</a>
                                    <a href="checkout.html">checkout</a>
                                </div>
                            </li>
                            <li class="navbar-dropdown">
                                <a href="#">News</a>
                                <div class="dropdown">
                                    <a href="our-blog.html">our blog</a>
                                    <a href="blog-details.html">blog details</a>
                                </div>
                            </li>
                            <li class="navbar-dropdown">
                                <a href="contact.html">Contact</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="header-search">
                        <div class="header-search-button search-box-outer">
                            <a href="javascript:void(0)" class="search-btn">
                                <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="12">
                                        <path
                                            d="m21.71 20.29-2.83-2.82a9.52 9.52 0 1 0 -1.41 1.41l2.82 2.83a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zm-17.71-8.79a7.5 7.5 0 1 1 7.5 7.5 7.5 7.5 0 0 1 -7.5-7.5z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <a href="#" class="user"><i><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m437.019531 74.980469c-48.351562-48.351563-112.640625-74.980469-181.019531-74.980469s-132.667969 26.628906-181.019531 74.980469c-48.351563 48.351562-74.980469 112.640625-74.980469 181.019531s26.628906 132.667969 74.980469 181.019531c48.351562 48.351563 112.640625 74.980469 181.019531 74.980469s132.667969-26.628906 181.019531-74.980469c48.351563-48.351562 74.980469-112.640625 74.980469-181.019531s-26.628906-132.667969-74.980469-181.019531zm-325.914062 354.316406c8.453125-72.734375 70.988281-128.890625 144.894531-128.890625 38.960938 0 75.597656 15.179688 103.15625 42.734375 23.28125 23.285156 37.964844 53.6875 41.742188 86.152344-39.257813 32.878906-89.804688 52.707031-144.898438 52.707031s-105.636719-19.824219-144.894531-52.703125zm144.894531-159.789063c-42.871094 0-77.753906-34.882812-77.753906-77.753906 0-42.875 34.882812-77.753906 77.753906-77.753906s77.753906 34.878906 77.753906 77.753906c0 42.871094-34.882812 77.753906-77.753906 77.753906zm170.71875 134.425782c-7.644531-30.820313-23.585938-59.238282-46.351562-82.003906-18.4375-18.4375-40.25-32.269532-64.039063-40.9375 28.597656-19.394532 47.425781-52.160157 47.425781-89.238282 0-59.414062-48.339844-107.753906-107.753906-107.753906s-107.753906 48.339844-107.753906 107.753906c0 37.097656 18.84375 69.875 47.464844 89.265625-21.886719 7.976563-42.140626 20.308594-59.566407 36.542969-25.234375 23.5-42.757812 53.464844-50.882812 86.347656-34.410157-39.667968-55.261719-91.398437-55.261719-147.910156 0-124.617188 101.382812-226 226-226s226 101.382812 226 226c0 56.523438-20.859375 108.265625-55.28125 147.933594zm0 0" />
                                </svg></i></a>
                        <div class="donation">

                            <a href="JavaScript:void(0)" class="pr-cart">
                                <svg enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="m337.034 420.796c.835.139 1.665.207 2.484.207 7.2 0 13.555-5.2 14.778-12.537l15-90c1.362-8.171-4.158-15.9-12.33-17.262-8.172-1.366-15.9 4.158-17.262 12.33l-15 90c-1.362 8.172 4.158 15.901 12.33 17.262z" />
                                        <path
                                            d="m158.704 408.466c1.223 7.337 7.577 12.537 14.778 12.537.819 0 1.649-.067 2.484-.207 8.172-1.362 13.692-9.09 12.33-17.262l-15-90c-1.362-8.172-9.089-13.691-17.262-12.33-8.172 1.362-13.692 9.09-12.33 17.262z" />
                                        <path
                                            d="m497 181h-52.791l-115.496-144.37c-5.174-6.467-14.613-7.518-21.083-2.342-6.469 5.175-7.518 14.614-2.342 21.083l100.503 125.629h-299.582l100.504-125.629c5.175-6.469 4.126-15.909-2.342-21.083-6.47-5.176-15.909-4.126-21.083 2.342l-115.497 144.37h-52.791c-8.284 0-15 6.716-15 15v60c0 8.284 6.716 15 15 15h18.686l56.892 199.121c1.839 6.44 7.725 10.879 14.422 10.879h302c6.697 0 12.583-4.439 14.423-10.879l56.891-199.121h18.686c8.284 0 15-6.716 15-15v-60c0-8.284-6.716-15-15-15zm-101.314 270h-279.372l-51.428-180h382.229zm86.314-210c-51.385 0-403.32 0-452 0v-30h452z" />
                                        <path
                                            d="m256 421c8.284 0 15-6.716 15-15v-90c0-8.284-6.716-15-15-15s-15 6.716-15 15v90c0 8.285 6.716 15 15 15z" />
                                    </g>
                                </svg>



                            </a>

                            <div class="cart-popup">

                                <ul>

                                    <li class="d-flex align-items-center position-relative">

                                        <div class="p-img light-bg">

                                            <img alt="img" src="https://via.placeholder.com/100x100">

                                        </div>

                                        <div class="p-data">

                                            <h3 class="font-semi-bold">Anti blemish facial serum</h3>

                                            <p class="theme-clr font-semi-bold">1 x $25.00</p>

                                        </div>

                                        <a href="JavaScript:void(0)" id="crosss"></a>

                                    </li>

                                    <li class="d-flex align-items-center position-relative">

                                        <div class="p-img light-bg">

                                            <img alt="img" src="https://via.placeholder.com/100x100">

                                        </div>

                                        <div class="p-data">

                                            <h3 class="font-semi-bold">Anti blemish facial serum</h3>

                                            <p class="theme-clr font-semi-bold">1 x $25.00</p>

                                        </div>

                                        <a href="JavaScript:void(0)" id="cross"></a>

                                    </li>

                                </ul>

                                <div class="cart-total d-flex align-items-center justify-content-between">

                                    <span class="font-semi-bold">Total:</span>

                                    <span class="font-semi-bold">$60.00</span>

                                </div>

                                <div class="cart-btns d-flex align-items-center justify-content-between">

                                    <a class="font-bold" href="JavaScript:void">View Cart</a>

                                    <a class="font-bold theme-bg-clr text-white checkout"
                                        href="JavaScript:void">Checkout</a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-nav hmburger-menu" id="mobile-nav" style="display:block;">
            <div class="res-log">
                <a href="index.html">
                    <img src="assets/img/logo.png" alt="Responsive Logo" class="white-logo">
                </a>
            </div>
            <ul>
                <li class="menu-item-has-children"><a href="JavaScript:void(0)">Home</a>
                    <ul class="sub-menu">
                        <li><a href="index.html">home 1</a></li>
                        <li><a href="index-2.html">home 2</a></li>
                        <li><a href="index-3.html">home 3</a></li>
                    </ul>
                </li>
                <li><a href="about.html">about</a></li>
                <li class="menu-item-has-children"><a href="JavaScript:void(0)">Services</a>
                    <ul class="sub-menu">
                        <li><a href="service.html">service</a></li>
                        <li><a href="service-details.html">service details</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children"><a href="JavaScript:void(0)">Pages</a>
                    <ul class="sub-menu">
                        <li><a href="team-details.html">team details</a></li>
                        <li><a href="pricing-plans.html">Pricing Plans</a></li>
                        <li><a href="faqs.html">faqs</a></li>
                        <li><a href="404.html">404</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children"><a href="JavaScript:void(0)">shop</a>
                    <ul class="sub-menu">
                        <li><a href="our-products.html">our products</a></li>
                        <li><a href="product-details.html">product details</a></li>
                        <li><a href="shop-cart.html">shop cart</a></li>
                        <li><a href="checkout.html">checkout</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children"><a href="JavaScript:void(0)">News</a>
                    <ul class="sub-menu">
                        <li><a href="our-blog.html">our blog</a></li>
                        <li><a href="blog-details.html">blog details</a></li>
                    </ul>
                </li>
                <li><a href="Contact.html">Contact</a></li>
            </ul>
            <a href="JavaScript:void(0)" id="res-cross"></a>
        </div>
    </header> -->

        <!-- Start header
    ============================================= -->
    <?php include_once('header.php'); ?>
        <!--  -->
        <style type="text/css">

        @keyframes slide-left {
              0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }  
        }

        .announcement-bar__link .announcement-bar__message {
            display: flex;
            align-items: center;
            justify-content: end;
/*            padding: 10px 0;*/
            animation: slide-left 30s linear infinite;
        }
        .announcement-bar__message .message {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: end;
/*            padding: 0 80px;*/
        }

        .announcement-bar {
            position: relative;
            /*background-image: linear-gradient(to right, rgb(46, 29, 211) 0%, #5d2eee 51%, #6a33f5 100%);*/
            z-index: 30;
/*            background: #01af41;*/
             background: #00722d !important; 


        }

        .announcement-bar__link .announcement-bar__message:hover {
            animation-play-state:paused;
        }

        #announcement-bar-id {
            margin-top: 160px;  
        }

        @media only screen and (max-width: 991px) {
            #announcement-bar-id {
                margin-top: 100px;  
            }
        }

        .modal.fade.zoom:not(.show) .modal-dialog {
            transform: scale(0.8);
        }

        .product_modal_content {
            border-radius: 40px;
            padding: 20px;
        }

        .product_modal_describe {
            background: #e1ffe4;
            padding: 20px;
            border-bottom: 10p;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gainsboro;
        }

        .product_modal_title {
            border-bottom: 4px solid green;
        }
        .fw-700 {
            font-weight: 700;
        }

        .product_modal_describe ul li {
            display: list-item;
            list-style-type: disc;
        }

    /* Border animation */
    .product_modal_content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 0;
      border-top: 3px solid #ff6347; /* Starting color */
      border-right: 3px solid transparent;
      animation: borderMove 5s infinite linear;
    }

    /* Keyframes for border animation */
   /* @keyframes borderMove {
      0% {
        width: 0;
        height: 0;
        border-right-width: 3px;
        border-bottom: 0 solid transparent;
        transform: translateX(0) translateY(0);
    }
    25% {
        width: 100%;
        height: 0;
        border-right-width: 3px;
        border-bottom: 0 solid transparent;
        transform: translateX(0) translateY(0);
    }
    50% {
        width: 100%;
        height: 100%;
        border-right-width: 0;
        border-bottom-width: 3px;
        transform: translateX(0) translateY(0);
    }
    75% {
        width: 0;
        height: 100%;
        border-right-width: 0;
        border-bottom-width: 3px;
        transform: translateX(0) translateY(0);
    }
    100% {
        width: 0;
        height: 0;
        border-right-width: 3px;
        border-bottom: 0 solid transparent;
        transform: translateX(0) translateY(0);
    }
    }*/
    button.owl-prev:before {
        width: 15px;
    }

    button.owl-next:before {
        width: 15px;
    }

    .testimonial-video i {
        position: absolute;
        animation: shadow-pulse 1s infinite;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: var(--theme-colour);
        transform: translate(-50%, -50%);
        top: 45%;
        left: 72%;
    }

    @media only screen and (min-width: 320px) and (max-width: 480px) {
        .testimonial-video {
            position: absolute;
            right: 10px;
            text-align: center;
            margin-bottom: -50px;
            top: 230px;
            width: 100px;
        }

    }

    @media only screen and (min-width: 481px) and (max-width: 768px) {
        .testimonial-video {
            position: absolute;
            right: 275px;
            text-align: center;
            margin-bottom: -50px;
            top: 230px;
            width: 100px;
        }

    }

     @media only screen and (min-width: 769px) and (max-width: 991px) {
        .testimonial-video {
            position: absolute;
            right: 440px;
            text-align: center;
            margin-bottom: -50px;
            top: 218px;
            width: 100px;
        }

    }


    @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .testimonial-video {
            position: absolute;
            right: 220px;
            text-align: center;
            margin-bottom: -50px;
            top: 247px;
            width: 100px;
        }

    }

    @media only screen and (min-width: 1200px) and (max-width: 1249px) {
        .testimonial-video {
            position: absolute;
            right: 310px;
            text-align: center;
            margin-bottom: -50px;
            top: 219px;
            width: 100px;
        }

    }

    @media only screen and (min-width: 1250px) and (max-width: 1399px) {
        .testimonial-video {
            position: absolute;
            right: 360px;
            text-align: center;
            margin-bottom: -50px;
            top: 219px;
            width: 100px;
        }

    }

    @media only screen and (min-width: 1400px) {
        .testimonial-video {
            position: absolute;
            right: 367px;
            text-align: center;
            margin-bottom: -50px;
            top: 219px;
            width: 100px;
        }

    }


/* ------ Rotate Carouse (left) ------ */
.rotate-carouse-left.mfp-bg {
  opacity: 0;
  -webkit-transition: all .5s ease-out;
     -moz-transition: all .5s ease-out;
          transition: all .5s ease-out;
}
/* overlay animate in */
.rotate-carouse-left.mfp-bg.mfp-ready {
  opacity: 0.8;
}
/* overlay animate out */
.rotate-carouse-left.mfp-bg.mfp-removing {
  opacity: 0;
}

/* content at start */
.rotate-carouse-left.mfp-wrap .mfp-content {
  opacity: 0;
  
}
/* content animate it */
.rotate-carouse-left.mfp-wrap.mfp-ready .mfp-content {
  opacity: 1;
     -webkit-transform-origin: 0% 50%;
      -moz-transform-origin: 0% 50%;
           transform-origin: 0% 50%;
    -webkit-animation: rotateCarouselLeftIn .8s both ease;
    -moz-animation: rotateCarouselLeftIn .8s both ease;
            animation: rotateCarouselLeftIn .8s both ease;
}

/* content animate out */
.rotate-carouse-left.mfp-wrap.mfp-removing .mfp-content {
   -webkit-transform-origin: 100% 50%;
      -moz-transform-origin: 100% 50%;
           transform-origin: 100% 50%;
    -webkit-animation: rotateCarouselLeftOut .8s both ease;
    -moz-animation: rotateCarouselLeftOut .8s both ease;
            animation: rotateCarouselLeftOut .8s both ease;
   
    opacity: 0;
}


@-webkit-keyframes rotateCarouselLeftOut {
    to { opacity: .3; -webkit-transform: translateX(-150%) scale(.4) rotateY(-65deg); }
}
@-moz-keyframes rotateCarouselLeftOut {
    to { opacity: .3; -moz-transform: translateX(-150%) scale(.4) rotateY(-65deg); }
}
@keyframes rotateCarouselLeftOut {
    to { opacity: .3; transform: translateX(-150%) scale(.4) rotateY(-65deg); }
}

@-webkit-keyframes rotateCarouselLeftIn {
    from { opacity: .3; -webkit-transform: translateX(200%) scale(.4) rotateY(65deg); }
}
@-moz-keyframes rotateCarouselLeftIn {
    from { opacity: .3; -moz-transform: translateX(200%) scale(.4) rotateY(65deg); }
}
@keyframes rotateCarouselLeftIn {
    from { opacity: .3; transform: translateX(200%) scale(.4) rotateY(65deg); }
}

@-webkit-keyframes rotateCarouselRightOut {
    to { opacity: .3; -webkit-transform: translateX(200%) scale(.4) rotateY(65deg); }
}
@-moz-keyframes rotateCarouselRightOut {
    to { opacity: .3; -moz-transform: translateX(200%) scale(.4) rotateY(65deg); }
}
@keyframes rotateCarouselRightOut {
    to { opacity: .3; transform: translateX(200%) scale(.4) rotateY(65deg); }
}

@-webkit-keyframes rotateCarouselRightIn {
    from { opacity: .3; -webkit-transform: translateX(-200%) scale(.4) rotateY(-65deg); }
}
@-moz-keyframes rotateCarouselRightIn {
    from { opacity: .3; -moz-transform: translateX(-200%) scale(.4) rotateY(-65deg); }
}
@keyframes rotateCarouselRightIn {
    from { opacity: .3; transform: translateX(-200%) scale(.4) rotateY(-65deg); }
}
 

</style>


    

<!--     <div class="announcement" style="margin-top: 160px;">
    <p class="text-dark">hello</p>    
</div> -->
<input type="hidden" id="divison_file_path" value="<?php echo $path; ?>">

<div class="announcement-bar" role="region" id="announcement-bar-id">
    <div class="wrapper-content">
        <a href="#" target="_blank" class="announcement-bar__link link focus-inset">
            <span class="announcement-bar__message text-center">
                <span class="message">
                    <span class="text-white">
                        Distributors Tours Scheme is available 
                    </span>
                </span>
            </span>
        </a>
    </div>
</div>

    <!-- End header -->
    <section class="hero-section">
        <div class="container-fluid p-0">
            <div class="slider-hero owl-carousel">
                <div class="row align-items-center item">
                    <div class="offset-lg-1 col-lg-5">
                        <div class="hero-text">
                            <h1> JET</h1>
                            <p>Sturdy plant with good boll retention,
                                Big Bolls with more Kapas weight,
                                Clean Bursting and Easy Picking,
                            Medium Maturity Hybrid Suitable for second Cropping</p>
                            <!-- <a href="#" class="btn">Discover Products</a> -->
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="hero-img">
                            <figure><img src="<?php echo $path; ?>Pack Shot 432_479.png" alt="img"></figure>
                            <img src="<?php echo $path; ?>Field Photo.png" alt="hero-img">

                        </div>
                    </div>
                </div>
                <div class="row align-items-center item">
                    <div class="offset-lg-1 col-lg-5">
                        <div class="hero-text">
                            <h1> Research Paddy</h1>
                            <p>Suitable for Closer Spacing Plantation,
                                Maturity Suitable for Second crop sowing,
                                Long Sympodia with Chain Bearing,
                            Good Sucking Pest Tolerance</p>
                            <!-- <a href="#" class="btn">Discover Products</a> -->
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="hero-img">
                            <!-- <figure><img src="https://via.placeholder.com/432x479" alt="img"></figure>
                            <img src="https://via.placeholder.com/747x597" alt="hero-img"> -->
                            <figure><img src="<?php echo $path; ?>Pack Shot 432_479.png" alt="img"></figure>
                            <img src="<?php echo $path; ?>Field Photo.png" alt="hero-img">

                        </div>
                    </div>
                </div>
                <div class="row align-items-center item">
                    <div class="offset-lg-1 col-lg-5">
                        <div class="hero-text">
                            <h1> SCH-200</h1>
                            <p>Source of high energy,
                                Consistent quality and palatable feed,
                                High dry matter yield,
                            Good for silage and green fodder</p>
                            <!-- <a href="#" class="btn">Discover Products</a> -->
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="hero-img">
                           <!--  <figure><img src="https://via.placeholder.com/432x479" alt="img"></figure>
                            <img src="https://via.placeholder.com/747x597" alt="hero-img"> -->
                            <figure><img src="<?php echo $path; ?>Pack Shot 432_479.png" alt="img"></figure>
                            <img src="<?php echo $path; ?>Field Photo.png" alt="hero-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviews" style="visibility: hidden;">
            <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <h5>4.9 | 6000+ Reviews</h5>
        </div>
        <img src="assets/img/rasi/cotton-img.png" alt="icon" class="hero-icon-1">
        <!-- <img src="assets/img/rasi/cotton-img.png" alt="icon" class="hero-icon-2"> -->
    </section>
    <!-- <div class="gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based">
                        <img src="assets/img/plant-based-icon-1.png" alt="img">
                        <a href="#">Plant Based & Vegan</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based">
                        <img src="assets/img/plant-based-icon-2.png" alt="img">
                        <a href="#">sustainable packaging</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based">
                        <img src="assets/img/plant-based-icon-3.png" alt="img">
                        <a href="#">Carbon Negative</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based">
                        <img src="assets/img/plant-based-icon-4.png" alt="img">
                        <a href="#">Greenpoints Loyalty</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based mb-0">
                        <img src="assets/img/plant-based-icon-5.png" alt="img">
                        <a href="#">Quality Assured</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="plant-based mb-0">
                        <img src="assets/img/plant-based-icon-6.png" alt="img">
                        <a href="#">Free 48 Hour Delivery</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
   <!--  <section class="section-anti-aging gap no-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="anti-aging-img">
                        <div class="natural-img">
                            <figure class="natural-1">
                                <img src="https://via.placeholder.com/220x237" alt="img">
                            </figure>
                            <figure>
                                <img src="https://via.placeholder.com/320x348" alt="img">
                            </figure>
                            <figure>
                                <img src="https://via.placeholder.com/220x294" alt="img">
                            </figure>
                            <figure>
                                <img src="https://via.placeholder.com/220x220" alt="img">
                            </figure>
                        </div>
                        <div class="collnumber">
                            <i>
                                <svg version="1.1" xml:space="preserve" width="682.66669" height="682.66669"
                                    viewBox="0 0 682.66669 682.66669" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <clipPath clipPathUnits="userSpaceOnUse">
                                            <path d="M 0,512 H 512 V 0 H 0 Z" />
                                        </clipPath>
                                    </defs>
                                    <g transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)">
                                        <g>
                                            <g clip-path="url(#clipPath3824)">
                                                <g transform="translate(409.9102,69.6396)">
                                                    <path
                                                        d="m 0,0 c 0,-32.939 -26.7,-59.64 -59.641,-59.64 h -64.599 c -22.59,0 -43.24,12.76 -53.34,32.97 L -190.92,0 -220.74,-59.64 -250.561,0 -280.38,-59.64 -310.2,0 -340.021,-59.64 -369.84,0 -399.66,-59.64"
                                                        style="fill:none;stroke:#000000;stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" />
                                                </g>
                                                <g transform="translate(266.25,246)">
                                                    <path
                                                        d="m 0,0 c 0,-5.522 -4.478,-10 -10,-10 -5.522,0 -10,4.478 -10,10 0,5.522 4.478,10 10,10 C -4.478,10 0,5.522 0,0"
                                                        style="fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none" />
                                                </g>
                                                <g transform="translate(224.9414,278.2939)">
                                                    <path
                                                        d="m 0,0 c -12.175,14.184 -23.106,28.649 -32.062,42.666 -7.379,11.54 -5.149,26.83 4.541,36.521 l 33.66,33.659 c 7.24,7.24 7.24,18.98 0,26.22 l -79.21,79.21 c -7.241,7.24 -18.981,7.24 -26.231,0 l -20.04,-20.05 c -32.529,-32.53 -41.33,-82.16 -20.909,-123.39 36.34,-73.35 123.1,-197.78 267.149,-268.41 41.34,-20.27 91.92,-11.67 124.481,20.88 l 20.5,20.5 c 7.239,7.25 7.239,18.99 0,26.23 l -79.91,79.2 c -7.25,7.25 -18.99,7.25 -26.231,0 l -33.66,-33.65 c -9.68,-9.69 -24.97,-11.92 -36.519,-4.54 -10.185,6.506 -20.61,14.058 -30.994,22.375"
                                                        style="fill:none;stroke:#000000;stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </i>
                            <div>
                                <h4>Call Us Anytime</h4>
                                <a href="callto:+34640225587">+91 422 4239800</a>
                            </div>
                        </div>
                        <img src="assets/img/dots.png" alt="dots" class="dots-1">
                        <img src="assets/img/dots.png" alt="dots" class="dots-2">
                    </div>
                </div>
                <div class="col-lg-6 ps-xl-5">
                    <div class="heading two">
                        <h6>CAREFULLY FORMULATED PRODUCTS</h6>
                        <h2>Natural Anti-Aging Skin Remedies</h2>
                        <p>Tellus molestie nunc non blandit massa enim nec. Tortor id aliquet lectus proin. Dui vivamus
                            arcu felis bibendum ut tris tique.olestie nunc non bvivamus.</p>
                    </div>
                    <div class="tag-cbd">
                        <ul class="list-style">
                            <li>Delicious & Intense Flavours</li>
                            <li>Clean, Natural Ingredients</li>
                            <li>Industry is still not regulated very well. </li>
                            <li>Meet many CBD oil users</li>
                        </ul>
                        <img src="assets/img/cbd.png" alt="img">
                    </div>
                    <div class="other">
                        <img src="https://via.placeholder.com/60x60" alt="img">
                        <div>
                            <h4>Thomas Willimes</h4>
                            <p>Director and company ceo</p>
                        </div>
                    </div>
                    <img src="assets/img/signature.png" alt="img" class="signature">
                </div>
            </div>
            <div class="money-back" style="background-image:url(assets/img/money-back.jpg);">
                <div class="">
                    <h4>Our money-back guarantee</h4>
                    <p>Not satisfied? We’ve got you covered. If you’re not satisfied with your
                        order, get your money back with our 30 day satisfaction guarantee.</p>
                </div>
                <img src="assets/img/money-back-icon.png" alt="img">
                <img src="assets/img/rasi/cotton-img.png" alt="leaf" class="leaf">
                <img src="assets/img/dots.png" alt="dots" class="dots">
                <img src="assets/img/rasi/cotton-img.png" alt="icon" class="hero-icon">
            </div>
        </div>
    </section> -->
    <section class="section-products gap" style="background-color: #e9e9e966;">
        <div class="container">
            <div class="heading">
                <img src="assets/img/heading-img.png" alt="img">
                <h6>DELIGHTFULLY REFRESHING </h6>
                <h2>Products</h2>
            </div>
            <div class="row products-slider owl-carousel">
                <?php   while($Result = sqlsrv_fetch_array($product_execute,SQLSRV_FETCH_ASSOC)) { ?>
                <div class="col-lg-12 item">
                    <div class="products" data-productid="<?php echo $Result['Id']; ?>">
                        <a class="btn btn-primary view_product" data-productid="<?php echo $Result['Id']; ?>">View</a>
                        <!-- <img src="https://via.placeholder.com/202x202" alt="img"> -->
                        <?php 
                            $product_actual_price = $Result['Price'];
                            $dicount_amount = $Result['Discount'];
                            $discount_final_price = ($product_actual_price > 0 && $product_actual_price > $dicount_amount) ? ($product_actual_price - $dicount_amount) : 0;
                         ?>

                        <img src="<?php echo $path.''.$Result['Product_image']; ?>" alt="img">
                        <!-- <a href="product_details.php?id=<?php echo base64_encode($Result['Id']); ?>"><?php echo $Result['Product_name']; ?></a> -->
                        <a><?php echo $Result['Product_name']; ?></a>

                        <h4>
                            <?php if($dicount_amount > 0) { ?>
                                <del class="text-danger"><?php echo $product_actual_price;  ?></del>
                            <?php } ?>

                            <?php echo ($dicount_amount > 0) ? $discount_final_price : $product_actual_price; ?></h4>
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <span>-18%</span>

                    </div>
                </div>
              <?php }?>

                <!-- <div class="col-lg-12 item">
                    <div class="products">
                        <a href="#" class="btn">Add to Cart</a>
                        <img src="https://via.placeholder.com/202x202" alt="img">
                        <h6><i class="fa-solid fa-check"></i>Bundle Deal Available</h6>
                        <a href="product-details.html">Amazing Grass Green Superfood Original 240g</a>
                        <h4><del>$18.00</del>$14.00</h4>
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12 item">
                    <div class="products">
                        <a href="#" class="btn">Add to Cart</a>
                        <img src="https://via.placeholder.com/202x202" alt="img">
                        <a href="product-details.html">Amazing Grass Green Superfood Original 240g</a>
                        <h4><del>$18.00</del>$14.00</h4>
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <span>-20%</span>
                    </div>
                </div>
                <div class="col-lg-12 item">
                    <div class="products">
                        <a href="#" class="btn">Add to Cart</a>
                        <img src="https://via.placeholder.com/202x202" alt="img">
                        <h6><i class="fa-solid fa-check"></i>Bundle Deal Available</h6>
                        <a href="product-details.html">Amazing Grass Green Superfood Original 240g</a>
                        <h4><del>$18.00</del>$14.00</h4>
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12 item">
                    <div class="products">
                        <a href="#" class="btn">Add to Cart</a>
                        <img src="https://via.placeholder.com/202x202" alt="img">
                        <a href="product-details.html">Amazing Grass Green Superfood Original 240g</a>
                        <h4><del>$18.00</del>$14.00</h4>
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <span>-18%</span>
                    </div>
                </div> -->
            </div>
          <!--   <div class="cbd-oil-dropper" style="background-image:url(assets/img/cbd-oil.jpg);">
                <div class="video">
                    <a data-fancybox="" href="https://www.youtube.com/watch?v=xKxrkht7CpY">
                        <i>
                            <svg width="11" height="17" viewBox="0 0 11 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                            </svg>
                        </i>
                    </a>
                    <img src="https://via.placeholder.com/470x470" alt="img">
                </div>
                <div class="cbd-oil-dropper-text">
                    <div class="heading two">
                        <h6>monthly subscribtion offer</h6>
                        <h2>Subscribe monthly save 20%</h2>
                    </div>
                    <p>Lorem ipsum dolor sit amet, con tetur adipiscing elit sit amet, con tetur adipiscing elit</p>
                    <h6><i class="fa-regular fa-heart"></i>Save 20% Every Month</h6>
                    <h6><i><svg enable-background="new 0 0 32 32" viewBox="0 0 32 32"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m7.6601562 29c0 .5527344.4477539 1 1 1h16.3896484c1.9023438 0 3.4501954-1.5478516 3.4501954-3.4501953v-16.5698242c0-.5522461-.4477539-1-1-1s-1 .4477539-1 1v16.5698242c0 .7998047-.6503906 1.4501953-1.4501953 1.4501953h-16.3896485c-.552246 0-1 .4472656-1 1z" />
                                <path
                                    d="m12.9301758 15h-2.1704102c-.5522461 0-1 .4477539-1 1s.4477539 1 1 1h2.1704102c.5522461 0 1-.4477539 1-1s-.4477539-1-1-1z" />
                                <path
                                    d="m21.2402344 22.2402344c.5522461 0 1-.4472656 1-1s-.4477539-1-1-1h-4.8203125c-.5522461 0-1 .4472656-1 1s.4477539 1 1 1z" />
                                <path
                                    d="m16 9.7573242h-5.2426758c-.5522461 0-1 .4477539-1 1s.4477539 1 1 1h5.2426758c.5522461 0 1-.4477539 1-1s-.4477539-1-1-1z" />
                                <path
                                    d="m28.2929688 2.2929688-3.6845703 3.6845703-4.074707-3.7163086c-.1844254-.1754253-.4317609-.2334636-.6738282-.2612305h-12.909668c-1.9023437 0-3.4501953 1.5478516-3.4501953 3.4501953 0 0 .0180054 21.4289551.0424194 21.5933228l-1.2494507 1.2494507c-.390625.390625-.390625 1.0234375 0 1.4140625.1953125.1953125.4511719.2929687.7070313.2929687s.5117188-.0976562.7070312-.2929688l26-26c.390625-.390625.390625-1.0234375 0-1.4140625s-1.0234374-.3906249-1.4140624.0000001zm-6.5579224 6.5579223c-.5153809-.2249756-.8751831-.7234497-.8751831-1.3108521v-2.274414l2.3328857 2.1275635zm-16.2350464-3.4006958c0-.7998047.6503906-1.4501953 1.4501953-1.4501953h11.909668v3.5400391c0 1.1326294.5541382 2.1420898 1.4133911 2.772644l-14.7732544 14.7732544z" />
                            </svg></i>Cancel or Skip a month anytime</h6>
                    <h6><i>
                            <svg height="512" viewBox="0 0 48 48" width="512" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m41.211 37.288a4.112 4.112 0 1 1 4.109-4.112 4.114 4.114 0 0 1 -4.109 4.112zm0-6.724a2.612 2.612 0 1 0 2.609 2.612 2.613 2.613 0 0 0 -2.609-2.612z">
                                </path>
                                <path
                                    d="m19.542 37.288a4.112 4.112 0 1 1 4.108-4.112 4.115 4.115 0 0 1 -4.108 4.112zm0-6.724a2.612 2.612 0 1 0 2.608 2.612 2.614 2.614 0 0 0 -2.608-2.612z">
                                </path>
                                <path
                                    d="m46.621 33.926h-2.051a.75.75 0 0 1 0-1.5h1.839v-3.977a3.16 3.16 0 0 0 -.4-1.536l-4.06-7.279a.4.4 0 0 0 -.349-.205h-5.533v13h1.786a.75.75 0 0 1 0 1.5h-2.536a.75.75 0 0 1 -.75-.75v-14.5a.75.75 0 0 1 .75-.75h6.283a1.9 1.9 0 0 1 1.66.974l4.059 7.28a4.662 4.662 0 0 1 .589 2.266v4.19a1.289 1.289 0 0 1 -1.287 1.287z">
                                </path>
                                <path
                                    d="m16.183 33.926h-7.191a.75.75 0 0 1 -.75-.75v-5.768a.75.75 0 0 1 1.5 0v5.018h6.441a.75.75 0 0 1 0 1.5z">
                                </path>
                                <path
                                    d="m8.992 24.747a.75.75 0 0 1 -.75-.75v-5.036a.75.75 0 0 1 1.5 0v5.039a.75.75 0 0 1 -.75.747z">
                                </path>
                                <path
                                    d="m35.317 33.926h-12.417a.75.75 0 0 1 0-1.5h11.667v-19.621h-24.825v3.089a.75.75 0 0 1 -1.5 0v-3.227a1.364 1.364 0 0 1 1.363-1.362h25.1a1.364 1.364 0 0 1 1.362 1.362v20.509a.75.75 0 0 1 -.75.75z">
                                </path>
                                <path d="m11.957 28.158h-9.519a.75.75 0 0 1 0-1.5h9.519a.75.75 0 0 1 0 1.5z"></path>
                                <path d="m19.542 24.747h-13.283a.75.75 0 0 1 0-1.5h13.283a.75.75 0 0 1 0 1.5z"></path>
                                <path d="m5.846 20.787h-5.187a.75.75 0 1 1 0-1.5h5.187a.75.75 0 0 1 0 1.5z"></path>
                                <path d="m14.163 16.644h-9.156a.75.75 0 1 1 0-1.5h9.156a.75.75 0 0 1 0 1.5z"></path>
                            </svg>
                        </i>Free delivery every month</h6>
                    <img src="assets/img/dots-1.png" alt="img" class="dots">
                </div>
            </div> -->
        </div>
        <!-- <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-two"> -->
        <img src="assets/img/dots.png" alt="icon" class="dots">
        <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-three">
        <img src="assets/img/rasi/cotton-img.png" alt="img" class="extra-images-for">
    </section>
    <section class="gap">
        <div class="container">
            <div class="heading">
                <img src="assets/img/heading-img.png" alt="img">
                <h6>DELIGHTFULLY REFRESHING </h6>
                <h2>Schemes</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="sustainability">
                        <i>
                            <svg height="682pt" viewBox="-21 -21 682 682.66639" width="682pt"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m630.203125 74.589844c-9.246094-29.078125-21.777344-49.898438-22.308594-50.773438-2.054687-3.386718-6.285156-5.148437-10.117187-4.269531-.992188.226563-24.65625 5.75-51.953125 19.382813-36.851563 18.398437-62.59375 42.960937-74.453125 71.019531-9.871094 23.367187-11.289063 51.933593-4.285156 83.492187-14.917969-16.660156-31.699219-31.234375-49.992188-43.503906-5.585938-11.035156-20.355469-38.203125-43.445312-66.597656-7.605469-9.347656-22.234376 2.382812-14.550782 11.824218 15.558594 19.136719 27.269532 37.957032 34.59375 50.886719l-85.402344-16.648437-81.140624-110.675782c7.878906.109376 15.785156.871094 23.652343 2.414063 24.941407 4.882813 49.578125 17.585937 73.238281 37.75 9.269532 7.902344 21.308594-6.480469 12.160157-14.273437-26.136719-22.273438-53.65625-36.367188-81.796875-41.878907-42.957032-8.40625-93.058594 2.628907-144.902344 31.925781-38.640625 21.835938-64.480469 45.820313-65.558594 46.828126-3.457031 3.230468-4.007812 9.097656-1.113281 12.871093 3.789063 7.773438 18.148437 35.816407 42.050781 66.007813 14.089844 17.800781 28.949219 33.035156 44.320313 45.554687-4.367188 3.660157-8.617188 7.488281-12.730469 11.515625-21.96875 21.488282-38.789062 46.835938-49.832031 74.546875-9.761719 24.484375-15.011719 50.824219-15.304688 77.972657-.484375 44.394531 12.378907 87.210937 37.207031 123.828124 24.253907 35.765626 58.160157 63.226563 98.050782 79.410157 11.164062 4.519531 18.222656-12.84375 7.050781-17.375-14.453125-5.863281-28.03125-13.375-40.554687-22.308594 1.601562-8.882813 5.316406-40.851563-15.917969-73.945313-2.972657-4.628906 5.914062-22.808593 11.21875-33.667968 5.476562-11.191406 11.128906-22.761719 13.769531-33.65625 2.804688-11.574219-.351562-21.289063-9.121094-28.105469-6.4375-5.003906-14.863281-7.59375-22.289062-9.878906-4.824219-1.484375-10.292969-3.164063-12.246094-4.792969-4.023438-3.371094-10.59375-15.828125-15.875-25.832031-5.859375-11.097657-11.4375-21.660157-17.132812-28.164063 12.816406-30.4375 33.402343-57.371094 59.183593-77.976562 23.550781 16.042968 50.429688 27.113281 79 29.355468-33.132812 25.671876-43.851562 58.457032-28.53125 89.949219 17.890625 36.773438 54.714844 30.898438 87.203125 25.722657 5.621094-.898438 11.4375-1.824219 17.007813-2.519532 2.089843-.261718 2.71875.308594 3.140625.679688 7.113281 6.328125 6.902344 36.550781 6.75 58.621094-.207032 30.527343-.402344 59.363281 10.96875 74.167968 5.800781 7.546875 13.96875 11.40625 23.542968 11.40625 5.738282 0 11.972657-1.382812 18.511719-4.1875 28.277344-12.109375 57.671875-48.554687 53.1875-77.390625-3.917969-25.210937-6.511719-41.867187-.398437-55.292969 5.652344-12.425781 19.316406-23.929687 46.226562-38.609374 3.222656 14.511718 4.847656 29.609374 4.679688 45.097656-.574219 52.867187-21.707032 102.347656-59.5 139.320312-42.238282 41.320313-101.601563 61.726563-160.324219 55.253906-11.964844-1.296874-14.03125 17.320313-2.050781 18.640626 64.277344 7.078124 129.265625-15.265626 175.484375-60.488282 41.378906-40.480468 64.511719-94.644531 65.140625-152.527344.835937-76.746093-38.542969-144.738281-98.488282-183.90625 12.386719-8.832031 21.613282-16.46875 26.730469-20.902343 21.855469 15.679687 41.242188 34.996093 57.371094 57.5 38.71875 54.035156 54.074219 119.90625 43.246094 185.492187-22.363281 135.386719-150.695313 227.351563-286.105469 204.980469-65.589844-10.832031-123.03125-46.550781-161.75-100.585937-38.722656-54.03125-54.078125-119.910157-43.246094-185.492188 1.945313-11.800781-16.542968-14.898438-18.496094-3.054688-11.652343 70.527344 4.867188 141.367188 46.496094 199.472657 41.636719 58.097656 103.414063 96.511719 173.941406 108.164062 14.75 2.433594 29.515626 3.636719 44.179688 3.636719 55.429688 0 109.351562-17.210938 155.300781-50.136719 58.113281-41.636719 96.53125-103.402343 108.175781-173.929687 8.535157-51.679688 1.929688-103.527344-18.585937-150.410156 9.46875-2.792969 25.582031-8.214844 43.230469-17.027344 36.84375-18.398438 62.589844-42.960938 74.445312-71.019532 11.867188-28.066406 11.535156-63.644531-.957031-102.886718zm-544.164063 257.796875c6.976563 13.226562 13.574219 25.726562 20.429688 31.460937 4.855469 4.058594 11.613281 6.136719 18.765625 8.335938 18.324219 5.632812 20.453125 8.398437 18.695313 15.644531-2.15625 8.910156-7.359376 19.550781-12.386719 29.835937-9.683594 19.8125-18.828125 38.515626-10.160157 52.03125 12.292969 19.15625 14.398438 38.015626 14.1875 49.746094-55.84375-50.355468-78.582031-129.890625-57.78125-202.179687 2.757813 4.726562 5.65625 10.21875 8.25 15.125zm453.613282-184.246094-26.644532-64.570313c12.964844-12.125 28.007813-21.25 40.820313-27.675781 10.914063-5.476562 21.296875-9.570312 29.625-12.472656zm61.085937-97.449219c3.722657 8 8.039063 18.316406 11.726563 29.976563 4.042968 12.796875 7.753906 28.65625 8.492187 45.199219l-62.441406 25.761718zm-112.097656 66.558594c2.765625-6.539062 6.339844-12.601562 10.46875-18.199219l30.332031 73.496094-27.21875 65.085937c-3.824218-8.113281-8.328125-18.769531-12.148437-30.875-7.667969-24.238281-14.136719-59.449218-1.433594-89.507812zm60.066406 114.28125c-10.503906 5.273438-20.527343 9.265625-28.691406 12.144531l28.246094-67.527343 71.898437-29.667969c-1.042968 8.054687-3.03125 16.039062-6.269531 23.695312-12.699219 30.058594-42.457031 49.960938-65.183594 61.355469zm-338.074219-5.335938c-3.3125-.648437-6.582031-1.441406-9.804687-2.34375l103.765625-76.0625 85.441406 16.652344c-31.125 24.523438-106.871094 75.964844-179.402344 61.753906zm-94.832031-58.660156c-22.191406-23.917968-38.457031-49.492187-47.796875-65.867187l108.730469 21.199219zm19.203125-125.089844 45.492188 62.050782-109.433594-21.332032c13.777344-10.878906 36.519531-27.210937 63.941406-40.71875zm72.617188 67.339844-55.152344-75.230468c16.511719-6.785157 34.234375-12.125 52.402344-14.5l76.296875 104.0625zm-5.835938 17.964844 77.761719 15.15625-99.800781 73.152344c-18.820313-8.691406-35.757813-21.1875-50.578125-35.078125zm254.40625 183.085938c-33.800781 18.007812-50.351562 32.152343-58.203125 49.40625-8.433593 18.527343-5.34375 38.414062-1.066406 65.9375 2.527344 16.230468-16.761719 46.453124-42.035156 57.277343-9.351563 4.003907-16.011719 3.53125-19.804688-1.410156-7.449219-9.695313-7.246093-39.039063-7.085937-62.613281.222656-32.617188.417968-60.785156-13.039063-72.757813-4.839843-4.304687-11.03125-6.125-17.910156-5.28125-5.894531.734375-11.875 1.6875-17.652344 2.609375-34.464843 5.492188-56.152343 7.691406-67.386719-15.40625-18.203124-37.410156 18.644532-65.121094 35.332032-75.296875 3.398437-2.070312 6.550781-4.511719 9.480468-7.230469 40.332032-4.820312 78.441407-22.125 112.402344-43.800781 40.71875 24.328125 71.976563 62.828125 86.96875 108.566407zm0 0" />
                            </svg>
                        </i>
                        <h5><a >Advance Booking Scheme</a></h5>
                        <p>Sed ut perspiciatis unde omnis is tus error sit ut perspiciatis und li rspiciat voluptatem
                        </p>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 88 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 86 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <path
                                        d="M 74.373 60.627 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 L 85.172 45 L 72.959 32.788 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.781 -0.781 2.047 -0.781 2.828 0 l 13.627 13.626 C 89.789 43.961 90 44.47 90 45 s -0.211 1.039 -0.586 1.414 L 75.787 60.041 C 75.396 60.432 74.885 60.627 74.373 60.627 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sustainability">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="512" height="512">
                                <g id="Layer_41" data-name="Layer 41">
                                    <path
                                        d="M59,56H54.55A28.031,28.031,0,0,0,62,37a27.723,27.723,0,0,0-2.47-11.49,6.98,6.98,0,0,0-5.23-9.38l.78-2.88a1.055,1.055,0,0,0-.1-.76,1.026,1.026,0,0,0-.61-.47l-2.9-.77.52-1.93s2.1.55,2.19.55a.993.993,0,0,0,.5-.14,1.006,1.006,0,0,0,.47-.6l1.03-3.87a.994.994,0,0,0-.71-1.22L45.81,1.45a.988.988,0,0,0-.75.1,1,1,0,0,0-.47.61L43.55,6.02a1,1,0,0,0,.71,1.22l1.93.52-.51,1.93-2.9-.78a1.055,1.055,0,0,0-.76.1,1.026,1.026,0,0,0-.47.61L36.37,28.94a1.017,1.017,0,0,0,.71,1.23l.97.26-.78,2.89a1.055,1.055,0,0,0,.1.76,1.026,1.026,0,0,0,.61.47l.97.26-.78,2.9a.994.994,0,0,0,.71,1.22S42.91,40,43,40a1.094,1.094,0,0,0,.5-.13,1.026,1.026,0,0,0,.47-.61l.77-2.9s1.14.29,1.23.29a.991.991,0,0,0,.96-.74l.78-2.89s1.13.29,1.22.29a1,1,0,0,0,.97-.74l.79-2.97a6.755,6.755,0,0,0,2.01.38,19.844,19.844,0,0,1-4.76,21.34A6.977,6.977,0,0,0,42,48a6.634,6.634,0,0,0-1,.08V47h7a1,1,0,0,0,1-1V43a1,1,0,0,0-1-1H28a1,1,0,0,0-1,1v3a1,1,0,0,0,1,1h7v9H25a3.009,3.009,0,0,0-3,3v2a1,1,0,0,0,1,1H61a1,1,0,0,0,1-1V59A3.009,3.009,0,0,0,59,56ZM45.75,5.57l.51-1.93,7.73,2.07-.52,1.93ZM50.06,8.8l-.52,1.93-1.93-.52.52-1.93ZM42.29,37.78l-1.93-.52.52-1.93,1.93.51Zm2.97-3.35-5.8-1.55.52-1.94,5.8,1.56Zm2.96-3.35-9.66-2.59L43.23,11.1l9.65,2.6-.63,2.34a6.987,6.987,0,0,0-3.37,12.6ZM53,28a5,5,0,1,1,5-5A5,5,0,0,1,53,28Zm3,9a21.851,21.851,0,0,0-1.25-7.23,7.054,7.054,0,0,0,3.5-2.15A25.651,25.651,0,0,1,60,37a26.042,26.042,0,0,1-8.27,19H49V55a6.989,6.989,0,0,0-.22-1.72A21.99,21.99,0,0,0,56,37ZM42,50a5,5,0,0,1,5,5v1H37V55A5,5,0,0,1,42,50Zm-5,.11V47h2v1.69A6.743,6.743,0,0,0,37,50.11ZM29,45V44H47v1ZM60,60H24V59a1,1,0,0,1,1-1H59a1,1,0,0,1,1,1Z" />
                                    <path
                                        d="M21,27a1,1,0,0,0-1-1H19V23.91a5.964,5.964,0,0,0,2.471-1.025l1.479,1.479-.707.707a1,1,0,1,0,1.414,1.414l2.828-2.828a1,1,0,0,0-1.414-1.414l-.707.707-1.479-1.479A5.964,5.964,0,0,0,23.91,19H26v1a1,1,0,0,0,2,0V16a1,1,0,0,0-2,0v1H23.91a5.964,5.964,0,0,0-1.025-2.471l1.479-1.479.707.707a1,1,0,0,0,1.414-1.414L23.657,9.515a1,1,0,0,0-1.414,1.414l.707.707-1.479,1.479A5.964,5.964,0,0,0,19,12.09V10h1a1,1,0,0,0,0-2H16a1,1,0,0,0,0,2h1v2.09a5.964,5.964,0,0,0-2.471,1.025L13.05,11.636l.707-.707a1,1,0,0,0-1.414-1.414L9.515,12.343a1,1,0,1,0,1.414,1.414l.707-.707,1.479,1.479A5.964,5.964,0,0,0,12.09,17H10V16a1,1,0,0,0-2,0v4a1,1,0,0,0,2,0V19h2.09a5.964,5.964,0,0,0,1.025,2.471L11.636,22.95l-.707-.707a1,1,0,0,0-1.414,1.414l2.828,2.828a1,1,0,0,0,1.414-1.414l-.707-.707,1.479-1.479A5.964,5.964,0,0,0,17,23.91V26H16a1,1,0,0,0,0,2h4A1,1,0,0,0,21,27Zm-7-9a4,4,0,1,1,4,4A4,4,0,0,1,14,18Z" />
                                    <path
                                        d="M25.516,32.117l7.236,1.852a1,1,0,0,0,1.217-1.217l-1.852-7.236a16.02,16.02,0,1,0-6.6,6.6ZM4,18a14,14,0,1,1,26.181,6.885,1,1,0,0,0-.1.743l1.531,5.985-5.984-1.532a1,1,0,0,0-.742.1A13.988,13.988,0,0,1,4,18Z" />
                                    <path
                                        d="M22,37a1,1,0,0,0-1-1H9a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1h1V57a5,5,0,0,0,10,0V42h1a1,1,0,0,0,1-1ZM15,60a3,3,0,0,1-3-3V56h2a1,1,0,0,0,0-2H12V52h2a1,1,0,0,0,0-2H12V48h6v9A3,3,0,0,1,15,60Zm3-14H12V42h6Zm2-6H10V38H20Z" />
                                    <path
                                        d="M50,23a3,3,0,1,0,3-3A3,3,0,0,0,50,23Zm4,0a1,1,0,1,1-1-1A1,1,0,0,1,54,23Z" />
                                </g>
                            </svg>
                        </i>
                        <h5><a href="#">Rasi Subha Labh (RSL)</a></h5>
                        <p>Sed ut perspiciatis unde omnis is tus error sit ut perspiciatis und li rspiciat voluptatem
                        </p>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 88 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 86 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <path
                                        d="M 74.373 60.627 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 L 85.172 45 L 72.959 32.788 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.781 -0.781 2.047 -0.781 2.828 0 l 13.627 13.626 C 89.789 43.961 90 44.47 90 45 s -0.211 1.039 -0.586 1.414 L 75.787 60.041 C 75.396 60.432 74.885 60.627 74.373 60.627 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sustainability">
                        <i>
                            <svg version="1.1" xml:space="preserve" width="682.66669" height="682.66669"
                                viewBox="0 0 682.66669 682.66669" xmlns="http://www.w3.org/2000/svg">
                                <defs id="defs3541">
                                    <clipPath clipPathUnits="userSpaceOnUse" id="clipPath3555">
                                        <path d="M 0,512 H 512 V 0 H 0 Z" id="path3553" />
                                    </clipPath>
                                </defs>
                                <g transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)">
                                    <g transform="translate(300.2339,365.1328)">
                                        <path d="M 0,0 -0.085,-34.397"
                                            style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" />
                                    </g>
                                    <g>
                                        <g  clip-path="url(#clipPath3555)">
                                            <g id="g3557" transform="translate(325.4331,188.8359)">
                                                <path
                                                    d="m 0,0 c 16.781,2.836 29.678,17.524 29.678,35.106 0,19.567 -16.015,35.588 -35.29,35.588 h -38.919 c -19.559,0 -35.574,16.023 -35.574,35.618 0,19.566 16.015,35.587 35.574,35.587 h 74.209"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3559" />
                                            </g>
                                            <g id="g3561" transform="translate(89.1699,73.6211)">
                                                <path
                                                    d="m 0,0 78.15,-35.05 c 18.538,-6.805 46.005,-7.174 111.881,-7.514 53.177,-0.057 60.122,-0.057 70.213,-0.057 24.632,0 34.298,2.297 45.892,13.753 32.456,30.002 64.912,59.975 97.397,89.977 12.387,11.428 12.387,30.172 0,41.6 -12.387,11.457 -32.683,11.457 -45.071,0 L 290.234,39.7 c -5.641,-5.218 -17.206,-6.692 -29.877,-6.664 -31.265,0.085 -81.579,0.17 -112.845,0.227 -13.35,0 -24.264,10.066 -24.264,22.402 0,12.335 10.914,22.431 24.264,22.431 h 64.657 c 15.052,0 27.326,11.342 27.326,25.237 0,13.867 -12.274,25.238 -27.326,25.238 H 53.404 C 31.521,128.571 12.047,118.447 0,102.993"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3563" />
                                            </g>
                                            <g id="g3565" transform="translate(89.1699,57.8262)">
                                                <path
                                                    d="m 0,0 v 134.555 c 0,13.1 -11.593,23.848 -25.794,23.848 h -27.581 c -14.202,0 -25.795,-10.748 -25.795,-23.848 V 0 c 0,-13.102 11.593,-23.82 25.795,-23.82 h 27.581 C -11.593,-23.82 0,-13.102 0,0 Z"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3567" />
                                            </g>
                                            <g id="g3569" transform="translate(409.7056,395.1064)">
                                                <path d="M 0,0 0.028,-0.028"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3571" />
                                            </g>
                                            <g id="g3573" transform="translate(149.292,303.5693)">
                                                <path
                                                    d="m 0,0 c -19.786,11.825 -35.886,31.816 -48.302,54.956 -12.5,23.31 -19.275,47.924 -19.076,71.148 0.085,10.293 2.409,11.428 10.941,16.022 L 8.985,177.431 74.408,142.126 C 82.94,137.532 85.236,136.397 85.321,126.104 85.548,102.88 78.745,78.266 66.244,54.956 53.829,31.816 37.756,11.825 17.971,0 10.034,-4.736 7.908,-4.736 0,0 Z"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3575" />
                                            </g>
                                            <g id="g3577" transform="translate(135.7993,201.8516)">
                                                <path
                                                    d="m 0,0 c -6.321,18.063 -9.779,37.46 -9.779,57.679 0,19.113 3.061,37.488 8.758,54.673 m 305.938,48.405 C 326.12,131.89 338.62,96.245 338.62,57.679 338.62,29.832 332.072,3.488 320.45,-19.85 M 98.587,219.06 c 20.296,8.308 42.547,12.902 65.848,12.902 25.142,0 49.066,-5.331 70.666,-14.944"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3579" />
                                            </g>
                                            <g id="g3581" transform="translate(136.6777,392.9229)">
                                                <path d="M 0,0 17.178,-16.079 52.78,20.445"
                                                    style="fill:none;stroke:#000000;stroke-width:20.176;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    id="path3583" />
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </i>
                        <h5><a href="#">Volume Discount</a></h5>
                        <p>Sed ut perspiciatis unde omnis is tus error sit ut perspiciatis und li rspiciat voluptatem
                        </p>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 88 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 86 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <path
                                        d="M 74.373 60.627 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 L 85.172 45 L 72.959 32.788 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.781 -0.781 2.047 -0.781 2.828 0 l 13.627 13.626 C 89.789 43.961 90 44.47 90 45 s -0.211 1.039 -0.586 1.414 L 75.787 60.041 C 75.396 60.432 74.885 60.627 74.373 60.627 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sustainability mb-lg-0">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" id="icons" viewBox="0 0 60 60" width="512"
                                height="512">
                                <path
                                    d="M14,13H28a3,3,0,0,0,0-6H14a3,3,0,0,0,0,6Zm0-4H28a1,1,0,0,1,0,2H14a1,1,0,0,1,0-2Z" />
                                <path
                                    d="M59.139,33.449a4.209,4.209,0,0,0-1.631-3.936,2.2,2.2,0,0,1-.806-1.207A4.211,4.211,0,0,0,53.69,25.3a2.218,2.218,0,0,1-1.2-.806,4.191,4.191,0,0,0-3.938-1.631,2.231,2.231,0,0,1-1.424-.285,4.217,4.217,0,0,0-4.255,0,2.2,2.2,0,0,1-.87.281V8.41A1.977,1.977,0,0,0,41.417,7L35,.583A1.977,1.977,0,0,0,33.59,0H3A3,3,0,0,0,0,3V53a3,3,0,0,0,3,3H32.585a2.241,2.241,0,0,0,2.235,1.861h2.616l1.472,1.474A2.319,2.319,0,0,0,40.532,60a2.4,2.4,0,0,0,.429-.04,2.3,2.3,0,0,0,1.67-1.315L45,53.422l2.367,5.217a2.3,2.3,0,0,0,1.672,1.321,2.337,2.337,0,0,0,2.058-.631l1.467-1.468H55.18a2.29,2.29,0,0,0,2.106-3.19l-2.749-6.3A4.2,4.2,0,0,0,56.7,45.69a2.218,2.218,0,0,1,.806-1.2,4.212,4.212,0,0,0,1.631-3.938,2.263,2.263,0,0,1,.284-1.425h0a4.212,4.212,0,0,0,0-4.255A2.221,2.221,0,0,1,59.139,33.449ZM35,3.413,38.589,7H36a1,1,0,0,1-1-1ZM33.006,54H3a1,1,0,0,1-1-1V3A1,1,0,0,1,3,2L33,2V6a3,3,0,0,0,3,3h4V22.921a4.207,4.207,0,0,0-2.487,1.571,2.2,2.2,0,0,1-1.207.806A4.211,4.211,0,0,0,33.3,28.31a2.218,2.218,0,0,1-.806,1.2,4.212,4.212,0,0,0-1.631,3.938,2.215,2.215,0,0,1-.285,1.424,4.212,4.212,0,0,0,0,4.255,2.221,2.221,0,0,1,.281,1.421,4.209,4.209,0,0,0,1.631,3.936,2.2,2.2,0,0,1,.806,1.207A4.2,4.2,0,0,0,35.46,48.37Zm7.8,3.824a.288.288,0,0,1-.217.17.305.305,0,0,1-.273-.079l-1.508-1.509a1.871,1.871,0,0,0-1.319-.545H34.82a.289.289,0,0,1-.244-.132.269.269,0,0,1-.029-.258l2.719-6.238a2.154,2.154,0,0,1,.247.275,4.189,4.189,0,0,0,3.938,1.631,2.219,2.219,0,0,1,1.424.285,4.257,4.257,0,0,0,.692.315Zm14.642-2.362a.274.274,0,0,1-.025.267.289.289,0,0,1-.244.132H52.51a1.87,1.87,0,0,0-1.317.543l-1.5,1.5a.308.308,0,0,1-.278.085.289.289,0,0,1-.219-.176l-2.758-6.08a4.238,4.238,0,0,0,.7-.318,2.239,2.239,0,0,1,1.421-.281,4.2,4.2,0,0,0,3.936-1.631,2.19,2.19,0,0,1,.245-.273ZM57.7,38.113l0,.009a4.232,4.232,0,0,0-.535,2.7,2.211,2.211,0,0,1-.856,2.065,4.229,4.229,0,0,0-1.536,2.3,2.213,2.213,0,0,1-1.58,1.579,4.207,4.207,0,0,0-2.3,1.535,2.235,2.235,0,0,1-2.065.855,4.241,4.241,0,0,0-2.713.539,2.2,2.2,0,0,1-2.235,0,4.226,4.226,0,0,0-2.13-.575,4.274,4.274,0,0,0-.575.04,2.226,2.226,0,0,1-2.065-.856,4.229,4.229,0,0,0-2.3-1.536,2.213,2.213,0,0,1-1.579-1.58,4.207,4.207,0,0,0-1.535-2.3,2.208,2.208,0,0,1-.855-2.065,4.24,4.24,0,0,0-.539-2.713,2.2,2.2,0,0,1,0-2.235,4.232,4.232,0,0,0,.535-2.7,2.211,2.211,0,0,1,.856-2.065,4.229,4.229,0,0,0,1.536-2.3,2.213,2.213,0,0,1,1.58-1.579,4.207,4.207,0,0,0,2.3-1.535,2.233,2.233,0,0,1,2.065-.855,4.249,4.249,0,0,0,2.713-.539,2.2,2.2,0,0,1,2.235,0,4.225,4.225,0,0,0,2.7.535,2.221,2.221,0,0,1,2.065.856,4.229,4.229,0,0,0,2.3,1.536,2.213,2.213,0,0,1,1.579,1.58,4.207,4.207,0,0,0,1.535,2.3,2.208,2.208,0,0,1,.855,2.065,4.24,4.24,0,0,0,.539,2.713A2.2,2.2,0,0,1,57.7,38.113Z" />
                                <path
                                    d="M45,27A10,10,0,1,0,55,37,10.011,10.011,0,0,0,45,27Zm0,18a8,8,0,1,1,8-8A8.009,8.009,0,0,1,45,45Z" />
                                <path d="M7,19H35a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z" />
                                <path d="M7,24H33a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z" />
                                <path d="M29,27H22a1,1,0,0,0,0,2h7a1,1,0,0,0,0-2Z" />
                                <path d="M7,29H18a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z" />
                                <path d="M13,33a1,1,0,0,0,1,1H27a1,1,0,0,0,0-2H14A1,1,0,0,0,13,33Z" />
                                <path d="M7,34h3a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z" />
                                <path d="M7,39H27a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z" />
                                <path d="M28,42H7a1,1,0,0,0,0,2H28a1,1,0,0,0,0-2Z" />
                                <path d="M18,47H7a1,1,0,0,0,0,2H18a1,1,0,0,0,0-2Z" />
                                <path
                                    d="M47.293,34.293,43,38.586l-.293-.293a1,1,0,0,0-1.414,1.414l1,1a1,1,0,0,0,1.414,0l5-5a1,1,0,0,0-1.414-1.414Z" />
                            </svg>
                        </i>
                        <h5><a href="#">Distributor Tour</a></h5>
                        <p>Sed ut perspiciatis unde omnis is tus error sit ut perspiciatis und li rspiciat voluptatem
                        </p>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 88 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 86 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <path
                                        d="M 74.373 60.627 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 L 85.172 45 L 72.959 32.788 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.781 -0.781 2.047 -0.781 2.828 0 l 13.627 13.626 C 89.789 43.961 90 44.47 90 45 s -0.211 1.039 -0.586 1.414 L 75.787 60.041 C 75.396 60.432 74.885 60.627 74.373 60.627 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg></a>
                    </div>
                </div>
               <!--  <div class="col-lg-4 col-md-6">
                    <div class="sustainability mb-lg-0">
                        <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512" height="512">
                                <g>
                                    <path
                                        d="M296,88a198.449,198.449,0,0,0-128,46.317V130a18.021,18.021,0,0,0-18-18h-.234l-4.74-14.219A19.974,19.974,0,0,1,144,91.456V56a40,40,0,0,0-80,0V91.456a19.974,19.974,0,0,1-1.026,6.325L58.234,112H58a18.021,18.021,0,0,0-18,18v46a8,8,0,0,0-8,8v32a8,8,0,0,0,8,8h8v8a8.039,8.039,0,0,1-3.2,6.4L32,248a40.191,40.191,0,0,0-16,32V462a34.038,34.038,0,0,0,34,34H158a34.038,34.038,0,0,0,34-34v-3.132A198.542,198.542,0,0,0,296,488c110.28,0,200-89.72,200-200S406.28,88,296,88ZM78.152,102.84A35.925,35.925,0,0,0,80,91.456V56a24,24,0,0,1,48,0V91.456a35.925,35.925,0,0,0,1.848,11.384L132.9,112H75.1ZM56,130a2,2,0,0,1,2-2h92a2,2,0,0,1,2,2v46H136V144H120v32h-8V144H96v32H88V144H72v32H56Zm-8,62H160v16H48ZM176,462a18.021,18.021,0,0,1-18,18H50a18.021,18.021,0,0,1-18-18V424H176Zm0-54H32V312H176Zm0-112H32V280H56a8,8,0,0,0,0-16H38.132a23.745,23.745,0,0,1,3.468-3.2l12.8-9.6A24.116,24.116,0,0,0,64,232v-8h80v8a24.116,24.116,0,0,0,9.6,19.2l12.8,9.6A24.116,24.116,0,0,1,176,280ZM296,472a182.653,182.653,0,0,1-104-32.193V350.328a175.226,175.226,0,0,0,44.707,9.238,97.76,97.76,0,0,0-25.457,31.921l-2.467,4.935a8,8,0,0,0,8.471,11.469l15.057-2.51a98,98,0,0,0,59.154-33.916l4.474-5.369V432a8,8,0,0,0,16,0V366.023l4.535,5.442a98.007,98.007,0,0,0,59.153,33.916l15.058,2.51a8,8,0,0,0,8.471-11.469l-2.468-4.935a97.774,97.774,0,0,0-25.451-31.917,174.887,174.887,0,0,0,58.244-14.585l21.768-9.674a8,8,0,0,0-.95-14.974l-7.711-2.313a175.628,175.628,0,0,0-79.315-4.88A241.745,241.745,0,0,0,416.5,226.3l7.051-20.067a8,8,0,0,0-11.563-9.572l-2.419,1.4a241.4,241.4,0,0,0-74.018,66.645,222.778,222.778,0,0,0-24.513-116.4A7.917,7.917,0,0,0,303.873,144a8,8,0,0,0-7.089,4.422,231.767,231.767,0,0,0-24.012,116.809,241.347,241.347,0,0,0-74.4-67.172l-2.418-1.4a8,8,0,0,0-11.563,9.572l7.051,20.067a241.751,241.751,0,0,0,53.177,86.8A174.585,174.585,0,0,0,192,312.261V280a40.191,40.191,0,0,0-16-32l-12.8-9.6A8.039,8.039,0,0,1,160,232v-8h8a8,8,0,0,0,8-8V184a8,8,0,0,0-8-8V155.833A182.709,182.709,0,0,1,296,104c101.458,0,184,82.542,184,184S397.458,472,296,472ZM279.21,323.067A225.763,225.763,0,0,1,207.127,222.65a225.4,225.4,0,0,1,72,83.836,8,8,0,0,0,14.946-5.4,215.811,215.811,0,0,1,10-129.945,209.544,209.544,0,0,1,10.014,129.477,8,8,0,0,0,14.932,5.447,225.445,225.445,0,0,1,71.791-83.413,225.8,225.8,0,0,1-72.083,100.416,8,8,0,0,0,7.791,13.752,159.817,159.817,0,0,1,87.578-6.951l-1.115.5a158.931,158.931,0,0,1-81.443,12.764,8,8,0,0,0-3.667,15.444,81.7,81.7,0,0,1,39.089,30.8,82.007,82.007,0,0,1-48.2-28.151L313.6,343.028l-3.563-4.2a8,8,0,0,0-6.1-2.826H303.9a8,8,0,0,0-6.112,2.878l-18.62,22.344a82,82,0,0,1-48.2,28.151,81.7,81.7,0,0,1,39.089-30.8,8,8,0,0,0-3.667-15.444,159.156,159.156,0,0,1-74.4-9.837v-4.863a158.688,158.688,0,0,1,79.419,8.391,8,8,0,0,0,7.791-13.752Z" />
                                    <path d="M104,264H88a8,8,0,0,0,0,16h16a8,8,0,0,0,0-16Z" />
                                    <path
                                        d="M104,392a26,26,0,0,0,20.8-41.6l-14.4-19.2a8,8,0,0,0-12.8,0L83.2,350.4A26,26,0,0,0,104,392Zm-8-32,8-10.667L112,360a10,10,0,1,1-16,0Z" />
                                </g>
                            </svg>
                        </i>
                        <h5><a href="#">Direct from our farm</a></h5>
                        <p>Sed ut perspiciatis unde omnis is tus error sit ut perspiciatis und li rspiciat voluptatem
                        </p>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 88 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 86 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                    <path
                                        d="M 74.373 60.627 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 L 85.172 45 L 72.959 32.788 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.781 -0.781 2.047 -0.781 2.828 0 l 13.627 13.626 C 89.789 43.961 90 44.47 90 45 s -0.211 1.039 -0.586 1.414 L 75.787 60.041 C 75.396 60.432 74.885 60.627 74.373 60.627 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sustainability-img mb-0">
                        <figure>
                            <img src="https://via.placeholder.com/416x319" alt="img">
                        </figure>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <section class="gap no-top section-reviews">
        <div class="container">
            <div class="heading two">
                <h6>Testimonials</h6>
                <h2>Clients Reviews</h2>
            </div>
            <div class="row slider-reviews owl-carousel">
                <div class="col-lg-12 item">
                    <div class="clients-reviews">
                        <img src="assets/img/rasi/testimonials/videos/client_img.png" alt="img" style="width: 210px;height: 290px;">
                        <div class="testimonial-video">
                            <a data-fancybox="" href="assets/img/rasi/testimonials/videos/951.mp4">
                                <i>
                                    <svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                                    </svg>
                                </i>
                            </a>
                            <img src="assets/img/rasi/testimonials/videos/video-snap.png" alt="img" width="30" height="30">
                        </div>
                        <div class="clients-reviews-text">
                            <h5>i love rasi seeds products</h5>
                            <p>Lorem ipsum dolor sit amet, con sectetur a dipiscing elit, sed do ei usmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                            <h6>Willimes Jakkline</h6>
                            <ul class="star">
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                            <img src="assets/img/flower-icon.png" alt="img" class="flower-icon">

                        </div>
                    </div>
                </div>
              <!--   <div class="col-lg-12 item">
                    <div class="clients-reviews">
                        <img src="assets/img/rasi/testimonials/videos/client_img.png" alt="img" style="width: 210px;height: 290px;">
                        <div class="testimonial-video">
                            <a data-fancybox="" href="assets/img/rasi/testimonials/videos/951.mp4">
                                <i>
                                    <svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                                    </svg>
                                </i>
                            </a>
                            <img src="assets/img/rasi/testimonials/videos/video-snap.png" alt="img" width="30" height="30">
                        </div>
                        <div class="clients-reviews-text">
                            <h5>i love rasi seeds products</h5>
                            <p>Lorem ipsum dolor sit amet, con sectetur a dipiscing elit, sed do ei usmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                            <h6>Willimes Jakkline</h6>
                            <ul class="star">
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                            <img src="assets/img/flower-icon.png" alt="img" class="flower-icon">

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 item">
                    <div class="clients-reviews">
                        <img src="assets/img/rasi/testimonials/videos/client_img.png" alt="img" style="width: 210px;height: 290px;">
                        <div class="testimonial-video">
                            <a data-fancybox="" href="assets/img/rasi/testimonials/videos/951.mp4">
                                <i>
                                    <svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                                    </svg>
                                </i>
                            </a>
                            <img src="assets/img/rasi/testimonials/videos/video-snap.png" alt="img" width="30" height="30">
                        </div>
                        <div class="clients-reviews-text">
                            <h5>i love rasi seeds products</h5>
                            <p>Lorem ipsum dolor sit amet, con sectetur a dipiscing elit, sed do ei usmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                            <h6>Willimes Jakkline</h6>
                            <ul class="star">
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                            <img src="assets/img/flower-icon.png" alt="img" class="flower-icon">

                        </div>
                    </div>
                </div> -->
             
        </div>
        <img src="assets/img/hero-icon-1.png" alt="icon" class="extra-images-two">
        <img src="assets/img/dots-1.png" alt="icon" class="dots">
    </section> 
    <section class="gap" style="background-color: #e9e9e966;">
        <div class="container">
            <div class="heading">
                <img src="assets/img/heading-img.png" alt="img">
                <h6>Famous Products</h6>
                <h2>Trending Products </h2>
            </div>
            <div class="row trending-slider owl-carousel">
                <div class="col-lg-12 item">
                    <div class="row align-items-center"> 
                        <div class="col-lg-6">
                            <div class="selling-products">
                                <img src="<?php echo $path ?>Pack Shot 287_395.png" alt="img">
                                <div class="video">
                                    <a data-fancybox="" href="https://youtu.be/DlEMAS2Err4?si=ZwJV0vCYenk8x0Z7">
                                        <i>
                                            <svg width="11" height="17" viewBox="0 0 11 17" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                                            </svg>
                                        </i>
                                    </a>
                                    <img src="assets/img/rasi/trend_video_img" alt="img">
                                </div>
                                <!-- <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-two"> -->
                                <!-- <img src="assets/img/dots-1.png" alt="icon" class="dots"> -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="products-text">
                               <!--  <div class="reviews">
                                    <ul>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                    </ul>
                                    <h5>12 Reviews</h5>
                                </div> -->
                                <h3 class="text-start">RCH 947 BGII</h3>
                                <h4 class="text-start"><del class="text-danger">500.00</del>400.00</h4>
                                <ul>
                                    <li><i class="fa-solid fa-check"></i>delivered within 1-3 days.</li>
                                    <li><i class="fa-solid fa-check"></i>Good for the planet, and good for you.</li>
                                </ul>
                                <!-- <a href="#" class="btn">Add to Cart</a>
                                <span>Limited Time Offer:</span>
                                <div id="countdown">
                                    <ul>
                                        <li><span id="days"></span>days</li>
                                        <li><span id="hours"></span>Hour</li>
                                        <li><span id="minutes"></span>Min</li>
                                        <li class="mb-0"><span id="seconds"></span>Sec</li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 item">
                    <div class="row align-items-center"> 
                        <div class="col-lg-6">
                            <div class="selling-products">
                                <img src="<?php echo $path ?>Pack Shot 287_395.png" alt="img">
                                <div class="video">
                                    <a data-fancybox="" href="https://youtu.be/DlEMAS2Err4?si=ZwJV0vCYenk8x0Z7">
                                        <i>
                                            <svg width="11" height="17" viewBox="0 0 11 17" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 8.49951L0.5 0.27227L0.5 16.7268L11 8.49951Z" fill="#000"></path>
                                            </svg>
                                        </i>
                                    </a>
                                    <img src="assets/img/rasi/trend_video_img" alt="img">
                                </div>
                                <!-- <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-two"> -->
                                <!-- <img src="assets/img/dots-1.png" alt="icon" class="dots"> -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="products-text">
                               <!--  <div class="reviews">
                                    <ul>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                    </ul>
                                    <h5>12 Reviews</h5>
                                </div> -->
                                <h3 class="text-start">RCH 947 BGII</h3>
                                <h4 class="text-start">500.00</h4>
                                <ul>
                                    <li><i class="fa-solid fa-check"></i>delivered within 1-3 days.</li>
                                    <li><i class="fa-solid fa-check"></i>Good for the planet, and good for you.</li>
                                </ul>
                                <!-- <a href="#" class="btn">Add to Cart</a>
                                <span>Limited Time Offer:</span>
                                <div id="countdown">
                                    <ul>
                                        <li><span id="days"></span>days</li>
                                        <li><span id="hours"></span>Hour</li>
                                        <li><span id="minutes"></span>Min</li>
                                        <li class="mb-0"><span id="seconds"></span>Sec</li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <!--  <section class="gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heading two">
                        <h6>CHOOSE NATURE</h6>
                        <h2>Frequently Asked Questions</h2>
                    </div>
                    <div class="accordion">
                        <div class="accordion-item">
                            <a href="#" class="heading">
                                <div class="icon"></div>
                                <div class="title">What questions can AI not answer?</div>
                            </a>

                            <div class="content">
                                <p>AI is helping countries and communities facing disease and natural disasters, and
                                    providing new opportunities for historically underserved groups.
                                </p>
                            </div>
                        </div>

                        <div class="accordion-item active">
                            <a href="#" class="heading">
                                <div class="icon"></div>
                                <div class="title">How powerful is artificial intelligence?</div>
                            </a>

                            <div class="content" style="display: block;">
                                <p>AI is helping countries and communities facing disease and natural disasters, and
                                    providing new opportunities for historically underserved groups.
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <a href="#" class="heading">
                                <div class="icon"></div>
                                <div class="title">How artificial intelligence works?</div>
                            </a>

                            <div class="content">
                                <p>AI is helping countries and communities facing disease and natural disasters, and
                                    providing new opportunities for historically underserved groups.
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <a href="#" class="heading">
                                <div class="icon"></div>
                                <div class="title">Can AI solve social problems?</div>
                            </a>

                            <div class="content">
                                <p>AI is helping countries and communities facing disease and natural disasters, and
                                    providing new opportunities for historically underserved groups.
                                </p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <a href="#" class="heading">
                                <div class="icon"></div>
                                <div class="title">How does AI affect human society?</div>
                            </a>

                            <div class="content">
                                <p>AI is helping countries and communities facing disease and natural disasters, and
                                    providing new opportunities for historically underserved groups.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion-img">
                        <figure>
                            <img src="https://via.placeholder.com/246x345" alt="img">
                        </figure>
                        <figure class="accordion-img-two">
                            <img src="https://via.placeholder.com/363x467" alt="img">
                        </figure>
                        <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-two">
                        <img src="assets/img/dots-1.png" alt="icon" class="dots">
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section class="blog-section">
        <div class="container">
            <div class="heading">
                <img src="assets/img/heading-img.png" alt="img">
                <h6>Articles and Blog</h6>
                <h2>Recent News</h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="blog-img">
                        <figure>
                            <img src="assets/img/rasi/products/Current News 636_480" alt="img">
                        </figure>
                        <div class="blog">
                            <h4>24<span>Dec, 2024</span></h4>
                            <div>
                                <h3><a href="blog-details.html">How Does A Lotion Containing CBD Help Your Skin?</a></h3>
                                <div class="d-flex align-items-center">
                                    <h5><i><i class="fa-regular fa-message"></i></i>21 Comments</h5>
                                    <h5><i><svg data-name="Capa 1" viewBox="0 0 20 19.84"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.41,9.06a3,3,0,1,0-4.82,0,6.55,6.55,0,0,0-3.74,6,.38.38,0,1,0,.75,0A5.6,5.6,0,0,1,10,9.29a5.6,5.6,0,0,1,5.4,5.77.38.38,0,1,0,.75,0A6.55,6.55,0,0,0,12.41,9.06ZM8.32,8.79a2.21,2.21,0,1,1,3.89-1.43,2.16,2.16,0,0,1-.5,1.4l0,0a5.8,5.8,0,0,0-3.37,0Z">
                                                </path>
                                            </svg></i>Willimes Domson</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="blog">
                        <h4>24<span>Dec, 2024</span></h4>
                        <div>
                            <h3><a href="blog-details.html">How Does A Lotion Containing CBD Help Your Skin?</a></h3>
                            <div class="d-flex align-items-center">
                                <h5><i><i class="fa-regular fa-message"></i></i>21 Comments</h5>
                                <h5><i><svg data-name="Capa 1" viewBox="0 0 20 19.84"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.41,9.06a3,3,0,1,0-4.82,0,6.55,6.55,0,0,0-3.74,6,.38.38,0,1,0,.75,0A5.6,5.6,0,0,1,10,9.29a5.6,5.6,0,0,1,5.4,5.77.38.38,0,1,0,.75,0A6.55,6.55,0,0,0,12.41,9.06ZM8.32,8.79a2.21,2.21,0,1,1,3.89-1.43,2.16,2.16,0,0,1-.5,1.4l0,0a5.8,5.8,0,0,0-3.37,0Z">
                                            </path>
                                        </svg></i>Willimes Domson</h5>
                            </div>
                        </div>
                    </div>
                    <div class="blog">
                        <h4>24<span>Dec, 2024</span></h4>
                        <div>
                            <h3><a href="blog-details.html">How Does A Lotion Containing CBD Help Your Skin?</a></h3>
                            <div class="d-flex align-items-center">
                                <h5><i><i class="fa-regular fa-message"></i></i>21 Comments</h5>
                                <h5><i><svg data-name="Capa 1" viewBox="0 0 20 19.84"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.41,9.06a3,3,0,1,0-4.82,0,6.55,6.55,0,0,0-3.74,6,.38.38,0,1,0,.75,0A5.6,5.6,0,0,1,10,9.29a5.6,5.6,0,0,1,5.4,5.77.38.38,0,1,0,.75,0A6.55,6.55,0,0,0,12.41,9.06ZM8.32,8.79a2.21,2.21,0,1,1,3.89-1.43,2.16,2.16,0,0,1-.5,1.4l0,0a5.8,5.8,0,0,0-3.37,0Z">
                                            </path>
                                        </svg></i>Willimes Domson</h5>
                            </div>
                        </div>
                    </div>
                    <div class="blog">
                        <h4>24<span>Dec, 2024</span></h4>
                        <div>
                            <h3><a href="blog-details.html">How Does A Lotion Containing CBD Help Your Skin?</a></h3>
                            <div class="d-flex align-items-center">
                                <h5><i><i class="fa-regular fa-message"></i></i>21 Comments</h5>
                                <h5><i><svg data-name="Capa 1" viewBox="0 0 20 19.84"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.41,9.06a3,3,0,1,0-4.82,0,6.55,6.55,0,0,0-3.74,6,.38.38,0,1,0,.75,0A5.6,5.6,0,0,1,10,9.29a5.6,5.6,0,0,1,5.4,5.77.38.38,0,1,0,.75,0A6.55,6.55,0,0,0,12.41,9.06ZM8.32,8.79a2.21,2.21,0,1,1,3.89-1.43,2.16,2.16,0,0,1-.5,1.4l0,0a5.8,5.8,0,0,0-3.37,0Z">
                                            </path>
                                        </svg></i>Willimes Domson</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-one">
        <img src="assets/img/rasi/cotton-img.png" alt="icon" class="extra-images-two">
        <img src="assets/img/dots.png" alt="icon" class="dots">
    </section>

    <div class="container gap ">
        <div class="heading">
            <!-- <img src="assets/img/heading-img.png" alt="img">
            <h6>Articles and Blog</h6> -->
            <h2>Research Collaboration</h2>
        </div>
        <div class="clients-slider owl-carousel">
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-1.jpg">
            </div>
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-2.jpg">
            </div>
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-3.jpg">
            </div>
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-4.jpg">
            </div>
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-5.jpg">
            </div>
            <div class="item">
                <img alt="clients" src="assets/img/rasi/research-logo-6.jpg">
            </div>
        </div>
    </div> 


<!-- #35754f -->
        <div class="modal fade zoom" id="product_detail_popup" tabindex="-1" aria-hidden="true" style="z-index:2000">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="trow"></div>
                <div class="modal-content product_modal_content">
                  <div class="modal-header border-bottom-0"> 
                    <h5 class="modal-title w-100 d-flex justify-content-center"><span class="product_modal_title">JET BGII</span></h5>
                    <!-- <img src="assets/img/rasi/fcm.jpg"> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> 
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-xl-4 col-md-12">
                                <img src="" class="product_modal_image" alt="img" width="250" height="250">
                            </div>
                            <div class="col-lg-6 col-xl-8 col-md-12 product_modal_describe">
                                <ul>
                                    <li>Premium collection curated for creators and marketers.</li>
                                    <li>High-resolution images and videos for enhanced projects.</li>
                                    <li>Versatile content ideal for social media, websites, and presentations.</li>
                                    <li>Vibrant landscapes and intimate portraits to inspire creativity.</li>
                                    <li>Professional quality to elevate your content strategy.</li>
                                    <li>Seamless blend of aesthetic appeal and usability.</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade zoom" id="scheme_modal" tabindex="-1" role="dialog" aria-labelledby="flipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content scheme-content">
                <img src="assets/img/rasi/products/tour_scheme.png">
              </div>
            </div>
        </div>


    <?php include_once('footer.php') ?>

    <?php include_once('bottom_script.php') ?>



    <script type="text/javascript">
    // $(document).on('click','.products',function(){
    //     $('#product_detail_popup').modal('show');
    // });

    $(document).on('click','.sustainability',function(){
        $('#scheme_modal').modal('show');
    });

    $(document).on('click','.view_product,.products',function(){
        var division   = $('.site_division').val();
        var product_id = $(this).data('productid');
        var file_path = $('#divison_file_path').val();
        $.ajax({
            url  : "common_ajax.php",
            type : "POST",
            data : {"Action":"single_product_view",product_id: product_id,site_division : division},
            success: function(data){
                result = JSON.parse(data);
                $('.product_modal_title').text(result[0].Product_name);
                $('.product_modal_image').attr('src',file_path+result[0].Product_image);
                $('#product_detail_popup').modal('show');
            }
        });
    });


    // $(document).ready(function(){
    //     $('.greeting-link').magnificPopup({
    //         type:'image',
    //           mainClass: 'rotate-carouse-left', // this class is for CSS animation below
    //           removalDelay: 200, //delay removal by X to allow out-animation
    //           showCloseBtn: true,
    //           closeOnBgClick: false,
    //           enableEscapeKey: false,
    //     });
    // });





    </script>

</body>