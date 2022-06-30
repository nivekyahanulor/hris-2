<?php
/*
* Ticket Detail view
*/
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_ticket');?> <?php echo $this->lang->line('xin_details');?> </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <div class="datatables-demo table table-striped table-bordered" data-pattern="priority-columns">
                  <?php
				if($ticket_priority==1): $priority = $this->lang->line('xin_low'); elseif($ticket_priority==2): $priority = $this->lang->line('xin_medium'); elseif($ticket_priority==3): $priority = $this->lang->line('xin_high'); elseif($ticket_priority==4): $priority = $this->lang->line('xin_critical');  endif;
				?>
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('xin_subject');?></th>
                        <td class="text-right"><?php echo $subject;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('dashboard_single_employee');?></th>
                        <td class="text-right"><?php echo $full_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_p_priority');?></th>
                        <td class="text-right"><?php echo $priority;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_e_details_date');?></th>
                        <td class="text-right"><?php
						$created_at = date('h:i A', strtotime($created_at));
						$_date = explode(' ',$created_at);
						$edate = $this->Xin_model->set_date_format($_date[0]);
						echo $_created_at = $edate. ' '. $created_at;?></td>
                      </tr>
                      <?php $count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();?>
						<?php $module_attributes = $this->Custom_fields_model->tickets_hrsale_module_attributes();?>
                        <?php foreach($module_attributes as $mattribute):?>
                          <?php $attribute_info = $this->Custom_fields_model->get_employee_custom_data($ticket_id,$mattribute->custom_field_id);?>
                          <?php
                                if(!is_null($attribute_info)){
                                    $attr_val = $attribute_info->attribute_value;
                                } else {
                                    $attr_val = '';
                                }
                            ?>
                            <?php if($mattribute->attribute_type == 'date'){?>
                            <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'select'){?>
                          <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php foreach($iselc_val as $selc_val) {?> <?php if($attr_val==$selc_val->attributes_select_value_id):?> <?php echo $selc_val->select_label?> <?php endif;?><?php } ?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                          <?php $multiselect_values = explode(',',$attr_val);?>
                          <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php foreach($imulti_selc_val as $multi_selc_val) {?> <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?><br /> <?php echo $multi_selc_val->select_label?> <?php endif;?><?php } ?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'textarea'){?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php if($attr_val!='' && $attr_val!='no file') {?>
                              <img src="<?php echo base_url().'uploads/custom_files/'.$attr_val;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('xin_download');?></a>
                              <?php } ?></td>
                          </tr>
                          <?php } else { ?>
                          <tr>
                                <th><?php echo $mattribute->attribute_label;?></th>
                                <td style="display: table-cell;"><?php echo $attr_val;?></td>
                          </tr>
                          <?php } ?>
                          
                          <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php if($user_info[0]->user_role_id==1) {?>
    <!-- assigned to-->
    <section id="decimal">
      <div class="row <?php echo $get_animate;?>">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_assigned_to');?> </h3>
            </div>
            <div class="box-body">
              <div class="box-block box-dashboard">
                <?php $assigned_ids = explode(',',$assigned_to);?>
                <?php $attributes = array('name' => 'assign_ticket', 'id' => 'assign_ticket', 'autocomplete' => 'off');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/tickets/assign_ticket', $attributes, $hidden);?>
                <?php
					$data = array(
					  'name'        => 'ticket_id',
					  'id'          => 'ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data);
					?>
                <div class="box-block">
                  <div class="form-group">
                    <label for="employees" class="control-label"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                    <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                      <?php foreach($all_employees as $employee) {?>
                      <option value="<?php echo $employee->user_id?>" <?php if(in_array($employee->user_id,$assigned_ids)){?> selected="selected"<?php } ?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
  </div>
  <div class="col-md-8 <?php echo $get_animate;?>">
    <div class="col-xl-12 col-lg-12">
      <div class="box">
        <div class="box-block">
          <ul class="nav nav-tabs nav-top-border no-hover-bg">
            <li class="nav-item active"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-home"></i> <?php echo $this->lang->line('xin_details');?></a> </li>
            <li class="nav-item"> <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-comment"></i> <?php echo $this->lang->line('xin_payment_comment');?></a> </li>
            <li class="nav-item"> <a class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('xin_ticket_files');?></a> </li>
            <li class="nav-item"> <a class="nav-link" id="baseIcon-tab14" data-toggle="tab" aria-controls="tabIcon14" href="#tabIcon14" aria-expanded="false"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?></a> </li>
          </ul>
          <div class="tab-content pt-1">
            <div role="tabpanel" class="tab-pane active <?php echo $get_animate;?>" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
              <div class="box-body">
                <div class="col-md-12">
                  <p class="mb-1 mt-3 ml-2"><?php echo html_entity_decode($description);?></p>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
                    <?php $hidden2 = array('user_id' => $session['user_id']);?>
                    <?php echo form_open('admin/tickets/update_status', $attributes2, $hidden2);?>
                    <?php
					$data2 = array(
					  'name'        => 'status_ticket_id',
					  'id'          => 'status_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data2);
					?>
                    <div class="box-header with-border">
                      <h3 class="box-title"> <?php echo $this->lang->line('xin_update_status');?> </h3>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group"> 
                          <!--<label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>-->
                          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                            <option value="1" <?php if($ticket_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_open');?></option>
                            <option value="2" <?php if($ticket_status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_closed');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('xin_remarks');?></label>
                          <textarea class="form-control" name="remarks" rows="4" cols="15" placeholder="<?php echo $this->lang->line('xin_remarks');?>"><?php echo $ticket_remarks;?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions box-footer">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                    <?php echo form_close(); ?> </div>
                </div>
              </div>
            </div>
            <div class="tab-pane <?php echo $get_animate;?>" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
              <div class="box-body">
                <?php $attributes3 = array('name' => 'set_comment', 'id' => 'set_comment', 'autocomplete' => 'off');?>
                <?php $hidden3 = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/tickets/set_comment', $attributes3, $hidden3);?>
                <?php
					$data2 = array(
					  'name'        => 'comment_ticket_id',
					  'id'          => 'comment_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data2);
					?>
                <?php
					$data3 = array(
					  'name'        => 'user_id',
					  'id'          => 'user_id',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
				
					echo form_input($data3);
					?>
                <div class="box-block">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="xin_comment" id="xin_comment" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_comment');?>"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
                <div class="clear"></div>
                <div class="table-responsive">
                  <table class="table table-hover mb-md-0" id="xin_comment_table" style="width:100%;">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('xin_all_comments');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane <?php echo $get_animate;?>" id="tabIcon13" aria-labelledby="baseIcon-tab13" aria-expanded="false">
              <div class="box-body">
                <?php $attributes4 = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
                <?php $hidden4 = array('user_id' => $session['user_id']);?>
                <?php echo form_open_multipart('admin/tickets/add_attachment', $attributes4, $hidden4);?>
                <?php
					$data4 = array(
					  'name'        => 'user_file_id',
					  'id'          => 'user_file_id',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
					echo form_input($data4);
					?>
                <?php
					$data5 = array(
					  'name'        => '_token_file',
					  'id'          => '_token_file',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
					echo form_input($data5);
					?>
                <?php
					$data6 = array(
					  'name'        => 'c_ticket_id',
					  'id'          => 'c_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
					echo form_input($data6);
					?>
                <div class="bg-white">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="task_name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="file_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class='form-group'>
                        <fieldset class="form-group">
                          <label for="logo"><?php echo $this->lang->line('xin_attachment_file');?></label>
                          <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                          <small><?php echo $this->lang->line('xin_project_files_upload');?></small>
                        </fieldset>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                        <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="file_description" rows="4" id="file_description"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
                <div class="box">
                  <div class="box-body">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <?php echo $this->lang->line('xin_attachment_list');?> </h3>
                    </div>
                    <div class="box-datatable table-responsive">
                      <table class="table table-hover table-striped table-bordered table-ajax-load" id="xin_attachment_table" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_option');?></th>
                            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                            <th><?php echo $this->lang->line('xin_description');?></th>
                            <th><?php echo $this->lang->line('xin_date_and_time');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane <?php echo $get_animate;?>" id="tabIcon14" aria-labelledby="baseIcon-tab14" aria-expanded="false">
              <div class="box-body">
                <?php $attributes3 = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
                <?php $hidden3 = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/tickets/add_note', $attributes3, $hidden3);?>
                <?php
					$data7 = array(
					  'name'        => 'token_note_id',
					  'id'          => 'token_note_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data7);
					?>
                <?php
					$data8 = array(
					  'name'        => '_uid',
					  'id'          => '_uid',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
				
					echo form_input($data8);
					?>
                <div class="box-block">
                  <div class="form-group">
                    <textarea name="ticket_note" id="ticket_note" class="form-control" rows="5" placeholder="<?php echo $this->lang->line('xin_ticket_note');?>"><?php echo $ticket_note;?></textarea>
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
            <!-- tab --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
