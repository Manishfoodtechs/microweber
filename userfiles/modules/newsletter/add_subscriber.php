<?php only_admin_access(); ?>

<form id="add-subscriber-form" onSubmit="edit_subscriber(this); return false;">
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Subscriber Name'); ?></label> 
		<input name="name" type="text" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<div class="mw-ui-field-holder">
		<label class="mw-ui-label"><?php _e('Subscriber Email'); ?></label> 
		<input name="email" type="text" class="mw-ui-field mw-ui-field-full-width js-validation" />
		<div class="js-field-message"></div>
	</div>
	<button type="submit" class="mw-ui-btn"><?php _e('Save'); ?></button>
</form>