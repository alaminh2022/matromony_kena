<script src="https://checkout.stripe.com/checkout.js"></script>
<section class="page-title page-title--style-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h2 class="heading heading-3 strong-400 mb-0"><?php echo translate('confirm_your_purchase')?></h2>
            </div>
        </div>
    </div>
</section>
<?php
    $background_image = $this->db->get_where('frontend_settings', array('type' => 'premium_plans_image'))->row()->value;
    $background_image_data = json_decode($background_image, true);

    // cp is the short form of Custom Payment
    $cp_method_1_set =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_1_set' ))->row()->value;
    $cp_method_1_name =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_1_name' ))->row()->value;
    $cp_method_1_number =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_1_number' ))->row()->value;
    $cp_method_1_instruction =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_1_instruction' ))->row()->value;

    $cp_method_2_set =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_2_set' ))->row()->value;
    $cp_method_2_name =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_2_name' ))->row()->value;
    $cp_method_2_number =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_2_number' ))->row()->value;
    $cp_method_2_instruction =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_2_instruction' ))->row()->value;

    $cp_method_3_set =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_set' ))->row()->value;
    $cp_method_3_name =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_name' ))->row()->value;
    $cp_method_3_number =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_number' ))->row()->value;
    $cp_method_3_instruction =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_instruction' ))->row()->value;

    $cp_method_4_set =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_4_set' ))->row()->value;
    $cp_method_4_name =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_4_name' ))->row()->value;
    $cp_method_4_number =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_4_number' ))->row()->value;
    $cp_method_4_instruction =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_4_instruction' ))->row()->value;

?>
<section class="slice sct-color-1 pricing-plans pricing-plans--style-1 has-bg-cover bg-size-cover" style="background-image: url(<?=base_url()?>uploads/premium_plans_image/<?=$background_image_data[0]['image']?>); background-position: bottom bottom;">
    <div class="container">
        <span class="clearfix"></span>
        <div class="row">
            <?php foreach ($selected_plan as $value): ?>
                <div class="col-sm-8 col-md-4 ml-auto mr-auto">
                    <?php if ($value->plan_id == 1) { $package_class = "text-line-through"; } else { $package_class = "active"; } ?>
                    <div class="feature feature--boxed-border feature--bg-2 active package_bg mt-4">
                        <div class="icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-dark">
                                <li style="list-style-type: none;">
                                <?php
                                    $image = $value->image;
                                    $images = json_decode($image, true);
                                    if (file_exists('uploads/plan_image/'.$images[0]['thumb'])) {
                                    ?>
                                        <img src="<?=base_url()?>uploads/plan_image/<?=$images[0]['thumb']?>" class="img-sm" height="100">
                                    <?php
                                    }
                                    else {
                                    ?>
                                        <img src="<?=base_url()?>uploads/plan_image/default_image.png" class="img-sm" height="100">
                                    <?php
                                    }
                                ?>
                                </li>
                            </div>
                            <div class="block-content">
                                <h3 class="heading heading-5 strong-500"><?=$value->name?></h3>
                                <h3 class="price-tag"><sup style="font-size: 36px;"></sup><?=currency($value->amount)?></h3>
                                <ul class="pl-0 pr-0 mt-0">
                                    <!-- <li class="package_items"><?php if($value->plan_id == 1){echo "Limited Profile Searching";}else{echo "Advanced Profile Searching";}?></li> -->
                                    <li class="<?=$package_class?> package_items"><?php echo translate('express_interest:')?> <?=$value->express_interest?> <?php echo translate('times')?></li>
                                    <li class="<?=$package_class?> package_items"><?php echo translate('direct_messages:')?> <?=$value->direct_messages?> <?php echo translate('times')?></li>
                                    <li class="<?=$package_class?> package_items"><?php echo translate('photo_gallery:')?> <?=$value->photo_gallery?> <?php echo translate('images')?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="pesapal_head_lock"></div>
                <div id="pesapalifrem" class="col-md-8 package_bg_light mt-4">
                
                </div>
                <div class="col-md-8 package_bg_light mt-4" id="pesapalifrem_other">
                    <?php if($this->db->get_where("member", array("member_id" => $this->session->userdata('member_id')))->row()->is_closed == 'yes'){?>
                        <div class="text-center py-5">
                        <h5 class="pt-5 pb-4 font_base"><?php echo translate('your_account_is_closed!_please_re-open_the_account_from_your_profile!')?></h5>
                        <div class="text-center pt-2 pb-4">
                            <a  href="<?=base_url()?>home/profile" class="btn btn-styled btn-sm btn-base-1 z-depth-2-bottom"><?php echo translate('go-to_your_profile')?></a>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="text-center">
                        <h4 class="pt-5 pb-4 font_base"><?php echo translate('Choose a payment method')?></h4>
                    </div>

                    <div class="row pb-4">
                        <div class="col-sm-12 ml-auto mr-auto">

                            <div class='text-center pt-5 pb-5' id="payment_loader" style="display: none;">
                                <i class='fa fa-refresh fa-5x fa-spin'></i>
                                <p class=""><?php echo translate('please_wait')?>...</p>
                            </div>

                            <div class="px-md-5" id="payment_section">
                                <style>
                                    .span-text {
                                        font-weight: 500;
                                        font-family: "Roboto Condensed", sans-serif;
                                        letter-spacing: 0.1rem;
                                        text-transform: uppercase;
                                        font-style: normal;
                                        text-align: center;
                                        font-size: 11px;
                                    }
                                    .payment-option {
                                        min-height: 52px;
                                    }
                                    .justify-between {
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.items-center {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.pointer {
    cursor: pointer;
}

.col-12 {
    width: 100%;
}
.flex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.icon-40 {
    width: 30px;
    height: 30px;
}

.green {
    color: #7faf41;
}
.icon-40 {
    width: 30px;
    height: 30px;
}
[type=radio]~.icon .unchecked {
    fill: #8c8c8c;
    color: #fff;
    display: block;
}[type=radio]~.icon .unchecked {
    fill: #8c8c8c;
    color: #fff;
    display: block;
}
[dir=ltr] .ms1 {
    margin-left: .5rem;
}
.circle {
    border-radius: 50%;
}
.relative {
    position: relative;
}
.flex-none {
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
}
.ms1 {
    color: #b11e21;
    font-size: 19px;
}


                                </style>
                                
                                
                                  <?php
                                  $mpesa_set = $this->db->get_where('business_settings', array('type' => 'mpesa_set'))->row()->value;
                                  if ($mpesa_set=="ok"): ?>
                                  <div  class="row">

                                        <div id="select_mpesa" class="mb2 pointer payment-option flex items-center" >
                                            <div class="flex items-center justify-between col-12">
                                                <label  class="pointer col-12">
                                                    <div class="flex items-center">
                                                        <input type="radio" name="mpesa" class=""  value="1" >
                                                        
                                                        <div class="col-5 me2">
                                                            <div class="ms1">
                                                                M-Pesa
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center col-8 ms2">
                                                            <img style="height: 102px;" src="<?=base_url()?>template/front/images/mpesa.png">
                                         
                                                        </div>
                                                    </div>
                                                </label>
                                                
                                                
                                            </div>
                                        </div>
                                    
                                    </div>
                                  <?php endif ?>
                                  <?php
                                  $dpo_set = $this->db->get_where('business_settings', array('type' => 'dpo_set'))->row()->value;
                                  if ($dpo_set=="ok"): ?>
                                   <div class="row">
                                        <div id="select_dpo" class="mb2 pointer payment-option flex items-center" data-only-show-this="credit">
                                            <div class="flex items-center justify-between col-12">
                                                <label  class="pointer col-12">
                                                    <div class="flex items-center">
                                                        <input type="radio" name="paymentMethod" class="changeCurrency" id="credit" value="1,1" >
                                                        
                                                        <div class="col-5 me2">
                                                            <div class="ms1">
                                                                DPO GROUP 
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center col-8 ms2">
                                                            
                                                                    <div class="bank-logo me1 flex items-center"><img class="fit" src="https://www.afrointroductions.com/assets/images/upgradeMembership/1.png"></div>
                                                                
                                                                    <div class="bank-logo me1 flex items-center"><img class="fit" src="https://www.afrointroductions.com/assets/images/upgradeMembership/2.png"></div>
                                                                
                                                                    <div class="bank-logo me1 flex items-center"><img class="fit" src="https://www.afrointroductions.com/assets/images/upgradeMembership/3.png"></div>
                                                                
                                                                    <div class="bank-logo me1 flex items-center"><img class="fit" src="https://www.afrointroductions.com/assets/images/upgradeMembership/132.png"></div>
                                                                
                                                        </div>
                                                    </div>
                                                </label>
                                                
                                            </div>
                                        </div>
                                     
                                    </div>
                                  <?php endif ?>
                                
                                <div class="row">
                                
                                
                                  <?php
                                  $paypal_set = $this->db->get_where('business_settings', array('type' => 'paypal_set'))->row()->value;
                                  if ($paypal_set=="ok"): ?>
                                      <div class="col-4">
                                          <div class="card mb-3 card-paypal" style="background: transparent;">
                                              <a id="select_paypal">
                                                  <div class="card-image">
                                                      <img src="<?=base_url()?>template/front/images/paypal.jpg">
                                                      <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;">
                                                          <span class="span-text" id="select_paypal_text" style=""><?=translate('select')?></span>
                                                      </div>
                                                  </div>
                                              </a>
                                          </div>
                                      </div>
                                  <?php endif ?>
                                  <?php
                                  $stripe_set = $this->db->get_where('business_settings', array('type' => 'pesapal_set'))->row()->value;
                                  if ($stripe_set=="ok"): ?>
                                      <div class="col-4">
                                          <div class="card mb-3 " style="background: transparent;">
                                              <a id="select_pesapal">
                                                  <div class="card-image">
                                                      <img src="<?=base_url()?>template/front/images/pesapal.jpg">
                                                      <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                          <span class="span-text" id="select_pesapal_text"><?=translate('select')?></span>
                                                      </div>
                                                  </div>
                                              </a>
                                          </div>
                                      </div>
                                  <?php endif ?>
                                  <?php
                                  $stripe_set = $this->db->get_where('business_settings', array('type' => 'stripe_set'))->row()->value;
                                  if ($stripe_set=="ok"): ?>
                                      <div class="col-4">
                                          <div class="card mb-3 card-stripe" style="background: transparent;">
                                              <a id="select_stripe">
                                                  <div class="card-image">
                                                      <img src="<?=base_url()?>template/front/images/stripe.jpg">
                                                      <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                          <span class="span-text" id="select_stripe_text"><?=translate('select')?></span>
                                                      </div>
                                                  </div>
                                              </a>
                                          </div>
                                      </div>
                                  <?php endif ?>
                                  <?php
                                  $pum_set = $this->db->get_where('business_settings', array('type' => 'pum_set'))->row()->value;
                                  if ($pum_set=="ok"): ?>
                                      <div class="col-4">
                                          <div class="card mb-3 card-pum" style="background: transparent;">
                                              <a id="select_pum">
                                                  <div class="card-image">
                                                      <img src="<?=base_url()?>template/front/images/pum.png">
                                                      <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                          <span class="span-text" id="select_pum_text"><?=translate('select')?></span>
                                                      </div>
                                                  </div>
                                              </a>
                                          </div>
                                      </div>
                                  <?php endif ?>

                                  <?php
                                    $instamojo_set = $this->db->get_where('business_settings', array('type' => 'instamojo_set'))->row()->value;
                                    if($instamojo_set == 'ok'):  ?>
                                    <div class="col-4">
                                        <div class="card mb-3 card-instamojo" style="background: transparent;">
                                            <a id="select_instamojo">
                                                <div class="card-image">
                                                    <img src="<?=base_url()?>template/front/images/instamojo.png">
                                                    <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                        <span class="span-text" id="select_instamojo_text"><?=translate('select')?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                  <?php endif ?>

                                  <!-- cp = short form of custom payment -->
                                  <!-- CUSTOM PYMENT METHOD 1 -->
                                  <?php if($cp_method_1_set == 'ok'):  ?>
                                      <div class="col-4">
                                        <div class="card mb-3 card-cp_method_1" style="background: transparent;">
                                            <a id="select_cp_method_1">
                                                <div class="card-image">
                                                    <?php
        								                if (file_exists('uploads/custom_payment_methods_image/cp_method_1_image.jpg')) {
        								                 ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/cp_method_1_image.jpg">
        								                <?php
        								                } else {
        								                ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/custom_payment_dafault.jpg">
        								                <?php
        								                }
        											?>

                                                    <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                        <span class="span-text" id="select_cp_method_1_text"><?=translate('select')?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                  <?php endif ?>

                                  <!-- CUSTOM PYMENT METHOD 2 -->
                                  <?php if($cp_method_2_set == 'ok'):  ?>
                                      <div class="col-4">
                                        <div class="card mb-3 card-cp_method_2" style="background: transparent;">
                                            <a id="select_cp_method_2">
                                                <div class="card-image">
                                                    <?php
        								                if (file_exists('uploads/custom_payment_methods_image/cp_method_2_image.jpg')) {
        								                 ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/cp_method_2_image.jpg">
        								                <?php
        								                } else {
        								                ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/custom_payment_dafault.jpg">
        								                <?php
        								                }
        											?>

                                                    <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                        <span class="span-text" id="select_cp_method_2_text"><?=translate('select')?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                  <?php endif ?>

                                  <!-- CUSTOM PYMENT METHOD 3 -->
                                  <?php if($cp_method_3_set == 'ok'):  ?>
                                      <div class="col-4">
                                        <div class="card mb-3 card-cp_method_3" style="background: transparent;">
                                            <a id="select_cp_method_3">
                                                <div class="card-image">
                                                    <?php
        								                if (file_exists('uploads/custom_payment_methods_image/cp_method_3_image.jpg')) {
        								                 ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/cp_method_3_image.jpg">
        								                <?php
        								                } else {
        								                ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/custom_payment_dafault.jpg">
        								                <?php
        								                }
        											?>

                                                    <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                        <span class="span-text" id="select_cp_method_3_text"><?=translate('select')?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                  <?php endif ?>

                                  <!-- CUSTOM PYMENT METHOD 4 -->
                                  <?php if($cp_method_4_set == 'ok'):  ?>
                                      <div class="col-4">
                                        <div class="card mb-3 card-cp_method_4" style="background: transparent;">
                                            <a id="select_cp_method_4">
                                                <div class="card-image">
                                                    <?php
        								                if (file_exists('uploads/custom_payment_methods_image/cp_method_4_image.jpg')) {
        								                 ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/cp_method_4_image.jpg">
        								                <?php
        								                } else {
        								                ?>
                                                            <img src="<?=base_url()?>uploads/custom_payment_methods_image/custom_payment_dafault.jpg">
        								                <?php
        								                }
        											?>

                                                    <div class="text-center bg-base-1" style="height: 26px;border-bottom-left-radius: 3px;    border-bottom-right-radius: 3px;">
                                                        <span class="span-text" id="select_cp_method_4_text"><?=translate('select')?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                  <?php endif ?>

                                </div>
                            </div>


                        <form id="payment_form" method="POST" action="<?=base_url()?>home/process_payment" enctype="multipart/form-data">
                                <!-- Custom Payment Detail Form -->
                                <?php if($cp_method_1_set == 'ok'): ?>
                                    <div class="cp_method_1_detail d-none">
                                        <div class="feature feature--boxed-border feature--bg-2 active package_bg mt-4">
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3 class="h5"><?= $cp_method_1_name ?></h3>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><?= $cp_method_1_number ?></h6>
                                                        </div>
                                                    </div>
                                                    <p><?= $cp_method_1_instruction ?></p>
                                                </div>
                                                <input type="hidden" name="cpm_1_name" value="<?= $cp_method_1_name ?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="transaction_id"><?php echo translate('Transaction Id');?></label>
                                                        <input class="form-control cpm_1_transaction_id"  name="cpm_1_transaction_id" type="text" placeholder="<?php echo translate('Transaction Id');?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image"><?php echo translate('Upload Screenshot or bill copy');?></label>
                                                        <input class="form-control" name="cpm_1_bill_copy" type="file" accept="image/png, image/jpeg, image/jpg, .pdf"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="comment"><?php echo translate('Info/Comment');?></label>
                                                        <textarea class="form-control" name="cpm_1_comment"  placeholder="<?php echo translate('Enter additional info/comment');?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if($cp_method_2_set == 'ok'): ?>
                                    <div class="cp_method_2_detail d-none">
                                        <div class="feature feature--boxed-border feature--bg-2 active package_bg mt-4">
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3 class="h5"><?= $cp_method_2_name ?></h3>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><?= $cp_method_2_number ?></h6>
                                                        </div>
                                                    </div>
                                                    <p><?= $cp_method_2_instruction ?></p>
                                                </div>
                                                <input type="hidden" name="cpm_2_name" value="<?= $cp_method_2_name ?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="transaction_id"><?php echo translate('Transaction Id');?></label>
                                                        <input class="form-control cpm_2_transaction_id"  name="cpm_2_transaction_id" type="text" placeholder="<?php echo translate('Transaction Id');?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image"><?php echo translate('Upload Screenshot or bill copy');?></label>
                                                        <input class="form-control" name="cpm_2_bill_copy" type="file" accept="image/png, image/jpeg, image/jpg, .pdf"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="comment"><?php echo translate('Info/Comment');?></label>
                                                        <textarea class="form-control" name="cpm_2_comment"  placeholder="<?php echo translate('Enter additional info/comment');?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if($cp_method_3_set == 'ok'): ?>
                                    <div class="cp_method_3_detail d-none">
                                        <div class="feature feature--boxed-border feature--bg-2 active package_bg mt-4">
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3 class="h5"><?= $cp_method_3_name ?></h3>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><?= $cp_method_3_number ?></h6>
                                                        </div>
                                                    </div>
                                                    <p><?= $cp_method_3_instruction ?></p>
                                                </div>
                                                <input type="hidden" name="cpm_3_name" value="<?= $cp_method_3_name ?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="transaction_id"><?php echo translate('Transaction Id');?></label>
                                                        <input class="form-control cpm_3_transaction_id"  name="cpm_3_transaction_id" type="text" placeholder="<?php echo translate('Transaction Id');?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image"><?php echo translate('Upload Screenshot or bill copy');?></label>
                                                        <input class="form-control" name="cpm_3_bill_copy" type="file" accept="image/png, image/jpeg, image/jpg, .pdf"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="comment"><?php echo translate('Info/Comment');?></label>
                                                        <textarea class="form-control" name="cpm_3_comment"  placeholder="<?php echo translate('Enter additional info/comment');?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if($cp_method_4_set == 'ok'): ?>
                                    <div class="cp_method_4_detail d-none">
                                        <div class="feature feature--boxed-border feature--bg-2 active package_bg mt-4">
                                            <div class="row ">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3 class="h5"><?= $cp_method_4_name ?></h3>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><?= $cp_method_4_number ?></h6>
                                                        </div>
                                                    </div>
                                                    <p><?= $cp_method_4_instruction ?></p>
                                                </div>
                                                <input type="hidden" name="cpm_4_name" value="<?= $cp_method_4_name ?>">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="transaction_id"><?php echo translate('Transaction Id');?></label>
                                                        <input class="form-control cpm_4_transaction_id"  name="cpm_4_transaction_id" type="text" placeholder="<?php echo translate('Transaction Id');?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image"><?php echo translate('Upload Screenshot or bill copy');?></label>
                                                        <input class="form-control" name="cpm_4_bill_copy" type="file" accept="image/png, image/jpeg, image/jpg, .pdf"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="comment"><?php echo translate('Info/Comment');?></label>
                                                        <textarea class="form-control" name="cpm_4_comment"  placeholder="<?php echo translate('Enter additional info/comment');?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <!-- Cusrom Payment Detail End -->

                                <!-- Confirm Purchase -->
                                <div class="text-center pt-3">
                                    <input type="hidden" name="payment_type" id="payment_type" value="">
                                    <input type="hidden" name="plan_id" value="<?=$value->plan_id?>">
                                    <?php
                                        $exchange = exchange('usd');
                                        $stripe_amount= $value->amount/$exchange;
                                    ?>
                                    <input type="hidden" name="stripe_amount" id="stripe_amount" value="<?=$stripe_amount?>">
                                    <button type="button" class="btn btn-base-1 z-depth-2-bottom" id="purchase_button" disabled><?php echo translate('confirm_purchase')?></button>
                                </div>
                            </form>
                            <script>
                                $(document).ready(function(e) {
                                    //<script src="https://js.stripe.com/v2/"><script>
                                    //https://checkout.stripe.com/checkout.js

                                    var submittedForm = false;
                                    var handler = StripeCheckout.configure({
                                        key: '<?php echo $this->db->get_where('business_settings' , array('type' => 'stripe_publishable_key'))->row()->value; ?>',
                                        image: '<?php echo base_url(); ?>template/front/images/stripe.jpg',
                                        token: function(token) {
                                            // Use the token to create the charge with a server-side script.
                                            // You can access the token ID with `token.id`
                                            $('#payment_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                                            submittedForm = true;
                                            $("#payment_loader").show();
                                            $("#payment_section").hide();
                                            $("#go_back").hide();
                                            $("#purchase_button").hide();
                                            setTimeout(function(){
                                                $('#payment_form').submit();
                                            }, 500);
                                        }
                                    });

                                    $('#select_stripe').on('click', function(e) {
                                        $("#select_stripe_text").html("<?php echo translate('selected')?>");
                                        $("#select_paypal_text").html("<?php echo translate('select')?>");
                                        $("#select_pum_text").html("<?php echo translate('select')?>");
                                        $("#select_instamojo_text").html("<?php echo translate('select')?>");
                                        $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
                                        $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
                                        $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
                                        $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

                                        $(".card-stripe").css("border", "3px solid #24242D");
                                        $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                        $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");

                                        $("#payment_type").val('stripe');
                                        $("#purchase_button").prop('disabled', true);

                                        $( ".cp_method_1_detail").addClass('d-none');
                                        $( ".cp_method_2_detail").addClass('d-none');
                                        $( ".cp_method_3_detail").addClass('d-none');
                                        $( ".cp_method_4_detail").addClass('d-none');

                                        // Open Checkout with further options
                                        var total = $('#stripe_amount').val();
                                        total = total * 100;
                                        handler.open({
                                            name: '<?=$this->system_title?>',
                                            description: 'Pay with Stripe',
                                            amount: total,
                                            closed: function() {
                                                $("#select_paypal_text").html("<?php echo translate('select')?>");
                                                $("#select_stripe_text").html("<?php echo translate('select')?>");
                                                $("#select_pum_text").html("<?php echo translate('select')?>");
                                                $("#select_instamojo_text").html("<?php echo translate('select')?>");
                                                $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                                $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                                $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
                                                $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");

                                                $("#purchase_button").prop('disabled', true);
                                                if (submittedForm == false) {
                                                    $("#payment_loader").hide();
                                                    $("#payment_section").show();
                                                    $("#go_back").show();
                                                }
                                            }
                                        });
                                        e.preventDefault();
                                    });

                                    // Close Checkout on page navigation
                                    $(window).on('popstate', function() {
                                        handler.close();
                                    });
                                });
                            </script>
                            <script>
                                $(document).ready(function(e) {
                                    $('#select_pesapal').on('click', function(e) {
                                        const para = document.getElementById("pesapal_head_lock");
                                        $(para).css({
                                            position:"fixed",
                                            width:"100%",
                                            background:"#ff000000",
                                            height:"79px",
                                            top:"0",
                                            left:"0",
                                            zIndex:"10000",
                                        });
                                     
                                        $("#payment_loader").show();
                                        $("#payment_section").hide();
                                        var url = '<?php echo base_url(); ?>home/pesaPayment';
                                        $.ajax({
                                            type:"POST",
                                            url:url,
                                            data:$('#payment_form').serialize(),
                                            dataType:"json",
                                            success:function(response){
                                                    if(response.status){
                                                        $('#pesapalifrem').css({display:"block"});
                                                        $('#pesapalifrem_other').css({display:"none"});
                                                        var payData = response.data;
                                                        // window.location.href = payData.redirect_url;
                                                        var htmliFreme =`<iframe src="${payData.redirect_url}" ></iframe>`;
                                                        $('#pesapalifrem').html(htmliFreme);
                                                    }else{
                                                        $("#payment_loader").hide();
                                                        $("#payment_section").show();
                                                    }
                                            }

                                        });
                                    });

                                    // $('#select_pesapal').click();
                                    $('#pesapal_head_lock').click(function(){
                                        if (confirm('Are you sure? you want to leave payment page,(if you leave this page befoere your payment confirmation,  you will be face payment confirmation issue) after payment success it automatic redirect  ')) {
                                            history.back();
                                        }
                                    });
                                });
                            </script>
                            <div class="text-center pt-4">
                                <a href="<?=base_url()?>home/plans" id="go_back" class="btn btn-danger btn-sm">Go Back</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php 
$userData = $this->db->get_where("member", array("member_id" => $this->session->userdata('member_id')))->row();

?>
<script>
    $(document).ready(function(e) {
        $('#select_dpo').on('click', function(e) {
            const para = document.getElementById("pesapal_head_lock");
            $(para).css({
                position:"fixed",
                width:"100%",
                background:"#ff000000",
                height:"79px",
                top:"0",
                left:"0",
                zIndex:"10000",
            });
            
            $("#payment_loader").show();
            $("#payment_section").hide();
            var url = '<?php echo base_url(); ?>home/dpoPayment';
            $.ajax({
                type:"POST",
                url:url,
                data:$('#payment_form').serialize(),
                dataType:"json",
                success:function(response){
                        if(response.status){
                            $('#pesapalifrem').css({display:"block"});
                            $('#pesapalifrem_other').css({display:"none"});
                            var token  = response.data.transToken;
                            var urldpo ='https://secure.3gdirectpay.com/payv2.php?ID='+token;
                            // var urldpo ='https://secure1.sandbox.3gdirectpay.com/payv2.php?ID='+token;
                            window.location.href = urldpo;
                            // var htmliFreme =`<iframe src="${payData.redirect_url}" ></iframe>`;
                            // $('#pesapalifrem').html(htmliFreme);
                        }else{

                            $("#payment_loader").hide();
                            $("#payment_section").show();
                            $("#active_modal").modal({backdrop: true, keyboard: true});
                            $("#modal_header").html("<?php echo translate('DPO_Payment');?>");
                            $("#modal_body").html('<div class="text-center" ><p> '+response.data.error+'</p></div>');
                        }
                }

            });
        });

        // $('#select_pesapal').click();
        $('#pesapal_head_lock').click(function(){
            if (confirm('Are you sure? you want to leave payment page,(if you leave this page befoere your payment confirmation,  you will be face payment confirmation issue) after payment success it automatic redirect  ')) {
                history.back();
            }
        });
    });
</script>
<script>
    $(document).ready(function(e) {
        $("#select_paypal").click(function(){
            $("#select_paypal_text").html("<?php echo translate('selected')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-paypal").css("border", "1px solid #24242D");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $("#payment_type").val('paypal');
            $("#purchase_button").prop('disabled', false);

            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');
        });
        
        $("#select_mpesa").click(function(){
            $("#select_mpesa_text").html("<?php echo translate('selected')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-cp_method_2").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");

            $("#active_modal").modal({backdrop: 'static', keyboard: false});
            $("#modal_header").html("<?php echo translate('MPesa_Payment');?>");
            var htmlpage ='';
                htmlpage +='<div class="mpesa-pay-form"><form id="mpesapayment_form_aid" onsubmit="return mpesapaymentSubmit($(this).serialize())" method="post" action="<?php echo base_url(); ?>/home/mPesaPayment">';
                    htmlpage +='<div class="form-group">';
                    htmlpage +='    <label for="transaction_id">Amount</label>';
                    htmlpage +='    <input class="form-control " required  value="<?php echo $selected_plan[0]->amount*120; ?>ksh"  readonly type="text" placeholder="Amount">';
                    htmlpage +='</div>';
                    htmlpage +='<div class="form-group">';
                    htmlpage +='    <label for="transaction_id">Phone Number</label>';
                    htmlpage +='    <input class="form-control " id="mpesa_phone" required name="mpesa_phone" value="<?php echo $userData->mobile; ?>" type="text" placeholder="Enter Phone Number">';
                    htmlpage +='</div>';
                    htmlpage +='<div class="form-group">';
                    htmlpage +='    <input class="text-center bg-base-1"   type="submit" value="Payment submit">';
                    htmlpage +='</div>';
                htmlpage +='</form></div>';
            $("#modal_body").html(htmlpage);
            $("#modal_buttons").html("");
            $('#modal_close').css({display:"none"});
        });
        $("#select_pum").click(function(){
            $("#select_pum_text").html("<?php echo translate('selected')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-pum").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $("#payment_type").val('pum');
            $("#purchase_button").prop('disabled', false);
            $( ".cp_method_1_detail").addClass('d-none');

            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');

        });
        $("#select_instamojo").click(function(){
          $("#select_instamojo_text").html("<?php echo translate('selected')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-instamojo").css("border", "1px solid #24242D");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $("#payment_type").val('instamojo');
            $("#purchase_button").prop('disabled', false);

            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');
        });

        // custom payment method 1
        $("#select_cp_method_1").click(function(){
            $("#select_cp_method_1_text").html("<?php echo translate('selected')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-cp_method_1").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");

            $( ".cp_method_1_detail").removeClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');

            $("#payment_type").val('custom_payment_method_1');
            $("#purchase_button").prop('disabled', false);
        });

        // custom payment method 2
        $("#select_cp_method_2").click(function(){
            $("#select_cp_method_2_text").html("<?php echo translate('selected')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-cp_method_2").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");

            $( ".cp_method_2_detail").removeClass('d-none');
            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');

            $("#payment_type").val('custom_payment_method_2');
            $("#purchase_button").prop('disabled', false);
        });

        // custom payment method 3
        $("#select_cp_method_3").click(function(){
            $("#select_cp_method_3_text").html("<?php echo translate('selected')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_4_text").html("<?php echo translate('select')?>");

            $(".card-cp_method_3").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_4").css("border", "1px solid rgba(0, 0, 0, 0.05)");

            $( ".cp_method_3_detail").removeClass('d-none');
            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_4_detail").addClass('d-none');

            $("#payment_type").val('custom_payment_method_3');
            $("#purchase_button").prop('disabled', false);
        });

        // custom payment method 4
        $("#select_cp_method_4").click(function(){
            $("#select_cp_method_4_text").html("<?php echo translate('selected')?>");
            $("#select_paypal_text").html("<?php echo translate('select')?>");
            $("#select_stripe_text").html("<?php echo translate('select')?>");
            $("#select_pum_text").html("<?php echo translate('select')?>");
            $("#select_instamojo_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_1_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_2_text").html("<?php echo translate('select')?>");
            $("#select_cp_method_3_text").html("<?php echo translate('select')?>");

            $(".card-cp_method_4").css("border", "1px solid #24242D");
            $(".card-paypal").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-stripe").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-pum").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-instamojo").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_1").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_2").css("border", "1px solid rgba(0, 0, 0, 0.05)");
            $(".card-cp_method_3").css("border", "1px solid rgba(0, 0, 0, 0.05)");

            $( ".cp_method_4_detail").removeClass('d-none');
            $( ".cp_method_1_detail").addClass('d-none');
            $( ".cp_method_2_detail").addClass('d-none');
            $( ".cp_method_3_detail").addClass('d-none');

            $("#payment_type").val('custom_payment_method_4');
            $("#purchase_button").prop('disabled', false);
        });

        $("#purchase_button").click(function(){
            var type = $("#payment_type").val();
            if (type == "paypal" || type == "pum" || type == "instamojo") {
                $("#payment_form").submit();
            }
            else if (type == 'custom_payment_method_1') {
                var transaction_id = $(".cpm_1_transaction_id").val();
                if(transaction_id == ''){
                    alert('Please provide Transaction Id');
                }else {
                    $("#payment_form").submit();
                }
            }
            else if (type == 'custom_payment_method_2') {
                var transaction_id = $(".cpm_2_transaction_id").val();
                if(transaction_id == ''){
                    alert('Please provide Transaction Id');
                }else {
                    $("#payment_form").submit();
                }
            }
            else if (type == 'custom_payment_method_3') {
                var transaction_id = $(".cpm_3_transaction_id").val();
                if(transaction_id == ''){
                    alert('Please provide Transaction Id');
                }else {
                    $("#payment_form").submit();
                }
            }
            else if (type == 'custom_payment_method_4') {
                var transaction_id = $(".cpm_4_transaction_id").val();
                if(transaction_id == ''){
                    alert('Please provide Transaction Id');
                }else {
                    $("#payment_form").submit();
                }
            }
        });
    });
</script>
<script>
    function mpesapaymentSubmit(datas){
        var phoneObj= datas.split('=');
        var strFirstThree = parseInt(phoneObj[1].substring(0,3));
        if(strFirstThree != 254){
            $("#danger_alert").show();
            $(".alert-danger").html("<?php echo translate('Your_phone_number_is_not_valid!_(Add_254)_before_your_phone_number')?>");
            $('#success_alert').fadeOut('fast');
            setTimeout(function() {
                $('#danger_alert').fadeOut('fast');
            }, 5000); // <-- time in milliseconds
            return false;
        }
        $("#modal_body").html('<div class="text-center" id="payment_loader"><i class="fa fa-refresh fa-5x fa-spin"></i><p>Please Wait ...</p></div>');
        var planId = '<?php echo $selected_plan[0]->plan_id; ?>';
        $.ajax({
            method:"POST",
            url:'<?php echo base_url(); ?>home/mPesaPayment/'+planId,
            data:datas,
            dataType:"JSON",
            success:function(response){
                if(response.status){
                    clearInterval(message_interval);
                var message_interval =  setInterval(function(){
                        $.ajax({
                            method:"POST",
                            url:'<?php echo base_url(); ?>home/mPesaPayment_checker/'+response.data.paymentTempId,
                            data:datas,
                            dataType:"JSON",
                            success:function(dataRes){
                                if(dataRes.status){
                                    window.location.href='<?php echo base_url('home/invoice/') ?>'+response.data.paymentTempId;
                                }
                            }
                        })
                        }, 4000);
                }else{
                    $("#modal_body").html('<div class="text-center" ><p>Payment Request failed Please <a href="<?php base_url('home/plans/subscribe/'); ?>'+planId+'"> try again</a> </p></div>');
                }
            }
        })
        return false;
    }
</script>
