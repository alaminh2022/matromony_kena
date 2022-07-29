<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once 'includes/top/'.$top;?>

    <!-- Google Analytics -->
    <script>
    <?php $g_set = $this->db->get_where('third_party_settings',array('type'=>'google_analytics_set'))->row()->value;
        if ($g_set == "yes") {
            $g_key = $this->db->get_where('third_party_settings',array('type'=>'google_analytics_key'))->row()->value;
        }
        else {
            $g_key = " ";
        }
    ?>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', "<?php echo $g_key; ?>", 'auto');
    ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->


    <!-- Favicon -->
    <?php
        $favicon = $this->db->get_where('frontend_settings', array('type' => 'favicon'))->row()->value;
        $favicon = json_decode($favicon, true);
        if (!empty($favicon) && file_exists('uploads/favicon/'.$favicon[0]['image'])) {
    ?>
            <link href="<?=base_url()?>uploads/favicon/<?=$favicon[0]['image']?>" rel="icon" type="image/png">
    <?php
        }
        else {
    ?>
            <link href="<?=base_url()?>uploads/favicon/default_image.png" rel="icon" type="image/png">
    <?php
        }
    ?>
	<title><?=$title?></title>

	<?php if($this->db->get_where('third_party_settings', array('type' => 'facebook_chat_set'))->row()->value == "yes") { ?>
	    <?php $facebook_chat_page_id = $this->db->get_where('third_party_settings', array('type' => 'facebook_chat_page_id'))->row()->value; ?>
	    <?php $facebook_chat_theme_color = $this->db->get_where('third_party_settings', array('type' => 'facebook_chat_theme_color'))->row()->value; ?>
	    <?php $facebook_chat_logged_in_greeting = $this->db->get_where('third_party_settings', array('type' => 'facebook_chat_logged_in_greeting'))->row()->value; ?>
	    <?php $facebook_chat_logged_out_greeting = $this->db->get_where('third_party_settings', array('type' => 'facebook_chat_logged_out_greeting'))->row()->value; ?>
		<!-- facebook chat starts -->
		<div id="fb-root"></div>
		<script>
		    window.fbAsyncInit = function() {
		        FB.init({
		            xfbml            : true,
		            version          : 'v6.0'
		        });
		    };

		    (function(d, s, id) {
		        var js, fjs = d.getElementsByTagName(s)[0];
		        if (d.getElementById(id)) return;
		        js = d.createElement(s); js.id = id;
		        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
		        fjs.parentNode.insertBefore(js, fjs);
		    }(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="fb-customerchat"
		     attribution=setup_tool
		     page_id="<?= $facebook_chat_page_id ?>"
		     <?php if (!empty($facebook_chat_theme_color)) { ?> theme_color="<?= $facebook_chat_theme_color ?>" <?php } ?>
		    <?php if (!empty($facebook_chat_logged_in_greeting)) { ?>  logged_in_greeting="<?= $facebook_chat_logged_in_greeting ?>"  <?php } ?>
		    <?php if (!empty($facebook_chat_logged_out_greeting)) { ?>  logged_out_greeting="<?= $facebook_chat_logged_out_greeting?>"> <?php } ?>
		</div>
		<!-- facebook chat ends -->
	<?php } ?>
    <style> 
    @media screen and (max-width:480px) {
        .st-content-inner.t1-head-space-area-login {
            background: #e7087f;
            margin: 0;
            padding: 0;
        }
        .sticky-header {
            background: #eb067c;
        }
    }
    </style>
</head>
<body>
   <?php
    $login_image = $this->db->get_where('frontend_settings', array('type' => 'login_image'))->row()->value;
    $login_image_data = json_decode($login_image, true);

   ?>
   <div class="header">
       <!-- MAIN WRAPPER -->
        <div class="body-wrap">
            <div id="st-container" class="st-container  st-home-banner-area">
               
                
                <div class="st-pusher  ">
                    <div class="st-content">
                        <div class="st-content-inner t1-head-space-area-login">
                            <!-- Navbar -->
                            <div id="myHeader">
                               
                                <nav class="navbar navbar-expand-lg navbar-light bg-default navbar--link-arrow navbar--uppercase">
                                    <div class="container navbar-container">
                                        <!-- Brand/Logo -->
                                        <a class="navbar-brand" href="<?=base_url()?>home/">
                                            <?php
                                                $header_logo_info = $this->db->get_where('frontend_settings', array('type' => 'header_logo'))->row()->value;
                                                $header_logo = json_decode($header_logo_info, true);
                                                if (file_exists('uploads/header_logo/'.$header_logo[0]['image'])) {
                                                ?>
                                                    <img src="<?=base_url()?>uploads/header_logo/<?=$header_logo[0]['image']?>" class="img-responsive c100px" height="100%">
                                                <?php
                                                }
                                                else {
                                                ?>
                                                    <img src="<?=base_url()?>uploads/header_logo/default_image.png" class="img-responsive c100px" height="100%">
                                                <?php
                                                }
                                            ?>
                                        </a>
                                        <div class="d-inline-block m-off">
                                            <!-- Navbar toggler  -->
                                            <button class="navbar-toggler hamburger hamburger-js hamburger--spring" type="button" data-toggle="collapse" data-target="#navbar_main" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="hamburger-box">
                                            <span class="hamburger-inner"></span>
                                            </span>
                                            </button>
                                        </div>
                                        <div class="collapse navbar-collapse align-items-center justify-content-end" id="navbar_main">
                                            <!-- Navbar links -->
                                           <div class="did-you-t1">
                                                 <a href="<?php echo base_url(); ?>" class="t1-login-btn-22"> Create account</a>
                                           </div>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                            <div class="sticky-content">
                                <?php
                                    $sticky_header = $this->db->get_where('frontend_settings', array('type' => 'sticky_header'))->row()->value;
                                    if ($sticky_header == 'yes') { ?>
                                    <script type="text/javascript">
                                        window.onscroll = function() {
                                            scrollFunction();
                                        };
                                        var header = document.getElementById("myHeader");
                                        var sticky = header.offsetTop;

                                        function scrollFunction() {
                                            if (window.pageYOffset > sticky) {
                                                header.classList.add("sticky-header");
                                            } else {
                                                header.classList.remove("sticky-header");
                                            }
                                        }
                                    </script>
                                <?php } ?>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('.set_langs').on('click', function () {
                                            var lang_url = $(this).data('href');
                                            $.ajax({url: lang_url, success: function (result) {
                                                    location.reload();
                                                }});
                                        });
                                    });
                                </script>
                        <style>
                            .blink_me {
                                animation: blinker 1.5s linear infinite;
                            }
                            @keyframes blinker {
                                50% {
                                    opacity: 0;
                                }
                            }
                        </style>
                    </div>
                </div>
                <div class="t1-get-start-area container ">

                    <div class="row t1-ro-bg-white">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 t1-pad-left-0">
                            <div class="area-banner-left-form-login login-web-loader-gf">
                                <div class="loader-area">
                                        <div class="loader"></div>
                                </div>
                            
                                <div class="t1-h2-clz">
                                    <h2 class="content__slogan slogan slogan--desktop">
                                    Welcome back! <br>
                                        </h2>
                                </div>
                                <div class="">
                                <div class="">
                                    <div class="form-body">
                                        <div class="text-center px-2">
                                          
                                            <?php
                                                if (!empty($register_success)) {
                                                ?>
                                                    <p class="text-success"><?=$register_success?></p>
                                                <?php
                                                }
                                            ?>
                                        </div>
                                        <form class="form-default" role="form" method="post" action="<?=base_url()?>home/check_login">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="text-uppercase font_light"><?php echo translate('email')?></label>
                                                        <input type="email" placeholder="E-mail" class="form-control input-sm" name="email" id="inp_usr_nm" autofocus required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group has-feedback">
                                                        <label class="text-uppercase font_light"><?php echo translate('password')?></label>
                                                        <input type="password" placeholder="Password" class="form-control input-sm" name="password" id="inp_pass" required>
                                                    </div>
                                                    <p style="color: red">
                                                        <?php
                                                            if (!empty($login_error)){
                                                                echo $login_error;
                                                            }
                                                        ?>
                                                    </p>
                                                    <p style="color: green">
                                                        <?php
                                                            if (!empty($sent_email)){
                                                                echo $sent_email;
                                                            }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-styled btn-sm btn-block btn-base-1 z-depth-2-bottom mt-4 lgon-t1"><?php echo translate('log_in')?></button>
                                            <div class="row pt-3">
                                                <div class="col-6" style="font-size: 12px;">
                                                    <div class="checkbox">
                                                        <input type="checkbox" name="remember_me" id="remember_me" value="checked">
                                                        <label for="remember_me"><span class="c-gray-light"><?php echo translate('remember_me')?></span></label>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-right" style="font-size: 12px;">
                                                    <!-- <a href="<?=base_url()?>home/forget_pass" class="c-gray-light"><?php echo translate('recover_password')?></a> -->
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12 text-center" style="font-size: 12px;">
                                                <span class="c-gray-light"><?php echo translate('new_here?')?></span><a class="c-gray-light" href="<?=base_url()?>home"> <u><?php echo translate('create_an_account_from_here!')?></u></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(demo()){ ?>
                                    <div class="form-card form-card--style-2 z-depth-3-top mt-5">
                                    <div class="form-body">
                                        <div class="text-center px-2">
                                            <h4 class="heading heading-4 strong-400 mb-4 font_light"><?php echo translate('sign_in_details')?></h4>
                                            <?php
                                                if (!empty($register_success)) {
                                                ?>
                                                    <p class="text-success"><?=$register_success?></p>
                                                <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="text-center">
                                            <p style="color:#ccc;"><b>Username:</b> <span id="usr_nm">user@gmail.com</span></p>
                                            <p style="color:#ccc;"><b>Password:</b> <span id="pass">1234</span></p>
                                            <button type="button" class="btn btn-styled btn-sm btn-block btn-base-1 z-depth-2-bottom mt-4 cpy_btn"><?=translate('copy')?></button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 t1-pa-rigt-0">
                            <div class="ima-login-banner">
                                <img src="<?=base_url()?>uploads/login_image/<?=$login_image_data[0]['image']?>" alt="">
                            </div>
                        </div>
                        
                    </div>
                    <div class="banner-spance-bottom-t1"></div>
                </div>
            </div>
        </div>

    </div>
   
   
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    <script>
           var owl = $('.owl-carousel');
                owl.owlCarousel({
                    loop:true,
                    nav:true,
                    margin:10,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:3
                        },            
                        960:{
                            items:5
                        },
                        1200:{
                            items:4
                        }
                    }
                });
                owl.on('mousewheel', '.owl-stage', function (e) {
                    if (e.deltaY>0) {
                        owl.trigger('next.owl');
                    } else {
                        owl.trigger('prev.owl');
                    }
                    e.preventDefault();
                });
          </script>
             <footer class="footer-from-bottom">
        <nav class="main-nav">
        <ul>
        <li><a target="_blank" class="js-support-footer-link keychainify-checked" href="">About the Project</a></li>
        <li><a target="_blank" class="js-support-footer-link keychainify-checked" href="">Customer Support</a></li>

        <li class="js-common-footer-terms hide-footer-item">
        <a href="" target="_blank" class="js-common-footer-link keychainify-checked">User Agreement</a>
        </li>
        <li class="js-common-footer-affiliate">
        <a href="" target="_blank" class="js-common-footer-link keychainify-checked">Affiliate program</a>
        </li>

        <li><a href="" target="_blank" class="js-common-footer-link keychainify-checked">Privacy Policy</a></li>
        </ul>
        </nav>
    </footer>
</body>
</html>
<!-- Bootstrap Modal -->
<div class="modal fade" id="active_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width: 400px; margin-top: 30vh;">
        <div class="modal-content">
            <div class="modal-header text-center" style="display: block; border-bottom: 1px solid transparent">
                <span class="modal-title" id="modal_header"><?php echo translate('title')?></span>
                <button type="button" class="close" id="modal_close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="modal_body">
                <div class='text-center' id='payment_loader'><i class='fa fa-refresh fa-5x fa-spin'></i><p><?php echo translate('please_wait_...')?></p></div>
            </div>
            <div class="text-center" id="modal_buttons">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?php echo translate('close')?></button>
            </div>
        </div>
    </div>
</div>
<div id="test"></div>
<div id="snackbar">Some text some message..</div>
<script type="text/javascript">
	$(document).ready(function(){
        $('.top_bar_right').load('<?php echo base_url(); ?>home/top_bar_right');
    });
</script>
<!-- Bootstrap Modal -->

<script>
    var isloggedin = "<?=$this->session->userdata('member_id')?>";

    var right_click ="<?=$this->db->get_where('general_settings',array('type'=>'right_click_option'))->row()->value?>"
    if(right_click == "on"){
            $('body').on('contextmenu', function(e) {
            return false;
        });
    }


    function confirm_accept(id) {
        if (isloggedin == "") {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("Please Login");
            $("#modal_body").html("<p class='text-center'><?php echo translate('please_log_in_to_accept_this_request')?></p>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'>Close</button> <a href='<?=base_url()?>home/login' class='btn btn-sm btn-base-1 btn-shadow' style='width:25%'>Log In</a>");
        }
        else {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("Confirm Accept Request");
            $("#modal_body").html("<p class='text-center'><?php echo translate('are_you_sure_that_you_want_to_accept_this_request')?>?</p>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'>Close</button> <a href='#' id='confirm_accept' class='btn btn-sm btn-base-1 btn-shadow' onclick='return do_accept("+id+")' style='width:25%'>Confirm</a>");
        }
    }
    function do_accept(id) {
        $("#confirm_accept").removeAttr("onclick");
        $("#confirm_accept").html("<i class='fa fa-refresh fa-spin'></i> <?php echo translate('processing')?>..");
        setTimeout(function() {
            $.ajax({
                type: "POST",
                url: "<?=base_url()?>home/accept_interest/"+id,
                cache: false,
                success: function(response) {
                    $("#active_modal .close").click();
                    $(".text_"+id).html("<small class='sml_txt'><i class='fa fa-check-circle'></i> <?php echo translate('you_have_accepted_the_interest')?></small>");
                    $(".text_"+id).attr('class', 'text-center text-success text_'+id);
                    $("#success_alert").show();
                    $(".alert-success").html("<?php echo translate('you_have_accepted_the_request')?>!");
                    $('#danger_alert').fadeOut('fast');
                    setTimeout(function() {
                        $('#success_alert').fadeOut('fast');
                    }, 5000); // <-- time in milliseconds
                },
                fail: function (error) {
                    alert(error);
                }
            });
        }, 500); // <-- time in milliseconds
    }

    function confirm_reject(id) {
        if (isloggedin == "") {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("<?php echo translate('please_log_in')?>");
            $("#modal_body").html("<p class='text-center'><?php echo translate('please_log_in_to_reject_this_request')?></p>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close')?></button> <a href='<?=base_url()?>home/login' class='btn btn-sm btn-base-1 btn-shadow' style='width:25%'><?php echo translate('log_in')?></a>");
        }
        else {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("<?php echo translate('confirm_reject_request')?>");
            $("#modal_body").html("<p class='text-center'<?php echo translate('are_you_sure_that_you_want_to_reject_this_request?')?>>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close')?></button> <a href='#' id='confirm_reject' class='btn btn-sm btn-base-1 btn-shadow' onclick='return do_reject("+id+")' style='width:25%'><?php echo translate('confirm')?></a>");
        }
    }
    function do_reject(id) {
        $("#confirm_reject").removeAttr("onclick");
        $("#confirm_reject").html("<i class='fa fa-refresh fa-spin'></i> <?php echo translate('processing')?>..");
        setTimeout(function() {
            $.ajax({
                type: "POST",
                url: "<?=base_url()?>home/reject_interest/"+id,
                cache: false,
                success: function(response) {
                    $("#active_modal .close").click();
                    $(".text_"+id).html("<small class='sml_txt'><i class='fa fa-times-circle'></i><?php echo translate('you_have_rejected_the_interest')?></small>");
                    $(".text_"+id).attr('class', 'text-center text-danger text_'+id);
                    $("#danger_alert").show();
                    $(".alert-danger").html("<?php echo translate('you_have_rejected_this_request!')?>");
                    $('#success_alert').fadeOut('fast');
                    setTimeout(function() {
                        $('#danger_alert').fadeOut('fast');
                    }, 5000); // <-- time in milliseconds
                },
                fail: function (error) {
                    alert(error);
                }
            });
        }, 500); // <-- time in milliseconds
    }
   
    function myFunction(data) {
       
        var x = document.getElementById("snackbar");
        x.className = "show";
        $('#snackbar').html(data);
        $('#snackbar').css({
            background:"#69cb5de0",

        });
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
    function myFunctionError(data) {
        var x = document.getElementById("snackbar");
        x.className = "show";
        $('#snackbar').css({
            background:"#d25454",
            
        });
        $('#snackbar').html(data);
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>
