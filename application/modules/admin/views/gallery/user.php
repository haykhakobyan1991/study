<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/css/style.css">
        <link rel="stylesheet" href="<?=base_url()?>application/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>application/css/font-awesome-ie7.css">
    </head>
    <body>

  
    	<div><button><a href="<?=base_url()?>add_user">Add user</a></button></div>
    	<table class="responstable">

    	<!-- TODO: -->

    	<?
    	$urls = "&is_admin=".$url_array['is_admin']."&id=".$url_array['id']."&username=".$url_array['username']."&status=".$url_array['status']."";

    	?>

    	<?php echo form_open('user'); ?>

    	  <tr>
		    <th><input type="number" name="id" value="<?=$url_array['id']?>"></th>
		    <th>
		    	<select name="is_admin">
		    		<option value="">Choose</option>
		    		<option <?=($url_array['is_admin'] == '1' ? 'selected' : '')?> value="1">isAdmin</option>
		    		<option <?=($url_array['is_admin'] == '-1' ? 'selected' : '')?> value="-1">Not isAdmin</option>
		    	</select>
		    </th>
		    <th><input type="text" name="username" value="<?=$url_array['username']?>"></th>
		    <th></th>
		    <th>
		    	<select name="status">
		    		<option value="">Choose</option>
		    		<option <?=($url_array['status'] == '1' ? 'selected' : '')?> value="1">Active</option>
		    		<option <?=($url_array['status'] == '-1' ? 'selected' : '')?> value="-1">Passive</option>
		    	</select>
		    </th>
		    <th><input type="submit" name="submit" value="Search"></th>
		  </tr>

  		</form>
		  <tr>
		    <th>
		    	<div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_id=1<?=$urls?>">&uArr;</a></div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_id=2<?=$urls?>">&dArr;</a></div>
			    	<div>ID</div>
			    </div>
		    </th>
		    <th>
		    	<div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_is_admin=1<?=$urls?>">&uArr;</a></div>
				    <div style="float: right;"><a href="<?=base_url()?>user?by_is_admin=2<?=$urls?>">&dArr;</a></div>
			    	<div>Is admin</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_username=1<?=$urls?>">&uArr;</a></div>
				    <div style="float: right;"><a href="<?=base_url()?>user?by_username=2<?=$urls?>">&dArr;</a></div>
			    	<div>Username</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_password=1<?=$urls?>">&uArr;</a></div>
				    <div style="float: right;"><a href="<?=base_url()?>user?by_password=2<?=$urls?>">&dArr;</a></div>
			    	<div>Password</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div style="float: right;"><a href="<?=base_url()?>user?by_status=1<?=$urls?>">&uArr;</a></div>
				    <div style="float: right;"><a href="<?=base_url()?>user?by_status=2<?=$urls?>">&dArr;</a></div>
			    	<div>Status</div>
		    	</div>
		    </th>
		    <th></th>
		  </tr>
		  
		<?php foreach($result as $row):?>

		  <tr>
		    <td><?=$row['id'];?></td>
		    <td>
		    <?
		    	if($row['isAdmin'] == '1') {
		    		echo 'IsAdmin';
		    	}elseif($row['isAdmin'] == '-1') {
					echo 'Not isAdmin';
		    	}else {
		    		echo $row['isAdmin'];
		    	}
		    	
		    ?>
		    </td>
		    <td><?=$row['name'];?></td>
		    <td>
		    <?
		    	if($row['password'] != '') {
		    		echo '******';
		    	}else {
		    		echo 'Password is empty';
		    	}
		    ?>
		    </td>
		    <td>
		    <?
		    	if($row['status'] == '1') {
		    		echo 'Active';
		    	}elseif($row['status'] == '-1') {
					echo 'Passive';
		    	}else {
		    		echo $row['status'];
		    	}
		    	
		    ?>
		    </td>
		    <td>
		    	<a title="Edit" href="<?=base_url()?>edit_user/<?=$row['id']?>"><span class="tb_ed"><i class="icon-edit"></i></span></a>
		    	<!-- <a title="Copy" href="<?=base_url()?>copy_user/</?=$row['id']?>"><span style="cursor: pointer; color: #000;"><i class="fa fa-files-o" aria-hidden="true"></i></span></a> -->
		    	<a title="Details" href="<?=base_url()?>user_details/<?=$row['id']?>"><span class="tb_det"><i class="icon-angle-right"></i></i></span></a>
		    </td>
		  </tr>

		<?php endforeach;?>
		  
		</table>

		<span>Total <?=$num_rows?> data</span>
    </body>
</html>