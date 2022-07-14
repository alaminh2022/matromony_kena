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
</head>
<body>
   
   <div class="header">
       <!-- MAIN WRAPPER -->
        <div class="body-wrap">
            <div id="st-container" class="st-container  st-home-banner-area">
                <div class="home_banner">
                    <img src="<?php echo base_url('uploads/home_page/home_banner/home_banner1.jpg'); ?>" alt="">
                </div>
                
                <div class="st-pusher">
                    <div class="st-content">
                        <div class="st-content-inner t1-head-space-area">
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
                                        <div class="d-inline-block">
                                            <!-- Navbar toggler  -->
                                            <button class="navbar-toggler hamburger hamburger-js hamburger--spring" type="button" data-toggle="collapse" data-target="#navbar_main" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="hamburger-box">
                                            <span class="hamburger-inner"></span>
                                            </span>
                                            </button>
                                        </div>
                                        <div class="collapse navbar-collapse align-items-center justify-content-end" id="navbar_main">
                                            <!-- Navbar links -->
                                            <ul class="navbar-nav t1-nav-right" data-hover="dropdown">
                                               
                                               
                                                <li class="custom-nav login-menu t1-m-left">
                                                    <a class="login-btn" href="#">Login</a>
                                                </li>
                                                <li class="custom-nav login-menu">
                                                    <a class="login-btn" href="#">Register</a>
                                                </li>
                                            </ul>
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
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                           <div class="area-banner-left-form">
                               <div class="blan-area-top">
                                 <div class="arrow-down t1-p-arrow-down"></div>
                               </div>
                            <form class="form-inverse mt-4 t1-form-get-start-area" data-toggle="validator" role="form" action="<?=base_url()?>home/listing/home_search" method="POST" style="margin-top: 0px !important;">
                                    <h3 class="heading heading-5 strong-500 text-capitalize"><?=$home_searching_heading?></h3>
                                   
                                    <div class="row t1-form-1st-row">
                                        <div class="col-sm-12">
                                            <div class="form-group has-feedback">
                                                <label class="text-uppercase"><?php echo translate("i'm_looking_for_a")?> <span class="t1-gender-form"> <input type="radio" name="gender" value="1"> Male  <input type="radio" name="gender" value="2"> Female </span></label>
                                               
                                                <span class="help-block with-errors"></span>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group has-feedback t1-mrg-rmv-0">
                                                <label for="" class="text-uppercase"><?php echo translate('aged_from')?></label>
                                                 <select class="form-control form-control-t1" name="age" id="">
                                                     <?php  for ($i=18; $i < 60; $i++) { ?>
                                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                     <?php } ?>
                                                 </select>
                                                <div class="help-block with-errors">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group has-feedback t1-mrg-rmv-0">
                                                <label for="" class="text-uppercase"><?php echo translate('to')?></label>
                                                <select class="form-control form-control-t1" name="age" id="">
                                                     <?php  for ($i=19; $i < 61; $i++) { ?>
                                                     <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                     <?php } ?>
                                                 </select>
                                            </div>
                                            <div class="help-block with-errors">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($this->db->get_where('frontend_settings', array('type' => 'spiritual_and_social_background'))->row()->value == "yes") {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group has-feedback">
                                                <label for="" class="text-uppercase"><?php echo translate('religion')?></label>
                                                <?= $this->Crud_model->select_html('religion', 'religion', 'name', 'edit', 'form-control form-control-t1  form-control-sm selectpicker s_religion', '', '', '', ''); ?>
                                                <div class="help-block with-errors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($this->db->get_where('frontend_settings', array('type' => 'language'))->row()->value == "yes") {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group has-feedback">
                                                <label for="" class="text-uppercase"><?php echo translate('mother_tongue')?></label>
                                                <?= $this->Crud_model->select_html('language', 'language', 'name', 'edit', 'form-control form-control-t1 form-control-sm selectpicker', '', '', '', ''); ?>
                                                <div class="help-block with-errors">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                
                                    <button type="submit" class="btn btn-styled btn-sm btn-block btn-base-1 mt-4 t1-btn-g">Let's Start</button>
                                </form>
                           </div>
                        </div>
                    </div>
                    <div class="banner-spance-bottom-t1"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="st-container micro-banner-t1">
        <div class="container">
           <div class="row">
            <div class="col-md-4 ">
                    <div class="row">
                        <div class="col-md-2 col-xs-2 pad">
                            <img src="http://match.fivedit.com/upload/icon/fc/a.png">
                        </div>
                        <div class="col-md-10 col-xs-10 pad_left textvide">
                            Contact genuine profiles with 100% Verified Mobile Numbers
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4 ">
                    <div class="row">
                        <div class="col-md-2 col-xs-2 pad">
                            <img src="http://match.fivedit.com/upload/icon/fc/d.png">
                        </div>
                        <div class="col-md-10 col-xs-10 pad_left textvide">
                            Most Trusted Matrimony Brand <br>by the Brand Trust Report 2018
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4 ">
                    <div class="row">
                        <div class="col-md-2 col-xs-4 pad">
                            <img src="http://match.fivedit.com/upload/icon/fc/e.png">
                        </div>
                        <div class="col-md-10 col-xs-8 pad_left textvide">
                            Highest Number of Documented Marriages Online
                        </div>
                    </div>
                    
                </div>
           </div>
        </div>
    </div>

    <div class="st-container story-t1-slider">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <img src="http://match.fivedit.com/uploads/12717599-1573050153010906-7984201916195313143-n_15_41995.jpg" />
                        <div class="overclaa">
                            <h4>Shahin &amp; Obonti story</h4>
                            <p>Thanks to bebaha.com for this wonderful platform which helped me to find my soulmate.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="http://match.fivedit.com/uploads/12717599-1573050153010906-7984201916195313143-n_15_41995.jpg" />
                        <div class="overclaa">
                            <h4>Shahin &amp; Obonti story</h4>
                            <p>Thanks to bebaha.com for this wonderful platform which helped me to find my soulmate.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="http://match.fivedit.com/uploads/12717599-1573050153010906-7984201916195313143-n_15_41995.jpg" />
                        <div class="overclaa">
                            <h4>Shahin &amp; Obonti story</h4>
                            <p>Thanks to bebaha.com for this wonderful platform which helped me to find my soulmate.</p>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <div class="st-container make-story-area">
        <h3>Make Your Story... <a class="btn-area keychainify-checked" href="#">Start</a></h3>
    </div>

    <div style="" class="st-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6  t1-assised-pd_0">
                    <b><h1 class="heder_by_des">Assisted Service </h1></b> 
                <h3 class="banner_sort">A personalised Matchmaking Service from Kenya </h3> 
                <p class="banner_pera"> Our Relationship Managers have helped thousands of members find their perfect life partners </p>
                </div>
                <div class="col-md-6 move pd_0">
                    <img src="http://match.fivedit.com/upload/img1/service.jpg" />
                </div>
            </div>
           
        </div>
    </div>
    <div class="st-container banner-bottom t1-sm-contct">
        <h3>About Assitance Service... <a  class="btn-area" target="_blank" href="#">Contact us</a></h3>
    </div>
    <div class="st-container">
        <div class="container text-center t1-about-pd_0">
            <div class="Saitbd_red_logo">
                <?php 
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
            </div>
            <div class="footer_para">
                Abc.com, is an international matrimonial web Portal aimed at fulfilling the needs of Bangladeshis both at home and abroad. It is designed to provide its members a secured and private environment to find their ultimate life partners by providing them a trusted source of genuine people trying to find their soul mates. The platform ABC.com allows members to search, communicate, chat and finally find the right person for them or their loved ones.
            </div>
            
        </div>
        <div class="container">
            <div class="container-fluid footermenu">
                <a target="_blank" href="#" class="keychainify-checked">ABC.com</a> |
                <a target="_blank" href="#" class="keychainify-checked">Member Login</a> | 
                <a target="_blank" href="#" class="keychainify-checked">Signup</a> |
                <a target="_blank" href="" class="keychainify-checked">Customer Suport</a> |
                <a target="_blank" href="#" class="keychainify-checked">Terms </a> | 
                <a target="_blank" href="#" class="keychainify-checked">Privacy</a> |
                <a target="_blank" href="#" class="keychainify-checked">Refund</a> |
                <!--<a target="_blank" href="http://match.fivedit.com/contact">Contact Us </a> | -->
            <a target="_blank" href="#" class="keychainify-checked">Help Disk</a> | 
            <a target="_blank" href="#" class="keychainify-checked">Be Safe Online</a> | 
                <a href="#" class="keychainify-checked">Facebook</a>
            </div>
        </div>
    </div>
    <div class="st-container banner-bottom t1-sm-contct-footer-bottom">
        <h5>Design and Develop By  <a  class="btn-area" target="_blank" href="#">ABC.com </a>team</h5>
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
</script>
