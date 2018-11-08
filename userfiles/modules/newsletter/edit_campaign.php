<?php only_admin_access(); ?>

<?php 
if (isset($params['id'])) {
    $campaign = newsletter_get_campaign($params['id']);
}
?>

<style>
.mw-ui-field-full-width {
	width:100%;
}
.js-danger-text {
	padding-top: 5px;
	color: #c21f1f;
}
</style>

<script>
	mw.require("<?php print $config['url_to_module'];?>/js/js-helper.js");
	
	$(document).ready(function () {
		
		$(document).on("change", ".js-validation", function() {
			$(':input').each(function() {
				if ($(this).hasClass('js-validation')) {
					runFieldsValidation(this);
				}
			});
		});

		$(".js-edit-campaign-form").submit(function(e) {
			
			e.preventDefault(e);
				
			 var errors = {};
	         var data = mw.serializeFields(this);
	        
			$(':input').each(function(k,v) {
					if ($(this).hasClass('js-validation')) {
						if (runFieldsValidation(this) == false) {
							errors[k] = true;
						}
					}
			});
			
	        if (isEmpty(errors)) {
				
		        $.ajax({
		            url: mw.settings.api_url + 'newsletter_save_campaign',
		            type: 'POST',
		            data: data,
		            success: function (result) {
			            
		                mw.notification.success('<?php _e('Campaign saved'); ?>');
		
		                // Remove modal
		                if (typeof(edit_campaign_modal) != 'undefined' && edit_campaign_modal.modal) {
		                	edit_campaign_modal.modal.remove();
					     }
					       
		                // Reload the modules
		                mw.reload_module('newsletter/campaigns_list')
		                mw.reload_module_parent('newsletter');
		
		            },
					error: function(e) {
						alert('Error processing your request: ' + e.responseText);
					}
		        });
	        } else {
	       		mw.notification.error('<?php _e('Please fill correct data.'); ?>');
	        }
		});
		
	});

	function runFieldsValidation(instance) {
		
		var ok = true;
		var inputValue = $(instance).val().trim();
		
		$(instance).removeAttr("style");
		$(instance).parent().find(".js-field-message").html('');

		if (inputValue == "") {
			$(instance).css("border", "1px solid #b93636");
			$(instance).parent().find('.js-field-message').html(errorText('<?php _e('The field cannot be empty'); ?>'));
			ok = false;
		}

		if ($(instance).hasClass('js-validation-email')) {
			if (validateEmail(inputValue) == false) {
				$(instance).css("border", "1px solid #b93636");
				$(instance).parent().find('.js-field-message').html(errorText('<?php _e('The email address is not valid.'); ?>'));
				ok = false;
			}
		}

		return ok;
	}
</script>

<form class="js-edit-campaign-form">
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Name'); ?></label> 
		<input name="name" value="<?php echo $campaign['name']; ?>" type="text" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Subject'); ?></label> 
		<input name="subject" value="<?php echo $campaign['subject']; ?>" type="text" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Campaign Name'); ?></label> 
		<input name="from_name" value="<?php echo $campaign['from_name']; ?>" type="text" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Campaign Email'); ?></label> 
		<input name="from_email" value="<?php echo $campaign['from_email']; ?>" type="text" class="mw-ui-field mw-ui-field-full-width js-validation js-validation-email" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Done'); ?></label> 
		<input name="is_done" value="<?php echo $campaign['is_done']; ?>" type="checkbox" />
	</div>
	<button type="submit" class="mw-ui-btn"><?php _e('Save'); ?></button>
	<?php if(isset($campaign['id'])): ?>
	<a class="mw-ui-btn mw-ui-btn-icon" href="javascript:;" onclick="delete_campaign('<?php print $campaign['id']; ?>')"> <span class="mw-icon-bin"></span> </a>
	<input type="hidden" value="<?php echo $campaign['id']; ?>" name="id" />
	<?php endif; ?>
</form>