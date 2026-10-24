/* DEPLOY 2024-10-09 */
<?php
$waf_block_list = array (
);
return $waf->is_ip_in_array( $waf_block_list );
