    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/splitting.js"></script>
    <!-- fancybox -->
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/custom.js"></script>


    <!-- header js start-->
    <script src="assets/header_js/bsnav.min.js"></script>
    <script src="assets/header_js/popper.min.js"></script>
    <script src="assets/header_js/jquery.magnific-popup.min.js"></script>
    <!-- header js end -->


    <script type="text/javascript">
        $(document).ready(function(){
          var divison = $('.site_division').val();

          // $('#staticBackdrop').modal({backdrop:'static', keyboard:false});
          $('.greeting-link').magnificPopup({
              type:'image',
              mainClass: 'rotate-carouse-left', // this class is for CSS animation below
              removalDelay: 200, //delay removal by X to allow out-animation
              showCloseBtn: true,
              closeOnBgClick: false,
              enableEscapeKey: false,
          });

          if(divison == '') {
            $('.greeting-link').trigger('click');
            // $('#staticBackdrop').modal('show');
          }

          var division_text = ['Cotton','Field Crop','Forage'];
          var colurs        = ['blue','#d215d2','#01af41'] 
          setInterval(function(){
            var index = parseInt($('.product_index').val()) + parseInt(1);
            if(division_text.length == index) {
                index = 0;
            }
            $('.product_index').val(index);
            $('.switch_division').css('background',colurs[index]);
            $('.change-content').text(division_text[index]);
          },2000)
          
        });

        $(document).on('click','.pd_division',function(){
            $('.pd_division').each(function(){
                $(this).removeClass('card-selected');
            });
            $(this).addClass('card-selected');
            var division      = $(this).data('division');
            var division_name = $(this).data('division-name');

            $.ajax({
              type: 'POST',
              url: 'index.php',
              dataType: 'json',
              data: { action : 'division_select',division  : division,division_name : division_name },
              success: function(response) {
                $('.reponse_msg').text(response.message);
                $('.reponse_msg').show();

                $('.site_division').val(division);
                setTimeout(function() {
                    $('#staticBackdrop').modal('hide');
                    location.replace(window.location.origin+"/corporate_dev/customer_site/index.php");
                }, 2000);
            }
        });


        });

        $(document).on('click','.switch_division',function(){
            $('.reponse_msg').hide();
            var divison = $('.site_division').val();
            $('.pd_division').each(function(){
                $(this).removeClass('card-selected');

                if($(this).data('division') == divison) {
                    $(this).addClass('card-selected');
                }
            });

            $('#staticBackdrop').modal('show');
        });

        $(document).on('click','.mfp-close',function(){
            $(".mfp-wrap").addClass('mfp-removing');
            setTimeout(function(){
               $.magnificPopup.close();
               $('#staticBackdrop').modal('show');
           }, 500);
        });
    </script>