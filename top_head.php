<?php 
include '../auto_load.php';


if(!isset($_SESSION['customer_portal_verification']) || $_SESSION['customer_portal_verification'] != true) {
    $url = '../pages/landing.php';
    ///header('Location: '.$url);
}

//Customer region get and set in session
$region_sql = "SELECT Region_Code FROM SD_CUS_MASTER WHERE PAN_No = '".$_SESSION['EmpID']."'"; 
$region_sql_exec = sqlsrv_query($conn, $region_sql);
$customer_region_id = sqlsrv_fetch_array($region_sql_exec,SQLSRV_FETCH_ASSOC)['Region_Code'];
$_SESSION['region_code'] = $customer_region_id; 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer portal - Home</title>
    <link rel="icon" href="../global/photos/favicon.ico">
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <!-- fancybox -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/splitting.css">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- style -->
    <link rel="stylesheet" href="assets/css/style.css">


    <!-- ========== Start Stylesheet ========== -->
    <link href="assets/header_css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/header_css/all.min.css" rel="stylesheet" />
    <link href="assets/header_css/animate.css" rel="stylesheet" />
    <!-- <link href="assets/header_css/themify-icons.css" rel="stylesheet" /> -->
    <link href="assets/header_css/icofont.min.css" rel="stylesheet" />
    <link href="assets/header_css/flaticon.css" rel="stylesheet" />
    <link href="assets/header_css/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/header_css/bsnav.min.css" rel="stylesheet" />
    <!-- <link href="assets/header_css/preloader.css" rel="stylesheet" /> -->
    <link href="assets/header_css/magnific-popup.css" rel="stylesheet" />
    <link href="assets/header_css/swiper-bundle.min.css" rel="stylesheet" />
    <link href="assets/header_css/style.css" rel="stylesheet">
    <link href="assets/css/header.css" rel="stylesheet">
    <link href="assets/header_css/responsive.css" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.min.css" integrity="sha512-lvaVbvmbHhG8cmfivxLRhemYlTT60Ly9Cc35USrpi8/m+Lf/f/T8x9kEIQq47cRj1VQIFuxTxxCcvqiQeQSHjQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <!-- responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    
    <script src="assets/js/preloader.js"></script>

    <!-- daterange picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">

    <script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- custmized styles start -->
    <style type="text/css">
        * {
            scroll-behavior: smooth !important;
        }
        @media only screen and (min-width: 1400px) and (max-width: 1600px) {
            .navbar-bar-shape {
                height: 100%;
                width: 215px;
            }
        }

        .navbar-bar-shape {
            background: #ffffff !important;
        }
        .menu-img {
            width: 20px;
            height: 20px;
        }
        .top-bar-area::before {
             background: #00722d !important; 
/*            background: #01af41 !important;*/
        }

        .hero-section:before {
            background-color: #35754f !important;
        }

        .navbar .navbar-nav .nav-item .nav-link {
/*            line-height: 20px !important;*/
            font-size: 15px !important;
        }

        .lh-unset {
            line-height: unset !important;
        }

        .menu-img-2 {
            width: 35px;
            height: 35px;
        }
        .menu-img-3 {
            width: 23px;
            height: 23px;
        }

        .top-social li a i {
            height: 2rem !important;
            width: 2rem !important;
            line-height: 2rem !important;
            font-size: 1rem !important;
        }

        .fadeup {
            padding-right: 5px !important;
        }

        .menu-active {
            border-bottom: 6px solid #01af41 !important;
        }

        .rasi_top_logo {
            width: 85px;
            padding-right: 10px;
        }

        .pd_division {
            overflow: hidden;
            position: relative;
        }

        .pd_division::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: rgb(109 199 134 / 25%); /* Change to your desired color */
            transition: left 0.5s ease-in-out;
        }

        .pd_division:hover::before {
            left: 0;
        }
        .p-30 {
            padding: 30px;
        }

        .pd_division:hover {
          transform: scale(1.2);
          border-radius: 20px;
      }

      .card-selected {
          transform: scale(1.2);
          border-radius: 20px;
          border: 5px solid #0080004f;            
      }

      .pd_division_content {
        border-radius: 10px;
      }

      .pd_division_header {
          background: #008000;
          border-bottom-left-radius: 9px;
          border-bottom-right-radius: 9px;
      }

      .invoice_head_bg {
        padding-bottom: 160px;
      }

      .filter-bg {
            background: #01af41 !important;
      }

    @media only screen and (min-width: 1200px) and (max-width: 1399px){
        .navbar-container {
            grid-template-columns: 165px 1fr;
            align-items: baseline;
            padding: 0 0;
            justify-items: center;
        }
        .navbar-bar-shape {
            height: 58%;
            width: 180px !important;
        }

        .top-location > span,.top-email > span,.top-phone > span {
            font-size: 15px;
        }
    }

    @media only screen and (min-width: 1400px) and (max-width: 1600px) {
        .navbar-container {
            display: grid;
            grid-template-columns: 180px 1fr;
            align-items: baseline;
            padding: 0 3rem;
        }
       /* .navbar-container {
            grid-template-columns: 180px 1fr;
            padding: 0px 3rem;
        }*/
        .navbar-bar-shape {
            height: 58%;
            width: 200px;
        }
    }

    @media only screen and (min-width: 1601px) {
        .navbar-container {
            grid-template-columns: 315px 1fr;
            align-items: baseline;
            padding: 0 0;
            justify-items: center;
        }
        .navbar-bar-shape {
            height: 58%;
            width: 300px !important;
        }
    }


    .hero-text {
        background: rgba(0, 0, 0, 0.5);
    }

    .hero-section:before {
        background-image: url('assets/img/rasi/crops.jpg');
        background-size: cover;
        background-position: bottom;
    }



      .ajaxloader {
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        position: fixed;
        z-index: 999999999999999999;
        right: 0;
        display: none;
      }

      .aj_loader {
        position: absolute;
        right: 50%;
        top: 50%;
      }


      .switch_division {
          cursor: pointer;
          animation: shake 2s cubic-bezier(.36,.07,.19,.97) infinite;
          transform: translate3d(0, 0, 0);
          perspective: 1000px;
          width: 142px;
      }



      @keyframes shake {
          10%, 90% {
            transform: translate3d(-1px, 0, 0);
        }
        20%, 80% {
            transform: translate3d(2px, 0, 0);
        }
        30%, 50%, 70% {
            transform: translate3d(-4px, 0, 0);
        }
        40%, 60% {
            transform: translate3d(4px, 0, 0);
        }
    }

    .fade-flip {
      transform: rotateX(-90deg);
      opacity: 0;
      -webkit-transition: all .25s linear;
      -o-transition: all .25s linear;
      transition: all .25s linear;
    }
    .fade-flip.in {
      opacity: 1;
      transform: rotateX(0deg);
    }
    .fade-flip .modal-dialog {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        transform: translateY(-50%) !important;
    }


    .preloader {
/*        background-color: #35754f;*/
/*        background: url('https://timesofagriculture.in/wp-content/uploads/2023/06/Rasi-Seeds-Private-Limited.jpg');*/
    background: rgb(255 255 255 / 77%);
    }

    .loader {
        background: url('assets/img/rasi/VijayRasiSeedsLogo.png');
        background-position: center;
        background-size: cover;
    }

    .scheme-content {
     height: 50%;
     width: 50%;
     margin-left: auto;
     margin-right: auto;
    }

    .site-head {
        font-family: Roboto, sans-serif;
        font-weight: bold;
        letter-spacing: 1px;
        padding-bottom: 10px;
        color: #008136;
        text-transform: uppercase;
    }

    .mfp-close {
        cursor: pointer;
    }

    .mfp-wrap {
        position: absolute;
        z-index: 2000;
    }

    </style>
    <!-- custmized styles end -->
</head>

<body>
    <input type="hidden" class="site_division" value="<?php echo isset($_SESSION['selected_division']) ? $_SESSION['selected_division'] : ''; ?>">
    <?php 
        $customer_divisions = explode(',',$_SESSION['customer_product_division']);
        $division_alingment = (COUNT($customer_divisions) > 0 && (COUNT($customer_divisions) < 3)) ? 'justify-content-center' : ''; 
     ?>

     <a class="greeting-link d-none" href="https://media.geeksforgeeks.org/wp-content/uploads/20231102193011/diwali-2023-date.png">Open popup</a>

    <!-- division selection pop up start-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 20000;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content pd_division_content">
              <div class="modal-header pd_division_header"> 
                <h5 class="modal-title ms-auto me-auto text-white" id="staticBackdropLabel">Choose division</h5>
                <!-- <img src="assets/img/rasi/fcm.jpg"> -->
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div> 
                <div class="modal-body">
                    <div class="row <?php echo $division_alingment; ?>">
                        <?php foreach ($customer_divisions as $key => $value) { 
                        if($value == 'CT01') {   ?>
                        <div class="col-xl-4 col-md-4 col-sm-6 col-12 p-30">
                            <div class="card pd_division" data-division= 'CT01' data-division-name= 'Cotton'>
                                <img src="https://wallpaper.forfun.com/fetch/16/16037ba5d3607934ebf824ee09a46d88.jpeg" class="card-img-top" alt="...">                    
                                <div class="card-body">
                                    <h3 class="text-center">Cotton</h3>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php  if($value == 'FC01') {   ?>
                        <div class="col-xl-4 col-md-4 col-sm-6 col-12 p-30">
                            <div class="card pd_division" data-division= 'FC01' data-division-name= 'Field Crop'>
                                <img src="assets/img/rasi/fcm.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h3 class="text-center">Field Crop</h3>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php  if($value == 'FR01') {   ?>
                        <div class="col-xl-4 col-md-4 col-sm-6 col-12 p-30">
                            <div class="card pd_division" data-division= 'FR01' data-division-name= 'Forage'>
                                <img src="https://c1.wallpaperflare.com/preview/339/858/433/pointed-fescue-licorice-ear-forage-grass.jpg" class="card-img-top" alt="...">

                                <div class="card-body">
                                    <h3 class="text-center">Forage</h3>
                                </div>
                            </div>
                        </div>
                        <?php }} ?>

                    </div>

                    <div class="text-center reponse_msg alert alert-success" role="alert" style="display:none;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- division selection pop up end-->

    <!-- preloader -->
    <div class="preloader">
        <div class="loader">
            <!-- div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div> -->
        </div>
    </div>

    <div class="ajaxloader">
        <div class="loader aj_loader">
            <!-- <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div> -->
        </div>
    </div>

