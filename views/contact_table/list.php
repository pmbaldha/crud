<?php
	$page_size = 2;
	$paged = isset($_REQUEST['paged']) && intval($_REQUEST['paged']) > 0 ?  intval($_REQUEST['paged']) : 1;
	$wh_query = "";
	if( isset($_POST['fname']) && !empty($_POST['fname']) ) {
		$wh_query .= " AND name LIKE '".$_POST['fname']."%'";
	}
	if( isset($_POST['fcity']) && !empty($_POST['fcity']) ) {
		$wh_query .= " AND city LIKE '".$_POST['fcity']."%'";
	}
	if( isset($_POST['fmobile']) && !empty($_POST['fmobile']) ) {
		$wh_query .= " AND mobile LIKE '".$_POST['fmobile']."%'";
	}
	
	$contact_res = $obj_contact->view($wh_query, $select_field = "*", $paged, $page_size );
	
?>
<form id="filter_frm" name="filter_frm">
<table>
	
	<tr>
		<th>
        	<input type="text" name="fname" value="<?php echo isset($_REQUEST['fname'])?$_REQUEST['fname']:'';?>" />
        </th>
        <th>
        	<input type="text" name="fmobile" value="<?php echo isset($_REQUEST['fmobile'])?$_REQUEST['fmobile']:'';?>" />
        </th>
        <th>
            <input type="text" name="fcity" value="<?php echo isset($_REQUEST['fcity'])?$_REQUEST['fcity']:''; ?>"/>
        </th>
        <th>
        	<input type="text" name="paged" id="paged" value="<?php echo $paged;?>" />
        </th>            
    </tr>
   
	<tr>
		<th>
        Name
        </th>
        <th>
        Mobile
        </th>
        <th>
        City
        </th>
        <th>
        Action
        </th>            
    </tr>

	<?php
    foreach( $contact_res['res'] as $row):
    ?>
		 <tr>
     		<td>       
				<?php
                    echo $row['name'];
                ?>
            </td>
			<td>
				<?php
                    echo $row['mobile'];
                ?>
			</td>            
			<td>
				<?php
                    echo $row['city'];
                ?>
			</td>            
            
            <td>
	             <a  class="edit right" data-id="<?php echo $row['id'];?>">Edit</a>
                 &nbsp;
                 <a  class="delete right" data-id="<?php echo $row['id'];?>">X</a>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
</form>
<?php
$cnt = $contact_res['cnt'];
$total_page = ceil($cnt / $page_size);
if( $total_page > 1) :
	for($i=1; $i <= $total_page; $i++ ) :
	?>
		<span class="page_link <?php echo $paged==$i ? 'b' :'' ?>" data-paged="<?php echo $i;?>"><?php echo $i;?></span>
<?php
	endfor;
endif;
?>

