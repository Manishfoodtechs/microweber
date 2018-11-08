<?php

include 'functions/subscriber_functions.php';
include 'functions/campaign_functions.php';

event_bind('website.privacy_settings', function () {
	print '<h2>Newsletter settings</h2><module type="newsletter/privacy_settings" />';
});
