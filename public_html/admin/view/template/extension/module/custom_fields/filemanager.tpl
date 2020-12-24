<div id="filemanager" class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $heading_title; ?></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5"><a href="<?php echo $parent; ?>" data-toggle="tooltip" title="<?php echo $button_parent; ?>" id="custom_button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a> <a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" id="custom_button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" id="custom_button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_folder; ?>" id="custom_button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="custom_button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        </div>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="custom_search" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_search; ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="custom_button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
      </div>
      <hr />
      <?php foreach (array_chunk($images, 4) as $image) { ?>
      <div class="row">
        <?php foreach ($image as $image) { ?>
        <div class="col-sm-3 col-xs-6 text-center">
          <?php if ($image['type'] == 'directory') { ?>
          <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <span><?php echo $image['name']; ?></span></label>
          <?php } ?>
          <?php if ($image['type'] == 'image') { ?>
          <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <span><?php echo $image['name']; ?></span></label>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <br />
      <?php } ?>
    </div>
    <div class="modal-footer"><?php echo $pagination; ?></div>
  </div>
</div>
<script type="text/javascript"><!--
<?php if ($target) { ?>
$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

	<?php if ($thumb) { ?>
	$('#<?php echo $thumb; ?>').html($(this).parent().find('label span').html());
	<?php } ?>

	$('#<?php echo $target; ?>').val($(this).parent().find('input').val()).trigger('change');

	$('#modal-file').modal('hide');
});

<?php } else { ?>

$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

  //CKEditor
  <?php if ($cke){ ?>
      var cke_target = '<?php echo $cke; ?>' || null;
      cke_target = cke_target.split( ':' ); //link,txtUrl
      CKEDITOR.dialog.getCurrent().setValueOf(cke_target[0], cke_target[1], this.getAttribute('href'));
      //window.opener.CKEDITOR.tools.callFunction(<?php echo $cke; ?>, 'this.getAttribute('href'));
      //$('.cke_dialog_body img[src="'+ this.getAttribute('href') + '"]').first().remove();
  <?php } ?>

	$('#modal-file').modal('hide');
});
<?php } ?>

$('a.directory').on('click', function(e) {
	e.preventDefault();

	$('#modal-file').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-file').load($(this).attr('href'));
});

$('#custom_button-parent').on('click', function(e) {
	e.preventDefault();

	$('#modal-file').load($(this).attr('href'));
});

$('#custom_button-refresh').on('click', function(e) {
	e.preventDefault();

	$('#modal-file').load($(this).attr('href'));
});

$('input[name=\'custom_search\']').on('keydown', function(e) {
	if (e.which == 13) {
		$('#custom_button-search').trigger('click');
	}
});

$('#custom_button-search').on('click', function(e) {
	var url = 'index.php?route=extension/module/custom_fields/filemanager&user_token=<?php echo $user_token; ?>&directory=<?php echo $directory; ?>';

	var filter_name = $('input[name=\'custom_search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

  <?php if ($cke) { ?>
  url += '&cke=' + '<?php echo $cke; ?>';
  <?php } ?>

	<?php if ($thumb) { ?>
	url += '&thumb=' + '<?php echo $thumb; ?>';
	<?php } ?>

	<?php if ($target) { ?>
	url += '&target=' + '<?php echo $target; ?>';
	<?php } ?>

	$('#modal-file').load(url);
});
//--></script>
<script type="text/javascript"><!--
$('#custom_button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

	$('#form-upload input[name=\'file[]\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=extension/module/custom_fields/filemanager/upload&user_token=<?php echo $user_token; ?>&directory=<?php echo $directory; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#custom_button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#custom_button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#custom_button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#custom_button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#custom_button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#custom_button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '<?php echo $entry_folder; ?>',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="<?php echo $entry_folder; ?>" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="<?php echo $button_folder; ?>" id="custom_button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#custom_button-folder').on('shown.bs.popover', function() {
	$('#custom_button-create').on('click', function() {
		$.ajax({
			url: 'index.php?route=extension/module/custom_fields/filemanager/folder&user_token=<?php echo $user_token; ?>&directory=<?php echo $directory; ?>',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#custom_button-create').prop('disabled', true);
			},
			complete: function() {
				$('#custom_button-create').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#custom_button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});

$('#modal-file #custom_button-delete').on('click', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		$.ajax({
			url: 'index.php?route=extension/module/custom_fields/filemanager/delete&user_token=<?php echo $user_token; ?>',
			type: 'post',
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#custom_button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#custom_button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#custom_button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
//--></script>
