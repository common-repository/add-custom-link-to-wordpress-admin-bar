<?php
global $wpdb;
$table_name = $wpdb->prefix . "add_custom_link";
if($_POST['add_link']=='Y'):
	$id = $_POST['custom_link_id'];
	$title = $_POST['custom_link_title'];
	$parent = $_POST['custom_link_parent'];
	$href = $_POST['custom_link_href'];
	$query = "SELECT * FROM $table_name where id='$id'";
	$results_new = $wpdb->get_results($query);
	$check_counter=count($results_new);
	if($check_counter>0){
		echo ' <div class="error">Id Already Exists! Link Id Must Be Unique.</div>'; 
		}
	else{
	    $query = "insert into $table_name set id='$id', title='$title', parent_id='$parent', href='$href'";
	    $results = $wpdb->query($query);
	?>
        <script type="text/javascript">
	    location.href='admin.php?page=add-custom-link&msg=succ';
	    </script>
    <?php
        die();
	    }
endif;
if(isset($_GET['msg'])&&$_GET['msg']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Your Link successfully saved.' ); ?></strong></p></div>
<?php }
?>
<div class="wrap">  
<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<?php    echo "<h2>" . __( 'Add Custom Link', 'sumit_bansal' ) . "</h2>"; ?>

	<form name="custom_link_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<table>
		  <tr>
			<td><?php _e("Link Id: " ); ?></td>
			<td><input type="text" name="custom_link_id" id="custom_link_id" value="<?php echo $id; ?>" /></td>
		  </tr>
		  <tr>
			<td><?php _e("Link Title: " ); ?></td>
			<td><input type="text" name="custom_link_title" id="custom_link_title" value="<?php echo $title; ?>" /></td>
		  </tr>
		  <tr>
			<td><?php _e("Link Parent: " ); ?></td>
			<td><select name="custom_link_parent" id="custom_link_parent">
					<option value="0">Self Parent</option>
					<?php $results = $wpdb->get_results('SELECT custom_link_id, id FROM '.$table_name);  foreach($results as $result){ ?>
					<option value="<?php echo strip_tags($result->custom_link_id); ?>"<?php if($parent==strip_tags($result->custom_link_id)) echo ' selected="selected"'; ?>><?php echo strip_tags($result->id); ?></option>
					<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<td><?php _e("Link(Hyperlink): " ); ?></td>
			<td><input type="text" name="custom_link_href" id="custom_link_href" value="<?php echo $href; ?>" /></td>
		  </tr>
		  <tr>
			<td colspan="2" class="submit"><input type="submit" name="Submit" value="<?php _e('Add Link', 'sumit_bansal' ) ?>" /> </td>
		  </tr>
	<input type="hidden" name="add_link" value="Y">  
	</form>  
</div>