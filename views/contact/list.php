<?php
	$contact_res = $obj_contact->get();
?>
<?php
foreach( $contact_res as $row):
?>
	<div class="item">
    	
    	<?php
			echo $row['name'];
		?>
        <a  class="delete right" data-id="<?php echo $row['id'];?>">X</a>
        <br/>
        <?php
			echo $row['mobile'];
		?>
         <a  class="edit right" data-id="<?php echo $row['id'];?>">Edit</a>
        <br/>
        <?php
			echo $row['city'];
		?>
        <br/>
    </div>
<?php
endforeach;
?>
