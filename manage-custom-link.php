<?php
global $wpdb;
$table_name = $wpdb->prefix . "add_custom_link";
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$query = "delete from $table_name where custom_link_id='$id'";
	$wpdb->query($query);
	?>
	<script type="text/javascript">
	location.href='admin.php?page=manage-custom-link&msg=succ';
	</script>
	<?php
	die();
}
if(isset($_GET['msg'])&&$_GET['msg']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Your Link successfully successfully deleted.' ); ?></strong></p></div>
<?php
}
$query = "SELECT * FROM $table_name";
$result = mysql_query($query);
$count = mysql_num_rows($result);
$page_limit=ceil($count/10);
$rec_limit=10;
if(isset($_GET['pageno'])){
	$pageno=$_GET['pageno'] +1;
	$offset= $rec_limit * $pageno;
	$i=$offset;
}
else{
	$pageno=0;
	$offset=0;
}
$left_rec=$count-($rec_limit * $pageno);
$limited_results="SELECT * FROM `$table_name` as bac LEFT JOIN `$table_name` as bacl ON bac.parent_id =bacl.custom_link_id LIMIT $offset, $rec_limit";
$limited_result = mysql_query($limited_results);
/*
while($results = mysql_fetch_row($limited_result)){
	echo "<pre>";
	print_r($results);
}
die;
*/
?>
<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
    <?php    echo "<h2>" . __( 'Manage Custom Link', 'sumit_bansal' ) . "&nbsp;<a class=\"add-new-h2\" href=\"admin.php?page=add-custom-link\">Add New</a></h2>"; ?>  
    <?php $current_pageno=$pageno+1;
    if($pageno>0 && $left_rec > $rec_limit){
        $last = $pageno - 2;
        $last_pageno = $page_limit - 2;	
        $first =-1; 
        $first_page='href="admin.php?page=manage-custom-link&pageno='.$first.'" ';
        $previous_page= 'href="admin.php?page=manage-custom-link&pageno='.$last.'"';
        $next='href="admin.php?page=manage-custom-link&pageno='.$pageno.'" ';
        $last_page='href="admin.php?page=manage-custom-link&pageno='.$last_pageno.'"';
    }
    else if( $pageno == 0 ){
        $last = $page_limit - 2;
        $next='href="admin.php?page=manage-custom-link&pageno='.$pageno.'" ';
        $last_page='href="admin.php?page=manage-custom-link&pageno='.$last.'" ';
        $disable_pre='disabled';
    }
    else if( $left_rec <= $rec_limit){
        $last = $pageno - 2;
        $first =-1;
        $previous_page= 'href="admin.php?page=manage-custom-link&pageno='.$last.'"';
        $first_page='href="admin.php?page=manage-custom-link&pageno='.$first.'" ';
        $disable_next='disabled';
    }
    ?>
    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="displaying-num"><?php  echo $count.' Items';?></span>
            <span class="pagination-links">
                <a class="first-page <?php echo $disable_pre;?>" <?php echo $first_page ;?> title="Go to the first page">«</a>
                <a class="prev-page <?php echo $disable_pre;?>" <?php echo $previous_page ;?> title="Go to the previous page">‹</a>
                    <span class="paging-input">
                    <?php echo $current_pageno;?>of
                        <span class="total-pages"><?php echo $page_limit;?></span>
                    </span>
                <a class="next-page <?php echo $disable_next;?>" <?php echo $next ;?> title="Go to the next page">›</a>
                <a class="last-page <?php echo $disable_next;?>" <?php echo $last_page ;?> title="Go to the last page">»</a>
            </span>
        </div>
    </div>
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"> 
        <table class="wp-list-table widefat fixed" cellspacing="0">
            <thead>
              <tr>
                <th class="manage-column" scope="col">SN.</th>
                <th class="manage-column" scope="col">ID</th>
                <th class="manage-column" scope="col">Title</th>
                <th class="manage-column" scope="col">Parent</th>
                <th class="manage-column" scope="col">Hyperlink(href)</th>
                <th class="manage-column" scope="col">Action</th>
              </tr>
             </thead>
             <tbody>
             <?php if($count>0): $i++; while($results = mysql_fetch_row($limited_result)){ ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo strip_tags($results[1]); ?></td>
                <td><?php echo strip_tags($results[2]); ?></td>
                <td><?php if(strip_tags($results[6])!='') echo strip_tags($results[6]); else echo '-'; ?></td>
                <td><a href="<?php echo strip_tags($results[4]); ?>" target="_blank"><?php echo strip_tags($results[4]); ?></a></td>
                <td><a href="admin.php?page=manage-custom-link&edit=<?php echo strip_tags($results[0]); ?>" class="edit">Edit</a> | <a href="admin.php?page=manage-custom-link&id=<?php echo strip_tags($results[0]); ?>" class="delete">Delete</a></td>
              </tr>
             <?php $i++; } else: ?>
              <tr>
                <td colspan="6" align="center"><strong>No record found</strong></td>
              </tr>
              <?php endif; ?>
             </tbody>
             <tfoot>
             <tr>
             <th>SN.</th>
             <th class="manage-column" scope="col">ID</th>
                <th class="manage-column" scope="col">Title</th>
                <th class="manage-column" scope="col">Parent</th>
                <th class="manage-column" scope="col">Hyperlink(href)</th>
                <th class="manage-column" scope="col">Action</th>
             </tr>
            </tfoot>
        </table>
    </form>
    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="displaying-num"><?php  echo $count.' Items';?></span>
            <span class="pagination-links">
                <a class="first-page <?php echo $disable_pre;?>" <?php echo $first_page ;?> title="Go to the first page">«</a>
                <a class="prev-page <?php echo $disable_pre;?>" <?php echo $previous_page ;?> title="Go to the previous page">‹</a>
                    <span class="paging-input">
                    <?php echo $current_pageno;?>of
                        <span class="total-pages"><?php echo $page_limit;?></span>
                    </span>
                <a class="next-page <?php echo $disable_next;?>" <?php echo $next ;?> title="Go to the next page">›</a>
                <a class="last-page <?php echo $disable_next;?>" <?php echo $last_page ;?> title="Go to the last page">»</a>
            </span>
        </div>
    </div>
</div>
