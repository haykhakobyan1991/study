<?
$controller = $this->router->fetch_class();	
// TODO
$urls = "&permission=".$url_array['permission']."&id=".$url_array['id']."&title=".$url_array['title']."&status=".$url_array['status']."";
?>
<div class="wh_100 p_1 mt_7">
    	<div class="p_head">
    		<? if ($this->authorisation('sysadmin', 'add_role', 1)) { ?>
    			<button class="float_r"><a href="<?=base_url().'admin/'.$controller.'/add_role'?>">Add role</a></button>
    		<?}?>
    	</div>
    	<table class="responstable">


    	<?php echo form_open('admin/'.$controller.'/role'); ?>

    	  <tr>
		    <th><input type="number" name="id" value="<?=$url_array['id']?>"></th>
		    <th><input type="text" name="title" value="<?=$url_array['title']?>"></th>
		    <th>
                <select data-placeholder="Choose ..." class="chosen-select-width" tabindex="15" name="permission">
                    <option value=""></option>
                    <?
                    foreach ($result_pm as $row) {
                        echo '<option '.($url_array['permission'] == $row['id'] ? 'selected' : '').' value= "'.$row['id'].'" >'.$row['title'].'</option >';
                    }
                    ?>
                </select>
		    </th>
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
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_id=1<?=$urls?>">&uArr;</a></div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_id=2<?=$urls?>">&dArr;</a></div>
			    	<div>ID</div>
			    </div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_title=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_title=2<?=$urls?>">&dArr;</a></div>
				    <div>Title</div>
		    	</div>
		    </th>
		    <th style="width: 500px">
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_permission=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_permission=2<?=$urls?>">&dArr;</a></div>
			    	<div>Permission</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_status=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/role?by_status=2<?=$urls?>">&dArr;</a></div>
			    	<div>Status</div>
		    	</div>
		    </th>
		    <th></th>
		  </tr>
		  
		<?php foreach($result as $row):?>

		  <tr>
		    <td><?=$row['id'];?></td>
		    <td><?=$row['title']?></td>
		    <td><?=$row['permission'];?></td>
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
		    	<? if ($this->authorisation('sysadmin', 'edit_role', 1)) { ?>
		    		<a title="Edit" href="<?=base_url()?>admin/sysadmin/edit_role/<?=$row['id']?>"><span class="tb_ed"><i class="icon-edit"></i></span></a>
		    	<?}?>
		    	<? if ($this->authorisation('sysadmin', 'copy_role', 1)) { ?>
		    	<a title="Copy" href="<?=base_url()?>admin/sysadmin/copy_role/<?=$row['id']?>"><span class="tb_ed"><img src="<?=base_url()?>/icons/copy.png"></span></a>
		    	<?}?>
		    </td>
		  </tr>

		<?php endforeach;?>
		  
		</table>
        

        <span>Total <?=$num_rows?> data</span>
        <div><?=$this->pagination->create_links();?></div>
</div>