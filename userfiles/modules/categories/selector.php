<script type="text/javascript">
<?php include_once( MW_INCLUDES_DIR . 'api/treerenderer.php'); ?>
</script>
<?php

$orig_params = ($params);

 $rand =  $params['id'];;
if (!isset($params['for'])) {

	$for = 'content';
} else {
	$for = $params['for'];
}


if (!isset($params['rel'])) {
	$for = 'content';

} else {
	$for = $params['rel'];
}

$is_shop = '';
$active_cats = array();

if(isset($params['data-subtype']) and $params['data-subtype'] == 'product'){
	$params['is_shop'] = 'y';
} else {
 	//$params['is_shop'] = 'n';
}


if (isset($params['is_shop'])) {
	$is_shop = '&is_shop=' . $params['is_shop'];
}

if (!isset($params['rel_id'])) {
	$rel_id = '';
	if (!isset($params['rel_id'])) {

	}

	if (isset($params['parent-category-id'])) {
		$active_cats [] = $params['parent-category-id'];
	}

} else {
	$rel_id = '&rel_id=' . $params['rel_id'];
}

?>
<?php
$cats_str = array();
$cats_ids = array();
$cats__parents = array();
$is_ex1 = array();
$for = mw('db')->assoc_table_name($for);



if (isset($params['is_shop']) and trim($params['is_shop']) =='y') {
  $is_ex = get_content('content_type=page&subtype=dynamic&is_shop=y&limit=100');
} else {
  $is_ex = get_content('parent=0&content_type=page&is_shop=n&limit=100');


}

if(is_array($is_ex)){
	foreach ($is_ex as $item) {
		$cats__parents[] = $item['id'];
	}
}


?>

 <script>

  $(document).ready(function(){


    mw.tools.tag({
      tagholder:'#mw-post-added-<?php print $rand; ?>',
      items: ".mw-ui-check",
      itemsWrapper: mwd.querySelector('#mw-category-selector-<?php print $rand; ?>'),
      method:'parse',
      onTag:function(){
        var curr_content = mwd.getElementById('mw-editor<?php print $rand; ?>').value;
        if(curr_content != undefined){
			  if(typeof load_iframe_editor === 'function'){
         	load_iframe_editor(curr_content);
			 }
       }
       else{
		     if(typeof load_iframe_editor === 'function'){
         	load_iframe_editor();
			}
       }
     },
     onUntag:function(){
      var curr_content = mwd.getElementById('mw-editor<?php print $rand; ?>').value;
      if(curr_content != undefined){
		 if(typeof load_iframe_editor === 'function'){
       		load_iframe_editor(curr_content);
		  }
     }
     else{
		 if(typeof load_iframe_editor === 'function'){
       			load_iframe_editor();
		 }
     }
   }
 });





  });

  </script>


<script  type="text/javascript">

$(document).ready(function(){

	mw.$('#<?php print $params['id'] ?> .mw-ui-check').bind('click', function(e){
			if(typeof mw_set_categories_from_tree === 'function'){
		 		mw_set_categories_from_tree()
			}
  	});

});


</script>
<?php


 if(!empty($cats__parents)): ?>
<?php

$active_cats1 = array();
foreach ($cats__parents as $item1) {

	$active_cats1[] = $item1;
//	$active_cats[] = $item1;
}
$tree = array();
$tree['include_categories'] = 1;
$tree['parent'] = '[int]0';



if (isset($orig_params['is_shop']) and trim($orig_params['is_shop']) == 'y') {

	$tree['is_shop'] = 'y';
	$tree['parent'] = 'any';


}

if (isset($params['active_ids'])) {
	$tree['active_ids'] = $params['active_ids'];

}


if (isset($params['categories_active_ids'])) {
	$tree['categories_active_ids'] = $params['categories_active_ids'];
$active_cats[] = $tree['categories_active_ids'];
} else if (!empty($active_cats1)) {
 	 // $tree['categories_active_ids'] = $active_cats1;

} else {


}


if (!empty($cats_ids)) {
	$cats_ids[] = $item1;
	// $tree['active_ids'] = $cats_ids;

}


$input_name = " name='parent' ";
if(isset($params['input-name'])){
	$input_name = " name='{$params['input-name']}' ";
}


$input_name_cats = "  ";
if(isset($params['input-name-categories'])){
	$input_name_cats = " name='{$params['input-name-categories']}' ";
}



$input_type_cats = "  type='checkbox'  ";
if(isset($params['input-type-categories'])){
	$input_type_cats = " type='{$params['input-type-categories']}' ";
}


$tree['active_code'] = 'checked="checked" ';
$tree['active_code'] = 'checked="checked" ';





$tree['link'] = "<label class='mw-ui-check'><input type='radio' {$input_name}  {active_code} value='{id}'   class='mw-ui-check-input-check' ><span></span><span>{title}</span></label>";
$tree['categores_link'] = "<label class='mw-ui-check'><input {$input_type_cats}  {$input_name_cats}   {active_code} value='{id}'   class='mw-ui-check-input-sel' ><span></span><span>{title}</span></label>";

if (isset($params['is_shop']) and trim($params['is_shop']) =='y') {
 } else {
$tree['is_shop'] = 'n';
}
if(isset($tree['is_shop'] )){

	unset($tree['is_shop'] );
}
mw('content')->pages_tree($tree);
?>
<?php endif; ?>
<?php  if(isset($params['include_global_categories']) and $params['include_global_categories'] == true  and isset($params['include_global_categories'])){




	$str0 = 'table=categories&limit=1000&data_type=category&' . 'parent_id=0&rel_id=0&rel=content';
	$fors = get($str0);

	if ($fors != false and is_array($fors) and !empty($fors)) {
		foreach ($fors as $cat) {
			$cat_params =$params;
			$pt_opts = array();
			$pt_opts['link'] = "<label class='mw-ui-check'><input type='checkbox'  {active_code} value='{id}' class='mw_cat_selector_{$rand}' ><span></span><span>{title}</span></label>";

			$pt_opts['parent'] =$cat['id'];
			$pt_opts['include_first'] = 1;
		}
	}








}


?>
<?php $cats_str = implode(',', $active_cats); ?>

<input type="hidden" name="categories" id="mw_cat_selected_for_post" value="<?php print $cats_str ?>" />
