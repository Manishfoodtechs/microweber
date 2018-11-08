<?php

include 'subscriber_functions.php';
include 'campaign_functions.php';

event_bind('website.privacy_settings', function () {
	print '<h2>Newsletter settings</h2><module type="newsletter/privacy_settings" />';
});
