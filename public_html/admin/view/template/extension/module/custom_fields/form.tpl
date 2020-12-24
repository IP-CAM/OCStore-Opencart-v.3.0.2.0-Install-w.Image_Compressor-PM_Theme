<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-custom_field" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?> <?php if($custom_fields_id){ ?>ID: <b><?php echo $custom_fields_id; ?></b><?php } ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
			<li><a href="#tab-frontend" data-toggle="tab"><?php echo $tab_frontend; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
				<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_fields_title; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_fields_title; ?>" id="input-name" class="form-control" />
				  <?php if ($error_name) { ?>
				  <div class="text-danger"><?php echo $error_name; ?></div>
				  <?php } ?>
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-description"><?php echo $entry_fields_description; ?></label>
				<div class="col-sm-10">
				  <textarea name="description" placeholder="<?php echo $entry_fields_description; ?>" id="input-description" class="form-control"><?php echo $description; ?></textarea>
				  
				</div>
			  </div>
              
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-entity"><?php echo $entry_fields_entity; ?></label>
                <div class="col-sm-10">
                  <select name="entity" id="input-entity" class="form-control">
                    <?php foreach($entities as $ent){ ?>
						<option value="<?php echo $ent; ?>"<?php if($entity==$ent){ ?> selected="selected"<?php } ?>><?php echo $ent; ?></option>
					<?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_fields_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_fields_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
			  
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_fields_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-required"><?php echo $entry_fields_required; ?></label>
				<div class="col-sm-10">
					<select name="required" id="input-required" class="form-control" onchange="if($(this).val()==1){$('#input-texterror-wrap').show();}else{$('#input-texterror-wrap').hide();}">
					<?php if ($required) { ?>
						<option value="1" selected="selected"><?php echo $text_yes; ?></option>
						<option value="0"><?php echo $text_no; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_yes; ?></option>
						<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<?php } ?> 
					</select>
				</div>
			</div>
			<div class="form-group" id="input-texterror-wrap" <?php if(!$required){ ?>style="display:none;"<?php }?>>
				<label class="col-sm-2 control-label" for="input-texterror"><?php echo $entry_fields_error; ?></label>
				<div class="col-sm-10">
					<input type="text" id="input-texterror" name="texterror" value="<?php echo $texterror; ?>" placeholder="<?php echo $entry_fields_error; ?>" class="form-control" />
				</div>
			</div>
			  <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-tab"><?php echo $entry_fields_tab; ?></label>
                <div class="col-sm-10">
                  <input type="text" id="input-tab" name="tab" value="<?php echo $tab; ?>" placeholder="<?php echo $entry_fields_tab; ?>" class="form-control" />
                </div>
				<?php if ($error_tab) { ?>
				  <div class="text-danger"><?php echo $error_tab; ?></div>
				<?php } ?>
              </div>
			  
            </div>
			<div class="tab-pane" id="tab-data">
			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-type"><?php echo $entry_fields_type; ?></label>
                <div class="col-sm-10">
                  <select name="type" id="input-type" class="form-control">
                    <?php foreach($types as $typ){ ?>
						<option value="<?php echo $typ; ?>"<?php if($type==$typ){ ?> selected="selected"<?php } ?>><?php echo $typ; ?></option>
					<?php } ?>
                  </select>
                </div>
              </div>
			  <div id="input-type-content"></div>
            </div>
            <div class="tab-pane" id="tab-frontend">
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-place"><span data-toggle="tooltip" title="<?php echo $entry_fields_place_help; ?>"><?php echo $entry_fields_place; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" id="input-place" name="place" value="<?php echo $place; ?>" placeholder="<?php echo $entry_fields_place; ?>" class="form-control" />
                </div>				
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-placenum"><span data-toggle="tooltip" title="<?php echo $entry_fields_placenum_help; ?>"><?php echo $entry_fields_placenum; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" id="input-placenum" name="placenum" value="<?php echo $placenum; ?>" placeholder="<?php echo $entry_fields_placenum; ?>" class="form-control" />
                </div>				
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mode"><?php echo $entry_fields_mode; ?></label>
                <div class="col-sm-10">
                  <select name="mode" id="input-mode" class="form-control" onchange="$('.mode-description').hide();$('#mode-description-'+$(this).val()).show();">
					<?php foreach($modes as $key=>$mod){ ?>
						<option value="<?php echo $key; ?>"<?php if($mode==$key){ ?> selected="selected"<?php } ?>><?php echo $mod['name']; ?></option>
					<?php } ?>
                  </select>
                </div>
              </div>
			  
			  <div <?php if($mode!=1){ ?>style="display:none;"<?php } ?> id="mode-description-1" class="mode-description">
				  <div class="col-sm-12"><?php echo $modes[1]['description']; ?></div>
			  </div>
			  
			  
			  <div <?php if($mode!=2){ ?>style="display:none;"<?php } ?> id="mode-description-2" class="mode-description">
				  <div class="col-sm-12"><?php echo $modes[2]['description']; ?></div>

			  <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
				<div class="form-group">
                <label class="col-sm-2 control-label" for="input-showeditor"><span data-toggle="tooltip" title="<?php echo $entry_fields_showeditor_help; ?>"><?php echo $entry_fields_showeditor; ?></span></label>
                <div class="col-sm-10">
                  <select name="showeditor" id="input-showeditor" class="form-control">
                    <?php if ($showeditor) { ?>
						<option value="1" selected="selected"><?php echo $text_yes; ?></option>
						<option value="0"><?php echo $text_no; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_yes; ?></option>
						<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<?php } ?> 
                  </select>
                </div>
              </div>
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-advanced<?php echo $language['language_id']; ?>">HTML:</label>
                    <div class="col-sm-10">
						<textarea name="advanced[<?php echo $language['language_id']; ?>][text]" placeholder="HTML" id="input-advanced<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control <?php if($showeditor){ ?>summernote<?php } ?>"><?php echo isset($advanced[$language['language_id']]) ? $advanced[$language['language_id']]['text'] : ''; ?></textarea>
                    </div>
                  </div>                 
                </div>
                <?php } ?>
              </div>
			  </div>
			  
			  <div <?php if($mode!=3){ ?>style="display:none;"<?php } ?> id="mode-description-3" class="mode-description">
				  <div class="col-sm-12"><?php echo $modes[3]['description']; ?></div>
			  </div>
			  
            </div>
            
          </div>
		  <input type="hidden" id="custom_fields_id" name="custom_fields_id" value="<?php echo $custom_fields_id; ?>" />
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
<?php if ($ckeditor && $showeditor) { ?>
	<?php foreach ($languages as $language) { ?>
		ckeditorInit('input-advanced<?php echo $language['language_id']; ?>', getURLVar('user_token'));
	<?php } ?>
<?php } ?>
//--></script>



<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
<script type="text/javascript"><!--

function getTypeAjax(){
	$.ajax({
		url: 'index.php?route=extension/module/custom_fields/getFieldAjax&user_token=<?php echo $user_token; ?>',
		type: 'post',
		data: $('#input-type, #custom_fields_id'),
		dataType: 'json',
		success: function(json) {
			
			
			if (json['error']) {
				
			} 
			
			if (json['success']) {
				$('#input-type-content').html(json['success']);
			}	
		}
	});
}
$(document).ready(function() {
	getTypeAjax();
});
$('#input-type').change(function(){
	getTypeAjax();
});
 //--></script>
</div>
<?php echo $footer; ?>
