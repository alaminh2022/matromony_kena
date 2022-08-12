<?php 
    $user_id = $this->session->userdata('member_id');
    $thread_info = $this->db->get_where('message_thread', array('message_thread_id' => $message_thread_id))->row();

    $from_info = $this->db->get_where('member', array('member_id' => $user_id))->row();
  


    $from_image = json_decode($from_info->profile_image, true);
   
    if ($message_count >= 50) {
    ?>
        <div class="text-center"><small><a class="c-base-1" onclick="load_all_msg(<?=$message_thread_id?>)"><?=translate('show_all_messages')?></a></small></div>
    <?php
    }
   
        ?>
            <!-- Message. Default to the right -->
            <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">You<!-- <?=$from_info->first_name." ".$from_info->last_name?> --></span>
                    <span class="direct-chat-timestamp pull-left"><?=date('d M,y - h:i A')?></span>
                </div>
                <!-- /.direct-chat-info -->
                <?php 
                    if (file_exists('uploads/profile_image/'.$from_image[0]['thumb'])) {
                    ?>
                        <img class="direct-chat-img"  src="<?=base_url()?>uploads/profile_image/<?=$from_image[0]['thumb']?>">
                    <?php
                    }
                    else {
                    ?>
                        <img class="direct-chat-img"  src="<?=base_url()?>uploads/profile_image/default_image.png">
                    <?php
                    } 
                ?>
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text direct-chat-text-dummy">
                    <?=$message?>
                    
                </div>
                <div class="upgrade-message-in-chatbox">
                <p><a href="<?php echo base_url('home/plans'); ?>">Upgrade premium</a> for messages send and replies</p>
                </div>
                <!-- /.direct-chat-text -->
            </div>
        
