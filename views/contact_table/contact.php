<?php
include_once( __DIR__.'/../_header.php');
?>
<h1>Contact Management</h1>
<style>
.item {
	max-width:200px;
	min-width:200px;
	border: 1px solid #000;	
	float: left;
}
.b {
	font-weight:bold;	
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);


$(document).ready(function(){
	$('#ajax_loader').hide();
	$(document).ajaxStart(function(){
        $('#ajax_loader').show();
    });
	$(document).ajaxStop(function(){
        $('#ajax_loader').hide();
    });
    $.ajaxSetup({
		method: "POST"		
	});
	
    $("#add_frm").submit(function(e){
		e.preventDefault();
     	var data = $(this).serializeFormJSON() ;
		data.action = "add_edit";
		ajax_call(data, suc)
    });
	$(".item_container").on( 'click' , '.delete', function(e){
		e.preventDefault();
     	var data = {action: "delete", id: $(this).data('id') };
		
		ajax_call(data, suc)
    });
	$(".item_container").on( 'click' , '.edit', function(e){
		e.preventDefault();
     	var data = {action: "edit_form", id: $(this).data('id') };
		ajax_call(data, suc)
    });
	$(".item_container").on( 'click' , '.page_link', function(e){
		$('#paged').val( $(this).data('paged') );
     	$('#paged').trigger('change');
    });	
	$(".item_container").on( 'change' , '#filter_frm input', function(e){
		if( $(this).attr('name') != 'paged' )  
			$('#paged').val( 1 );
	   	var data = {action: "refresh_list"};
		ajax_call(data, suc)
	});
});

function fill(a){
    for(var k in a){
        $('[name="'+k+'"]').val(a[k]);
    }
}

function suc(res) {
	var res = JSON.parse( res );
	if( res.action == 'edit_form'  && res.success == '1' ) {
		fill( res.row )
	}
	else if( res.success == '1'){
		$('.item_container').html( res.html );
	}
	
	
	if( res.action == 'add_edit' ) {
		$('.reset').trigger('click');
	}
}

function ajax_call(data,  success_callback) {
	$.extend( data, $("#filter_frm").serializeFormJSON() );
	jQuery.ajax({
	   url: 'ajax_contact_table.php',
	   type: 'post',
	   data: data,
	   success: success_callback
  });
}
</script>

<form name="add_frm" id="add_frm" method="post" >
Name: <input type="text" name="name">
<br/>
Mobile: <input type="text" name="mobile">
<br/>
City: <input type="text" name="city">

<input type="hidden" name="id">
<br/>

<input type="submit" name="submit" id="submit" value="Save">
<input type="reset" class="reset" value="Reset">

</form>
<br/>
<div id="ajax_loader"> Loaing...</div>

<div class="item_container">
	<?php
	include_once( __DIR__ .'/list.php');
	?>
</div>
<?php
include_once( __DIR__.'/../_footer.php');
?>