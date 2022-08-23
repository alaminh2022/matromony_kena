<?php 
    $user_id = $this->session->userdata('member_id');
    $getFromData = $this->db->order_by('message_id', 'desc')->get_where('message', array(
        'message_from'=>$user_id,
        'message_to'=>$toId
    ))->result();

    $getToData = $this->db->order_by('message_id', 'asc')->get_where('message', array(
        'message_from'=>$toId,
        'message_to'=>$user_id
    ))->row();

    $thread_info = $this->db->get_where('message_thread', array('message_thread_id' => $message_thread_id))->row();

    $from_info = $this->db->get_where('member', array('member_id' => $user_id))->row();
  


    $from_image = json_decode($from_info->profile_image, true);
   
    if($getToData->message_text){
        $to_info = $this->db->get_where('member', array('member_id'=>$toId))->row();
        $to_image = json_decode($to_info->profile_image, true);
    ?>
        
        <div class="direct-chat-msg ">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left"><?=$to_info->first_name." ".$to_info->last_name?></span>
                    <span class="direct-chat-timestamp pull-right"><?=date('d M,y - h:i A', $message->message_time)?></span>
                </div>
                <!-- /.direct-chat-info -->
                <a target="_blank" href="<?=base_url()?>home/member_profile/<?=$to_info->member_id?>">
                <?php 
                    if (file_exists('uploads/profile_image/'.$to_image[0]['thumb'])) {
                    ?>
                        <img class="direct-chat-img"  src="<?=base_url()?>uploads/profile_image/<?=$to_image[0]['thumb']?>">
                    <?php
                    }
                    else {
                    ?>
                        <img class="direct-chat-img"  src="<?=base_url()?>uploads/profile_image/default_image.png">
                    <?php
                    } 
                ?>
                </a>
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                     <?=$getToData->message_text?>
                </div>
                <!-- /.direct-chat-text -->
            </div>
    
    <?php
    }
    
    foreach($getFromData as $k=> $row){
        ?>
            <!-- Message. Default to the right -->
            <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right"><!-- <?=$from_info->first_name." ".$from_info->last_name?> --></span>
                    <span class="direct-chat-timestamp pull-right"><?=date('d M,y - h:i A', $row->message_time)?></span>

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
                    <?=$row->message_text?>
                    
                </div>
                
                <!-- /.direct-chat-text -->
            </div>
            <?php if($k == 0){ ?>
                <div class="upgrade-message-in-chatbox">
                <p><a href="<?php echo base_url('home/plans'); ?>">Upgrade premium</a>  to receive a reply</p>
                </div>
                <?php } ?>
        <?php } ?>
            

                
        
