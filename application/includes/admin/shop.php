<? 
$here = dirname(__FILE__);
$here = $here.DS.'shop'.DS;
  $active_action = url_param('action'); ?>
<? mw_create_default_content('shop') ?>
<? include($here .'nav.php'); ?> 
<? $is_shop = 'y'; ?>

<? 
$display_file = 'content.php';
if($active_action != false){
	$vf = $here.$active_action.'.php' ;
	
	if(is_file($vf)){
$display_file = ($vf);

}

}

?>

<? include($display_file); ?>