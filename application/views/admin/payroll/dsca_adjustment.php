<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<?php if(in_array('201',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title">NEW ADJUSTMENTS</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>ADD ADJUSTMENT</button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employees/add_employee', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">Adjustment Type : </label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
               <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">Adjustment Name : </label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">Employee Name : </label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
               <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">Amount : </label>
                    <input type=text" class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>
        
        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php }?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employees');?> </h3>
    <?php if($user_info[0]->user_role_id==1){ ?>
    <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-filter"></span> <?php echo $this->lang->line('xin_filter');?></button>
       </a> <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-bar-chart"></span> <?php echo $this->lang->line('xin_report');?> <span class="fa fa-caret-down"></span></button>
       <ul class="dropdown-menu">
        <li><a href="<?php echo site_url('admin/reports/employees/');?>" target="_blank"><?php echo $this->lang->line('xin_filter_employement_report');?></a></li>
      </ul></div>
      <?php } ?>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:80px;"><?php echo $this->lang->line('xin_action');?></th>
            <th width="200"><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><i class="fa fa-phone"></i> <?php echo $this->lang->line('dashboard_contact');?>#</th>
            <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('dashboard_email');?></th>
            <th><?php echo $this->lang->line('xin_employee_role');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
