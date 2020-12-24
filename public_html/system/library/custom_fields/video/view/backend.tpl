	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-10">
			<input type="text" onchange="custom_fields_getYoutube($(this));" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][link]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link']:''; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" />
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
		
		<div class="custom_fields_video" <?php if(!isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link']) || !$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link']){ ?>style="display:none;"<?php } ?>>
		
			<div class="col-sm-4">
				<label class="col-sm-12 control-label"><?php echo $entry_video_title; ?></label>
				<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['title'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['title']:''; ?>" placeholder="<?php echo $entry_video_title; ?>" class="form-control video_title" />
				<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][vid]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['vid'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['vid']:''; ?>" class="form-control  video_vid" />
			</div>
			<div class="col-sm-2">
				<label class="col-sm-12 control-label"><?php echo $entry_video_dimensions; ?></label>
				<input onkeyup="$('.video_height').val(Math.round($(this).val()/$('.video_aspect').val()));" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][width]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['width'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['width']:''; ?>"  class="form-control video_width" style="display:inline-block; width:50px;" />
				x
				<input onkeyup="$('.video_width').val(Math.round($(this).val()*$('.video_aspect').val()));" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][height]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['height'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['height']:''; ?>"  class="form-control video_height" style="display:inline-block; width:50px;" />
			</div>
			<div class="col-sm-3">
				<label class="col-sm-12 control-label"><?php echo $entry_video_thumb; ?></label>
				<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][thumb]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb']:''; ?>" class="form-control video_thumb" />
				<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][aspect]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['aspect']:''; ?>" class="form-control video_aspect" />
				<div class="video_thumb_image video_thumb_div">
					<?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb']){ ?>
					<img class="img-responsive" src="<?php echo $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['thumb']; ?>" alt="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['title'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['title']:''; ?>" />
					<?php } ?>
				</div>
			</div>
			<div class="col-sm-3">
				<label class="col-sm-12 control-label"><?php echo $entry_video_html; ?></label>
				<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][html]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['html'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['html']:''; ?>" class="form-control video_html" />
				<div class="video_html_div">
					<?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['html']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['html']){ ?>
					<iframe style="max-width:100%;" id="preview-frame-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" src="https://www.youtube.com/embed/<?php echo $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['vid']; ?>?feature=oembed" frameborder="0"></iframe>
					<?php } ?>
				</div>
			</div>
		</div>

		
	</div>
	
<script type="text/javascript"><!--
if (typeof custom_fields_getYoutube === 'undefined') {
	function custom_fields_getYoutube(el) {
		var str = el.val();
		var matches = str.match(/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/);
		
		if(matches!==null){
			
			var block = el.parent().parent().find('.custom_fields_video');
			block.find('.video_title').val('');
			block.find('.video_vid').val('');
			block.find('.video_width').val('');
			block.find('.video_height').val('');
			block.find('.video_thumb').val('');
			block.find('.video_aspect').val('');
			block.find('.video_html').val('');
			
			block.find('.video_thumb_div').html('');
			block.find('.video_html_div').html('');
			
			$.ajax({
				url: "https://noembed.com/embed?url=https://www.youtube.com/watch?v="+matches[1],
				dataType: "json",
				success: function (data) {
					
					console.log(data);
					if(typeof(data.error) === 'undefined'){
						block.find('.video_title').val(data.title);
						block.find('.video_vid').val(matches[1]);
						block.find('.video_width').val(data.width);
						block.find('.video_height').val(data.height);
						block.find('.video_thumb').val(data.thumbnail_url);
						block.find('.video_aspect').val(data.width/data.height);
						block.find('.video_html').val(data.html);
						
						block.find('.video_thumb_div').html('<img class="img-responsive" src="'+data.thumbnail_url+'" alt="'+data.title+'" />');
						block.find('.video_html_div').html('<iframe style="max-width:100%;" src="https://www.youtube.com/embed/'+matches[1]+'?feature=oembed" frameborder="0"></iframe>');
						block.show('slow');
					}
				}
			});
		}
	};
}


//--></script>