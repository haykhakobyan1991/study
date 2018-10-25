<?
$controller = $this->router->fetch_class();	
// TODO
$urls = "&role=".$url_array['role']."&id=".$url_array['id']."&username=".$url_array['username']."&name=".$url_array['name']."&status=".$url_array['status']."";
?>
<div class="wh_100 p_1 mt_6">
    	<div class="p_head">
    		<? if ($this->authorisation('sysadmin', 'add_user', 1)) { ?>
    		<button class="float_r"><a href="<?=base_url().'admin/'.$controller.'/add_user'?>">Add user</a></button>
    		<?}?>
    	</div>
    	<table class="responstable">


    	<?php echo form_open('admin/'.$controller.'/user'); ?>

    	  <tr>
		    <th><input type="number" name="id" value="<?=$url_array['id']?>"></th>
		    <th>
                <select data-placeholder="Choose ..." class="chosen-select-width" tabindex="15" name="role">
                    <option value=""></option>
                    <?
                    foreach ($result_role as $row) {
                        echo '<option '.($url_array['role'] == $row['id'] ? 'selected' : '').' value= "'.$row['id'].'" >'.$row['title'].'</option >';
                    }
                    ?>
                </select>
		    </th>
		    <th><input type="text" name="username" value="<?=$url_array['username']?>"></th>
		    <th><input type="text" name="name" value="<?=$url_array['name']?>"></th>
		    <th>
		    	<select data-placeholder="Choose a Status..." class="chosen-select-width" tabindex="15" name="status">
                    <option value=""></option>
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
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_id=1<?=$urls?>">&uArr;</a></div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_id=2<?=$urls?>">&dArr;</a></div>
			    	<div>ID</div>
			    </div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_role=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_role=2<?=$urls?>">&dArr;</a></div>
				    <div>Role</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_username=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_username=2<?=$urls?>">&dArr;</a></div>
			    	<div>Username</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_name=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_name=2<?=$urls?>">&dArr;</a></div>
			    	<div>Name</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_status=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/user?by_status=2<?=$urls?>">&dArr;</a></div>
			    	<div>Status</div>
		    	</div>
		    </th>
		    <th></th>
		  </tr>
		  
		<?php foreach($result as $row):?>

		  <tr>
		    <td><?=$row['id'];?></td>
		    <td><?=$row['title']?></td>
		    <td><?=$row['username'];?></td>
		    <td><?=$row['user_name']?>
		    </td>
		    <td>
		    <?
		    	if($row['status'] == '1') {
		    		echo 'Active';
		    	}elseif($row['status'] == '-1') {
					echo 'Passive';
                }elseif($row['status'] == '-2') {
		    	    echo 'Suspended';
		    	}else {
		    		echo $row['status'];
		    	}
		    	
		    ?>
		    </td>
		    <td>
		    	<? if ($this->authorisation('sysadmin', 'edit_user', 1)) { ?>
		    		<a title="Edit" href="<?=base_url()?>admin/sysadmin/edit_user/<?=$row['id']?>"><span class="tb_ed"><i class="icon-edit"></i></span></a>
		    	<?}?>
		    </td>
		  </tr>

		<?php endforeach;?>
		  
		</table>
        

        <span>Total <?=$num_rows?> data</span>
        <div><?=$this->pagination->create_links();?></div>
</div>