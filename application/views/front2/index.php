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
                
                <div class="st-pusher  t1-st-bg-hover">
                    <div class="st-content">
                        <div class="st-content-inner t1-head-space-area">
                            <!-- Navbar -->
                            <div id="myHeader" class="stk-ck-t1">
                               
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
                                           <div class="did-you-t1">
                                                 Are you already registered? <a href="<?php echo base_url(); ?>home/login" class="t1-login-btn-22"> LOGIN</a>
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
                    <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 t1-pa-rigt-0">
                            <img class="sub-banner-t1" src="<?php echo base_url('uploads/home_page/home_banner/photo-desktop-m-2x.jpg'); ?>" alt="">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 t1-pad-left-0">
                           <div class="area-banner-left-form web-loader-gf">
                           <div class="loader-area">
                                <div class="loader"></div>
                           </div>
                               
                               <div class="t1-h2-clz">
                                <h2 class="content__slogan slogan slogan--desktop">
                                    Register <br>
                                    and meet people! </h2>
                               </div>
                               <div class="">
                                    <form action="<?php echo base_url(); ?>home/formSubmitOne" method="post" id="formSubmitOne">
                                        <div class="person-form js-page js-page-1 js-active-page" data-step-id="42">
                                            <div class="person-form__item person-gender">
                                                <div class="person-form__container">
                                                    <span class="label-text">I am a:</span>
                                                <div class="person-gender__items-wrapper person-form__content">
                                                    <div class="person-gender__item js-gender-err">
                                                        <input class="person-gender__input js-gender-input" required type="radio" name="person-gender" id="person-male" value="1" >
                                                        <label class="person-gender__label js-gender-err" for="person-male">Man</label>
                                                    </div>
                                                    <div class="person-gender__item js-gender-err">
                                                        <input class="person-gender__input js-gender-input" required type="radio" name="person-gender" id="person-female" value="2" >
                                                        <label class="person-gender__label js-gender-err" for="person-female">Woman</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="person-form__item person-name">
                                            <div class="person-form__container">
                                                <label class="label-text " for="person-name">Your name:</label>
                                                <div class="person-name__item image-wrapper person-form__content">
                                                    <input class="person-form__input" type="text" required name="first_name" id="person-name" placeholder="First name" >
                                                    <input class="person-form__input" type="text" required name="last_name" id="person-name" placeholder="Last name" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="person-form__item person-birth">
                                            <div class="person-form__container">
                                                <span class="personal-form__label label-text">Date of <br> birth:</span>
                                                <div class="js-input-select birth-date person-form__content">
                                                    <select class="birth-date__input person-form__input person-form__input--date" required name="birth-day" id="birth-day">
                                                    <option class="select-item" selected="" value="" disabled="">DD</option>
                                                    <?php for ($i=1; $i < 31; $i++) {  ?>
                                                        <option class="select-item" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <select class="birth-date__input person-form__input person-form__input--date" required name="birth-month" id="birth-month">
                                                        <option class="select-item select-item--disabled" value="" selected="" disabled="">ММ</option>
                                                        <?php for ($i=1; $i < 13; $i++) {  ?>
                                                            <option class="select-item" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select class="birth-date__input person-form__input person-form__input--date" required name="birth-year" id="birth-year">
                                                        <option class="select-item" selected="" value="" disabled="">YYYY</option>
                                                        <?php for ($i=1971; $i < 2004; $i++) {  ?>
                                                        <option class="select-item" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="person-form__button-main button-main js-switch-button" id="formSubmitOne_button" type="submit">Continue</button>
                                        <a href="<?php  echo base_url('home/login'); ?>" class="lgn-btn-home">Login</a>
                                    </form>
                                </div>
                                <div class>
                                    <form action="<?php echo base_url(); ?>home/registration/add_info" method="post" id="formSubmitTwo">
                                            <div class="person-form js-page js-page-1 js-active-page" data-step-id="42">
                                                <div class="person-form__item person-name mrgrmv">
                                                    <div class="person-form__container">
                                                        <label class="label-text " for="person-name">E-mail:</label>
                                                        <div class="person-name__item image-wrapper person-form__content">
                                                            <input class="person-form__input-email" type="email" required name="email"  placeholder="Email" >
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="person-form__item person-name mrgrmv">
                                                    <div class="person-form__container">
                                                        <label class="label-text " for="person-name">Phone:</label>
                                                        <div class="person-name__item image-wrapper person-form__content">
                                                            <input class="person-form__input-email" type="text" required name="mobile"  placeholder="Phone" >
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="person-form__item person-name mrgrmv">
                                                    <div class="person-form__container">
                                                        <label class="label-text " for="person-name">On Behalf:</label>
                                                        <div class="person-name__item image-wrapper person-form__content">
                                                            <select name="on_behalf"  class="form-control form-control-sm selectpicker on_behalf" required data-placeholder="Choose a on_behalf" tabindex="2" data-hide-disabled="true">
                                                                <option value="">Choose one</option>
                                                                <option value="1">Self</option>
                                                                <option value="2">Daughter/Son</option>
                                                                <option value="3">Sister</option>
                                                                <option value="4">Brother</option>
                                                                <option value="5">Friend</option>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
                                        if($member_approval == 'yes'){ ?>
                                            <input name="approval_status" value="pending" hidden="">
                                        <?php } else { ?>
                                            <input name="approval_status" value="approved" hidden="">
                                    <?php } ?>
                                                <div class="person-form__item person-gender-pass">
                                                    <div class="person-form__container">
                                                        <span class="label-text">Password:</span>
                                                        <div class="person-gender__items-wrapper person-form__content">
                                                            <div class="person-gender__item js-gender-err">
                                                                <input type="password" class="form-control form-control-sm pass-t1-re" required name="password" placeholder="Password">
                                                            </div>
                                                            <div class="person-gender__item js-gender-err">
                                                                <input type="password" class="form-control form-control-sm pass-t1-re pass-t1-re1" required name="confirm_password" placeholder="Confirm Password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="person-form__button-main button-main js-switch-button" id="formSubmitTwo_button" type="submit">Register</button>
                                            <a href="<?php  echo base_url('home/login'); ?>" class="lgn-btn-home regi-btn-lg">Login</a>
                                   
                                        </form>
                                </div>
                            </div>
                                

                                <div class="banners-block">
                                    <div class="banners-block__wrapper">
                                    <?php  if (file_exists('uploads/header_logo/'.$header_logo[0]['image'])) {
                                                ?>
                                                    <img src="<?=base_url()?>uploads/header_logo/<?=$header_logo[0]['image']?>" class="img-responsive c100px" height="100%">
                                                <?php
                                                }
                                                else {
                                                ?>
                                                    <img src="<?=base_url()?>uploads/header_logo/default_image.png" class="img-responsive c100px" height="100%">
                                                <?php
                                                } ?>
                                </div>
                                    <a class="banners-block__text js-why-link keychainify-checked" href="#">Why us?</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="banner-spance-bottom-t1"></div>
                </div>
            </div>
        </div>

    </div>
   
    <div class="st-container">
        <div class="container">
            <div class="">
                <div class="learn-more">
                <div class="learn-more__container container">
                    <h2 class="learn-more__why-header slogan">Why <span class="domain-name">MFOUNDLOVE</span>?</h2>
                    <p class="learn-more__why-text why-text">Here, you will find the person who is a <br>
                    truly good match for you!</p>
                        
                    <div class="row">
                        <div class="col-md-4">
                            <div class="b-t1-wrap">
                                <img class="advantages-list__image desktop-only" src="<?php  echo base_url('uploads/home_page/home_banner/photo-1-xl.jpg'); ?>"  alt="Picture of match №1">
                                <img class="advantages-list__icon" src="<?php  echo base_url('uploads/home_page/home_banner/profile.svg'); ?>" alt="Profile">
                                <p class="advantages-list__text">
                                <b class="dark-colored"> More than 300 000 profiles of </b> real people on our site! </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="b-t1-wrap">
                                <img class="advantages-list__image desktop-only" src="<?php  echo base_url('uploads/home_page/home_banner/photo-2-xl.jpg'); ?>"  alt="Picture of match №2">
                                <img class="advantages-list__icon" src="<?php  echo base_url('uploads/home_page/home_banner/filters.svg'); ?>" alt="Filters">
                                <p class="advantages-list__text">
                                <b class="dark-colored"> Search filters </b> — search for matches by city and interests. </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="b-t1-wrap">
                                <img class="advantages-list__image desktop-only" src="<?php  echo base_url('uploads/home_page/home_banner/photo-3-xl.jpg'); ?>"  alt="Picture of match №3">
                                <img class="advantages-list__icon" src="<?php  echo base_url('uploads/home_page/home_banner/safety.svg'); ?>" alt="Security">
                                <p class="advantages-list__text">
                                We guarantee <b class="dark-colored"> anonymity </b> and <b class="dark-colored"> security. </b> </p>
                            </div>
                        </div>
                    </div>

                   
                    </div>
                    <div class="btn-complete-btn">
                        <a class="learn-more__create-profile-btn js-create-profile-btn button-main button-main--create-profile keychainify-checked" href="#">Create profile</a>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
    <footer>
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
    var dataX={};
    $(document).ready(function(){
        $('#formSubmitOne').submit(function(){
            $('.loader-area').css({display:"block"});
            $.ajax({
                type:"POST",
                url:$('#formSubmitOne').attr('action'),
                data:$('#formSubmitOne').serialize(),
                dataType:"json",
                success:function(response){
                    dataX =response
                    $('.loader-area').css({display:"none"});
                    $('#formSubmitOne').css({display:"none"});
                    $('#formSubmitTwo').css({display:"block"});
                }
            });
            return false;
        });
        $('#formSubmitTwo').submit(function(){
            
            var d = $('#formSubmitTwo').serialize();
            const tt = new URLSearchParams(dataX).toString();
            $('.loader-area').css({display:"block"});
            $.ajax({
                type:"POST",
                url:$('#formSubmitTwo').attr('action'),
                data:d+'&'+tt,
                dataType:"json",
                success:function(response){
                    if(response.status){
                        myFunction(response.msg);
                        window.location.href= '<?php echo base_url(); ?>home/login';
                    }else{
                        myFunctionError(response.msg);
                    }
                    
                    $('.loader-area').css({display:"none"});
                    
                }
            });
            return false;
        });
        
    });
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
