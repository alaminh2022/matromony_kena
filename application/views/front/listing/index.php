<style>
    @media (max-width: 576px) {
        .listing-image {
            height: 330px !important;
        }
    }

</style>
<section class="page-title page-title--style-1">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h2 class="heading heading-3 strong-400 mb-0"><?php echo translate('active_members')?></h2>
            </div>
        </div>
    </div>
</section>
<section class="slice sct-color-1">
    <div class="container-fluid">
        <div class="row">
			<?php  $advance_search_position = $this->db->get_where('frontend_settings', array('type' => 'advance_search_position'))->row()->value;

            if($advance_search_position=='left'){
                include_once'filter.php'; ?>
                <div class="col-lg-9">

                    <input type="hidden" id="member_type" value="<?php if(!empty($member_type)){echo $member_type;}?>">

                    <div class="block-wrapper row" id="result">
                        <!-- Loads List Data with Ajax Pagination -->
                    </div>
                    <div id="pagination" style="float: right;">
                        <!-- Loads Ajax Pagination Links -->
                    </div>
                </div>
            <?php }else{ ?>
                 <div class="col-lg-9">

                    <input type="hidden" id="member_type" value="<?php if(!empty($member_type)){echo $member_type;}?>">

                    <div class="block-wrapper row" id="result">
                        <!-- Loads List Data with Ajax Pagination -->
                    </div>
                    <div id="pagination" style="float: right;">
                        <!-- Loads Ajax Pagination Links -->
                    </div>
                </div>
            <?php include_once'filter.php'; } ?>
        </div>
    </div>
</section>
<script>
    var isloggedin = "<?=$this->session->userdata('member_id')?>";
    var rem_interests = parseInt("<?=$this->Crud_model->get_type_name_by_id('member', $this->session->userdata('member_id'), 'express_interest')?>");
    var rem_messages = parseInt("<?=$this->Crud_model->get_type_name_by_id('member', $this->session->userdata('member_id'), 'direct_messages')?>");

    function confirm_message(id) {
        // alert(id);
        if (isloggedin == "") {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("<?php echo translate('please_log_in');?>");
            $("#modal_body").html("<p class='text-center'><?php echo translate('please_log_in_to_enable_messaging');?></p>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close');?></button> <a href='<?=base_url()?>home/login' class='btn btn-sm btn-base-1 btn-shadow' style='width:25%'><?php echo translate('log_in');?></a>");
        }
        else {
            if (rem_messages <= 0) {
                $("#active_modal").modal("toggle");
                $("#modal_header").html("<?php echo translate('buy_premium_packages');?>");
                $("#modal_body").html("<p class='text-center'><b><?php echo translate('remaining_direct_message(s):');?>"+rem_messages+" <?php echo translate('times');?></b><br><?php echo translate('please_buy_packages_from_the_premium_plans');?></p>");
                $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close');?></button> <a href='<?=base_url()?>home/plans' class='btn btn-sm btn-base-1 btn-shadow' style='width:25%'><?php echo translate('premium_plans');?></a>");
            }
            else {
                $("#active_modal").modal("toggle");
                $("#modal_header").html("<?php echo translate('confirm_enable_messaging');?>");
                $("#modal_body").html("<p class='text-center'><b><?php echo translate('remaining_direct_message(s):');?>"+rem_messages+" <?php echo translate('times');?></b><br><span style='color:#DC0330;font-size:11px'>**N.B. <?php echo translate('enable_messaging_will_cost_1_from_your_remaining_direct_messages');?>**</span></p>");
                $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close');?></button> <a href='#' id='confirm_message' class='btn btn-sm btn-base-1 btn-shadow' onclick='return enable_message("+id+")' style='width:25%'><?php echo translate('confirm');?></a>");
            }
        }
        return false;
    }
    function enable_message(id) {
        if (isloggedin == "") {
            $("#active_modal").modal("toggle");
            $("#modal_header").html("<?php echo translate('please_log_in');?>");
            $("#modal_body").html("<p class='text-center'><?php echo translate('please_log_in_to_enable_messaging');?></p>");
            $("#modal_buttons").html("<button type='button' class='btn btn-danger btn-sm btn-shadow' data-dismiss='modal' style='width:25%'><?php echo translate('close');?></button> <a href='<?=base_url()?>home/login' class='btn btn-sm btn-base-1 btn-shadow' style='width:25%'><?php echo translate('log_in');?></a>");
        }
        else {
            $("#message_a_"+id).addClass("li_active");
            $("#confirm_message").removeAttr("onclick");
            $("#confirm_message").html("<i class='fa fa-refresh fa-spin'></i> <?php echo translate('processing');?>..");
            $("#message_a_"+id).removeAttr("onclick");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>home/enable_message/"+id,
                    cache: false,
                    success: function(response) {
                        $("#active_modal .close").click();
                        $("#message_text").html("<i class='fa fa-comments-o'></i><?php echo translate('message_enabled');?>");
                        $("#message_a_"+id).css("cssText", "");
                        $("#success_alert").show();
                        $(".alert-success").html("<?php echo translate('you_have_enable_messaging_with_this_member!');?>");
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
        return false;
    }
</script>
<script>
    $(document).ready(function(){
        $("#filter_aged_from").change(function(){
            var from = parseInt($("#filter_aged_from").val());
            var to = parseInt($("#filter_aged_to").val());
            if (to < from) {
                var to = $("#filter_aged_to").val(from);
            }
        });
        $("#filter_aged_to").change(function(){
            var from = parseInt($("#filter_aged_from").val());
            var to = parseInt($("#filter_aged_to").val());
            if (to < from) {
                var to = $("#filter_aged_to").val(from);
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        $(".height_mask").inputmask({
            mask: "9.99",
            greedy: false,
            definitions: {
                '*': {
                    validator: "[0-9]"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        var home_search = "<?=$home_search?>";
        var home_religion = "<?=$home_religion?>";

        var home_caste = "<?=$home_caste?>";
        var home_sub_caste = "<?=$home_sub_caste?>";
        if (home_caste != null) {
            $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id_caste/caste/religion_id/"+home_religion+"/"+home_caste, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,
                success: function(data) {

                    $(".s_caste").html(data);
                    $("#sub_caste").css("display", "none");

                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
        if (home_sub_caste != null) {

             $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id_sub_caste/sub_caste/caste_id/"+home_caste+"/"+home_sub_caste, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,

                success: function (data) {

                    if(data == false ){

                       $("#sub_caste").css("display", "none");
                    } else {
                      $(".s_sub_caste").html(data);
                       $("#sub_caste").css("display", "block");
                    };
               },
                error: function(e) {
                    console.log(e)
                }
            });
        }
        if (home_search == "false") {
            filter_members('0');
        }
        if (home_search == "true") {
            filter_members('0', 'search');
        }

    });

    function filter_members(page, type){
        if (type == 'search')
        {
            var url = '<?php echo base_url(); ?>home/ajax_member_list/'+page+'/'+type;
        }
        else {
            var member_type = "";
            if ($("#member_type").val() != "") {
                member_type = $("#member_type").val();
            }
            // alert($("#member_type").val());
            //var url = form.attr('action')+page+'/';
            var url = '<?php echo base_url(); ?>home/ajax_member_list/'+page+'/'+member_type;
        }
        var form = $('#filter_form');
        var place = $('#result');
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $(".btn-back-to-top").click();
        $.ajax({
            url: url, // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                place.html("");
                place.html("<div class='text-center pt-5 pb-5' id='payment_loader'><i class='fa fa-refresh fa-5x fa-spin'></i><p>Please Wait...</p></div>").fadeIn();
            },
            success: function(data) {
                var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                if (width <= 768) {
                    $(".size-sm").css("display", "none");
                    $(".size-sm-btn").css("display", "block");
                }
                setTimeout(function(){
                    place.html(data);// fade in response data
                }, 20);
                setTimeout(function(){
                    place.fadeIn(); // fade in response data
                }, 30);
            },
            error: function(e) {
                console.log(e)
            }
        });
    }

    function adv_search(){
        $(".size-sm").css("display", "block");
        $(".size-sm-btn").css("display", "none");
    }

    $(".s_country").change(function(){
        var country_id = $(".s_country").val();
        if (country_id == "") {
            $(".s_state").html("<option value=''><?php echo translate('choose_a_country_first')?></option>");
            $(".s_city").html("<option value=''><?php echo translate('choose_a_state_first')?></option>");
        } else {
            $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id/state/country_id/"+country_id, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,
                success: function(data) {
                    $(".s_state").html(data);
                    $(".s_city").html("<option value=''><?php echo translate('choose_a_state_first')?></option>");
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
    });

    $(".s_state").change(function(){
        var state_id = $(".s_state").val();
        if (state_id == "") {
            $(".s_city").html("<option value=''><?php echo translate('choose_a_state_first')?></option>");
        } else {
            $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id/city/state_id/"+state_id, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,
                success: function(data) {
                    $(".s_city").html(data);
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
    });

    $(".s_religion").change(function(){
        var religion_id = $(".s_religion").val();
        if (religion_id == "") {
            $(".s_caste").html("<option value=''><?php echo translate('choose_a_religion_first')?></option>");
            $(".s_sub_caste").html("<option value=''><?php echo translate('choose_a_caste_first')?></option>");
        } else {
            $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id_caste/caste/religion_id/"+religion_id, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,
                success: function(data) {

                    $(".s_caste").html(data);
                    $(".s_sub_caste").html("<option value=''><?php echo translate('choose_a_caste_first')?></option>");
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
    });

    $(".s_caste").change(function(){
        var caste_id = $(".s_caste").val();
        if (caste_id == "") {
            $(".s_sub_caste").html("<option value=''><?php echo translate('choose_a_caste_first')?></option>");
        } else {
            $.ajax({
                url: "<?=base_url()?>home/get_dropdown_by_id_sub_caste/sub_caste/caste_id/"+caste_id, // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                cache       : false,
                contentType : false,
                processData : false,
                success: function (data) {
                    if(data == false ){
                        $(".s_sub_caste").html("<option value=''><?php echo translate('none')?></option>");
                    } else {
                        $(".s_sub_caste").html(data);
                    };
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
    });
</script>
<script>
function open_message_box_global(thread_id, now){
        $('.global-user-chat-box').css({display:"block"});
        $("#msg_body").html("<div class='text-center' id='payment_loader'><i class='fa fa-refresh fa-5x fa-spin'></i></div>");
        $("#msg_box_header").html("<a class='c-base-1' target='_blank' href='<?=base_url()?>home/member_profile/"+$('#thread_global_'+thread_id).attr('data-memberID')+"'>"+$('#thread_global_'+thread_id).attr('data-memberName')+"</a>");
        $("#msg_refresh").html("<a onclick='refresh_msg("+thread_id+")'><i class='fa fa-refresh'></i> <?=translate('refresh')?></a>");
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>home/get_messages/"+thread_id,
            cache: false,
            success: function(response) {
                // clearInterval(message_interval);
                // var message_interval =  setInterval(function(){
                //                             $("#msg_body").load('<?=base_url()?>home/get_messages/'+thread_id);
                //                         }, 4000);
                $("#msg_body").removeAttr("style");
                // $("#message_text").removeAttr('disabled');
                $("#message_text").val('');
                $("#msg_body").html(response);
            }
        });
    }
    function open_blank_chat_message(id){
        $('.global-user-chat-box').css({display:"block"});
        
        $("#msg_box_header").html("<a class='c-base-1' target='_blank' href='<?=base_url()?>home/member_profile/"+id+"'>"+$('#nameinfo_'+id).html()+"</a>");
        $("#msg_refresh").html("<a onclick='chat_box_remove("+id+")'><i class='fa fa-times' aria-hidden='true'></i> </a>");
       
        $("#msg_body").removeAttr("style");
        $("#message_text").val('');
        $("#msg_body").html('');
        $('#msg_send_btn').attr('onclick', 'sendDummySms('+id+')');
                
    }
    function sendDummySms(id){
        
        $.ajax({
            method:"POST",
            url:'<?php echo base_url(); ?>home/get_dummy_messages/'+id,
            data:$('#message_form').serialize(),
            success:function(data){
                $('#message_text').val('');
                $("#msg_body").html(data);
            }
        });
        
    }
    function chat_box_remove(id){
        $('.global-user-chat-box').css({display:"none"});
    }
</script>
<style>
    /* xs */
    .size-sm {
        display: none;
    }
    .size-sm-btn {
        display: block;
    }
    /* sm */
    @media (min-width: 768px) {
        .size-sm {
            display: none;
        }
        .size-sm-btn {
            display: block;
        }
    }
    /* md */
    @media (min-width: 992px) {
        .size-sm {
            display: block;
        }
        .size-sm-btn {
            display: none;
        }
    }
    /* lg */
    @media (min-width: 1200px) {
        .size-sm {
            display: block;
        }
        .size-sm-btn {
            display: none;
        }
    }
</style>
