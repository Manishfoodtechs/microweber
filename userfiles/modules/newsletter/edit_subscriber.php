<?php only_admin_access(); ?>

<?php 
if (isset($params['id'])) {
    $subscriber = newsletter_get_subscriber($params['id']);
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

		$(".js-edit-subscriber-form").submit(function(e) {
			
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
		            url: mw.settings.api_url + 'newsletter_save_subscriber',
		            type: 'POST',
		            data: data,
		            success: function (result) {
			            
		                mw.notification.success('<?php _e('Subscriber saved'); ?>');
		
		                // Remove modal
		                if (typeof(edit_subscriber_modal) != 'undefined' && edit_subscriber_modal.modal) {
		                	edit_subscriber_modal.modal.remove();
					     }
					       
		                // Reload the modules
		                mw.reload_module('newsletter/subscribers_list')
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
	

<form class="js-edit-subscriber-form">
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Subscriber Name'); ?></label> 
		<input name="name" type="text" value="<?php echo $subscriber['name']; ?>" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Subscriber Email'); ?></label> 
		<input name="email" type="text"  value="<?php echo $subscriber['email']; ?>" class="mw-ui-field mw-ui-field-full-width js-validation js-validation-email" />
		<div class="js-field-message"></div>
	</div>
	<button type="submit" class="mw-ui-btn"><?php _e('Save'); ?></button>
	<?php if(isset($subscriber['id'])): ?>
	<a class="mw-ui-btn mw-ui-btn-icon" href="javascript:;" onclick="delete_subscriber('<?php print $subscriber['id']; ?>')"> <span class="mw-icon-bin"></span> </a>
	<input type="hidden" value="<?php echo $subscriber['id']; ?>" name="id" />
	<?php endif; ?>
</form>