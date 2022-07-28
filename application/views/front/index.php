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
    <?php include 'preloader.php';?>
    <div class="container">
        <div class="row">
            <!-- Alerts for Member actions -->
            <div class="col-lg-3 col-md-4" id="success_alert" style="display: none; position: fixed; top: 15px; right: 0; z-index: 9999">
                <div class="alert alert-success fade show" role="alert">
                    <!-- Success Alert Content -->
                </div>
            </div>
            <div class="col-lg-3 col-md-4" id="danger_alert" style="display: none; position: fixed; top: 15px; right: 0; z-index: 9999">
                <div class="alert alert-danger fade show" role="alert">
                    <!-- Danger Alert Content -->
                </div>
            </div>
            <!-- Alerts for Member actions -->
        </div>
    </div>
	<?php
		include_once 'header/header.php';
		include_once $page.'/index.php';
		include_once 'footer/footer.php';
		include_once 'includes/bottom/'.$bottom;
	?>
	<a href="#" class="btn-shadow back-to-top btn-back-to-top"></a>
	<button class="open_modal" style="display: none"><?php echo translate('open')?></button>
    <!------Global Chat------->
    <?php 
    $user_id = $this->session->userdata('member_id');
    if($page != 'profile/dashboard' && !empty($user_id)){ ?>
        <div class="direct-chat-contacts global-user-chat-list">
            <ul class="contacts-list">
                <div class="pt-3 pb-2 text-center global-chat-header" style="border-bottom: 1px solid rgba(0, 0, 0, .15); margin: 0; width: 90% !important; margin-left: 5%;">
                    <h4 class="card-inner-title global-chat-icon">
                    <i class="fa fa-comments-o"></i> <?php echo translate('Chat')?></h4>
                    <span class="global-cross-icon">
                    <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </div>
                <?php foreach ($listed_messaging_members as $listed_member): ?>
                    <?php if ($this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row()->member_id):
                        
                        $member_info = $this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row();
                        if ($member_info->is_closed=='no') {
                    ?>
                        <li>
                            <a onclick="open_message_box(<?=$listed_member['message_thread_id']?>,this)" id="thread_<?=$listed_member['message_thread_id']?>">
                                <?php
                                    $images = json_decode($member_info->profile_image, true);
                                    if (file_exists('uploads/profile_image/'.$images[0]['thumb'])) {
                                    ?>
                                        <img class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/<?=$images[0]['thumb']?>">
                                    <?php
                                    }
                                    else {
                                    ?>
                                        <img class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/default_image.png">
                                    <?php
                                    }
                                ?>
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name" data-member="<?=$member_info->member_id?>">
                                        <?=$member_info->first_name.' '.$member_info->last_name?>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </div>
    <!----Global chat box------>
        <div class="card direct-chat direct-chat-warning global-user-chat-box">
            <div class="card-header with-border with-border-global">
                <h3 class="card-inner-title pull-left c-base-1">
                    <i class="fa fa-comments-o"></i> <span id="msg_box_header"><?php echo translate('select_a_member')?></span>
                </h3>
                <div class="pull-right">
                    <small id="msg_refresh">
                    </small>
                </div>
            </div>
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" id="msg_body" style="height: 100px">
                    <p class="c-base-1 pt-4 text-center">"<?php echo translate('select_a_member_from_the_contact_list_to_start_messaging')?>"</p>
                </div>
                <!-- Contacts are loaded here -->
            </div>
            <div class="card-footer" style="padding: 8px;">
                <form class="form-default" id="message_form" method="post">
                    <div class="input-group">
                        <input type="text" id="message_text" name="message_text" placeholder="Type Message ..." value="" class="form-control" style="z-index: 2;" >
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-base-1 btn-flat enterer" id="msg_send_btn" style="width: 60px" ><?php echo translate('send')?></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

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

<!---Global chat script-->
<?php if($page != 'profile/dashboard' && !empty($user_id)){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.global-cross-icon').click(function(){
                $('.global-user-chat-list').css({display:"none"})
                $('.global-chat-open-icon').css({display:"block"});
                $('.global-user-chat-box').css({display:"none"});
        });
        $('.global-chat-open-icon').click(function(){
            $('.global-user-chat-list').css({display:"block"});
            $('.global-chat-open-icon').css({display:"none"});
        })
    });
</script>
<script type="text/javascript">
    function open_message_box(thread_id, now){
        $('.global-user-chat-box').css({display:"block"});
        $("#msg_body").html("<div class='text-center' id='payment_loader'><i class='fa fa-refresh fa-5x fa-spin'></i></div>");
        $("#msg_box_header").html("<a class='c-base-1' target='_blank' href='<?=base_url()?>home/member_profile/"+$(now).find('.contacts-list-name').data('member')+"'>"+$(now).find('.contacts-list-name').html()+"</a>");
        $("#msg_refresh").html("<a onclick='refresh_msg("+thread_id+")'><i class='fa fa-refresh'></i> <?=translate('refresh')?></a>");
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>home/get_messages/"+thread_id,
            cache: false,
            success: function(response) {
                clearInterval(message_interval);
                var message_interval =  setInterval(function(){
                                            $("#msg_body").load('<?=base_url()?>home/get_messages/'+thread_id);
                                        }, 4000);
                $("#msg_body").removeAttr("style");
                // $("#message_text").removeAttr('disabled');
                $("#message_text").val('');
                $("#msg_body").html(response);
            }
        });
    }
    function msg_send(thread, from, to){
        if ($("#message_text").val().length != 0) {
            var form_data = ($("#message_form").serialize());
            $("#message_text").attr('disabled', 'disabled');
            $("#msg_send_btn").attr('disabled', 'disabled');
            $("#msg_send_btn").html("<i class='fa fa-refresh fa-spin'></i>");

            $.ajax({
                type: "POST",
                url: "<?=base_url()?>home/send_message/"+thread+"/"+from+"/"+to,
                data: form_data,
                success: function(response) {
                    // alert('done');
                    $("#message_text").removeAttr('disabled');
                    $("#msg_send_btn").removeAttr('disabled');
                    $("#message_text").val('');
                    const html_btn = "<?php echo translate('send')?>";
                    $("#msg_send_btn").html(html_btn);
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>home/get_messages/"+thread,
                        cache: false,
                        success: function(response) {
                            $("#msg_body").html(response);
                        }
                    });
                }
            });
        }
    }
    function refresh_msg(thread_id){
        $(".contacts-list").find("#thread_"+thread_id).click();
    }
</script>
<?php } ?>
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
