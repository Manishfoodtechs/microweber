<?php
/* 
 * EMAIL CAMPAIGN FUNCTIONS
 */

api_expose_admin('newsletter_get_campaign');
function newsletter_get_campaign($campaign_id) {
    $data = ['id' => $campaign_id, 'single' => true];
    $table = "newsletter_campaigns";
    
    return db_get($table, $data);
}

api_expose('newsletter_get_campaigns');
function newsletter_get_campaigns($params) {
    if (is_string($params)) {
        $params = parse_params($params);
    }
    $params ['table'] = "newsletter_campaigns";
    return db_get($params);
}

api_expose('newsletter_save_campaign');
function newsletter_save_campaign($data) {
    $table = "newsletter_campaigns";
    return db_save($table, $data);
}

api_expose('newsletter_delete_campaign');
function newsletter_delete_campaign($params) {
    if (isset($params ['id'])) {
        $table = "newsletter_campaigns";
        $id = $params ['id'];
        return db_delete($table, $id);
    }
}

api_expose('newsletter_send_campaign');
function newsletter_send_campaign($params) {
   
    
}