<?php only_admin_access(); ?>

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
	
	function add_subscriber() {
		add_subscriber_modal = mw.tools.open_module_modal('newsletter/add_subscriber', false, {overlay: true, skin: 'simple'});
	}
	
    function edit_subscriber(form) {
        
    	   var errors = {};
         var data = mw.serializeFields(form);
        
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
	                
	                $('#add-subscriber-form').hide();
	                $('#add-subscriber-form')[0].reset();
	
	                // Remove modal
	                if (typeof(add_subscriber_modal) != 'undefined' && add_subscriber_modal.modal) {
	               		add_subscriber_modal.modal.remove();
				       }
				       
	                // Reload the modules
	                mw.reload_module('newsletter/subscribers_list')
	                mw.reload_module_parent('newsletter');
	
	            }
	        });
        } else {
       		mw.notification.error('<?php _e('Please fill correct data.'); ?>');
        }
        
        return false;
    }
    
    function delete_subscriber(id) {
        var ask = confirm("<?php _e('Are you sure you want to delete this subscriber?'); ?>");
        if (ask == true) {
            var data = {};
            data.id = id;
            $.ajax({
                url: mw.settings.api_url + 'newsletter_delete_subscriber',
                type: 'POST',
                data: data,
                success: function (result) {
                    mw.notification.success('<?php _e('Subscriber deleted'); ?>');

                    // Reload the modules
                    mw.reload_module('newsletter/subscribers_list')
                    mw.reload_module_parent('newsletter')
                }
            });
        }
        return false;
    }
</script>

<button class="mw-ui-btn mw-ui-btn-icon" onclick="add_subscriber();"> 
	<span class="mw-icon-plus"></span> <?php _e('Add new subscriber'); ?>
</button>

<br />
<br />

<module type="newsletter/subscribers_list"/>