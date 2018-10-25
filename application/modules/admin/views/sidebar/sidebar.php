<style type="text/css">
	.sidebar ul li {
	    border-bottom: 1px solid #607D8B;
	    font-size: 14px;
	    color: #000;
	    padding: 6px 12px;
	    width: 12%;
	}

	.sidebar ul {
	    margin: 0;
	    padding: 0;
	    list-style: none;
	}


</style>
<script src="<?=base_url()?>application/jquery/jquery.min.js"></script>
<script type='text/javascript'>
	$(document).on('keyup', 'input[name="search"]', function(){
		$('.sidebar ul li').show();
		$('.sidebar ul li' ).css( {"text-decoration": "none" , "background": "none" });
		var val = $(this).val();
		
		if (val != '') {
			$('.sidebar ul li:contains('+val+')' ).css( {"text-decoration": "underline"});
			$('.sidebar ul li').not('.sidebar ul li:contains('+val+')').hide();
		}
	});
</script>
<div>
	<input type="text" name="search" placeholder="Search">
</div>
<div class="sidebar">
	<ul>
		<li>gago</li>
		<li>vzgo</li>
		<li>ashot</li>
		<li>malxas</li>
		<li>petik</li>
		<li>marqarit</li>
		<li>laurik</li>
		<li>maretta</li>
		<li>tatevik</li>
		<li>heriknaz</li>
		<li>mary</li>
	</ul>
</div>