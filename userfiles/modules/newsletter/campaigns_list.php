<?php only_admin_access(); ?>
<?php
$campaigns_params = array();
$campaigns_params['no_limit'] = true;
$campaigns_params['order_by'] = "created_at desc";
$campaigns = newsletter_get_campaigns($campaigns_params);
?>
<?php if ($campaigns): ?>
    <div class="table-responsive">
        <table width="100%" border="0" class="mw-ui-table" style="table-layout:fixed">
            <thead>
            <tr>
                <th><?php _e('Name'); ?></th>
                <th><?php _e('Subject'); ?></th>
                <th><?php _e('From'); ?></th>
                <th><?php _e('Email'); ?></th>
                <th><?php _e('Created at'); ?></th>
                <th><?php _e('List'); ?></th>
                <th><?php _e('Done'); ?></th>
                <th width="140px">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($campaigns as $campaign): ?>
                <tr>
              	    <td>
                    <?php print $campaign['name']; ?>
                    </td>
                     <td>
                    <?php print $campaign['subject']; ?>
                    </td>
                     <td>
                    <?php print $campaign['from_name']; ?>
                    </td>
                    <td>
                    <?php print $campaign['from_email']; ?>
                    </td>
                    <td>
                    <?php print $campaign['created_at']; ?>
                    </td>
                    <td>
                    <?php print $campaign['list_id']; ?>
                    </td>
                    <td>
                    <?php
                    if ($campaign['is_done']) {
                    		_e('Yes');
                    } else {
                    		_e('No');
                    }
                    ?>
                    </td>
                    <td>
                        <button class="mw-ui-btn" onclick="edit_campaign('<?php print $campaign['id']; ?>')"><?php _e('Edit'); ?></button>
                        <a class="mw-ui-btn mw-ui-btn-icon" href="javascript:;" onclick="delete_campaign('<?php print $campaign['id']; ?>')"> <span class="mw-icon-bin"></span> </a>
                   </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>