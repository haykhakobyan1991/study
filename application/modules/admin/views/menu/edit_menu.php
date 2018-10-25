<style type="text/css">
	h1 { 
		font-size:16pt; 
	}

	h2 {
	 	font-size:13pt;
	}

	ul {
		margin:0px;
		padding:0px; 
		border:1px solid;
	}

	#list1, #list2 { 
		width:500px; 
		list-style-type:none; 
		margin:0px; 
		float: left;
	}

	#list1 li, #list2 li { 
		float:left; width:95%; 
		list-style: none;
		 padding:5px; 
		 margin: 0 auto; 
	}

	#list1 div, #list2 div { 
		width:100%; 
		border:solid 1px black; 
		background-color:#E0E0E0; 
		text-align:center;
		margin: 0 auto; 
		padding:5px; 
	}

	#list2 {
	 	float:right; 
	}

	.placeHolder div { 
		background-color:white !important; 
		border:dashed 1px gray !important; 
	}
</style>
	<div class="form-style-10">
		<div class="p_head">
        	<button class="float_r"><a href="<?= base_url() ?>admin/sysadmin/edit_menu">Edit menu</a></button>
    	</div>

		<?php echo form_open_multipart(); ?>

		
		<div class="inner-wrap">
			<label id="message_suc" ><div class="success d_none"></div></label>
			<label id="message_err" ><div class="error d_none"></div></label>
			
			<input type="hidden" name="lng" value="</?=$lng?>">
			<input type="hidden" name="id" value="</?=$id?>">
	       
			<div class="wh_100">
				<ul id="list2">
				
				</ul>
				
				<ul id="list1">
				<?php foreach($result as $row):?>
					<li><div><?=$row['title']?><img width="150px"  src="<?=base_url()?>uploads/menu/big/<?=$row['image']?>"><input type="file" name="photo"></div></li>
				<?php endforeach;?>
				</ul>

				
				<!-- save sort order here which can be retrieved on server on postback -->
				<input name="list1SortOrder" type="hidden" />
			</div>

		</form>
	
		<div class="button-section btn" id="submit">
			<input type="submit" name="submit" value="Submit">
		</div>
	</div>
