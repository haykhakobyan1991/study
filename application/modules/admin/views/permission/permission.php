<?
$controller = $this->router->fetch_class();	
// TODO
$urls = "&title=".$url_array['title']."&id=".$url_array['id']."&controller=".$url_array['controller']."&page=".$url_array['page']."&status=".$url_array['status']."";
?>
<div class="wh_100 p_1 mt_6">
    	<div class="p_head">
    		<? if ($this->authorisation('sysadmin', 'add_permission', 1)) { ?>
    			<button class="float_r"><a href="<?=base_url().'admin/'.$controller.'/add_permission'?>">Add permission</a></button>
    		<?}?>
    	</div>
    	<table class="responstable">


    	<?php echo form_open('admin/'.$controller.'/permission'); ?>

    	  <tr>
		    <th><input type="number" name="id" value="<?=$url_array['id']?>"></th>
		    <th>
                <input type="text" name="title" value="<?=$url_array['title']?>">
		    </th>
		    <th><input type="text" name="controller" value="<?=$url_array['controller']?>"></th>
		    <th><input type="text" name="page" value="<?=$url_array['page']?>"></th>
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
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_id=1<?=$urls?>">&uArr;</a></div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_id=2<?=$urls?>">&dArr;</a></div>
			    	<div>ID</div>
			    </div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_title=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_title=2<?=$urls?>">&dArr;</a></div>
				    <div>Title</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_controller=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_controller=2<?=$urls?>">&dArr;</a></div>
			    	<div>Controller</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_page=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_page=2<?=$urls?>">&dArr;</a></div>
			    	<div>Page</div>
		    	</div>
		    </th>
		    <th>
		    	<div>
			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_status=1<?=$urls?>">&uArr;</a></div>
				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/sysadmin/permission?by_status=2<?=$urls?>">&dArr;</a></div>
			    	<div>Status</div>
		    	</div>
		    </th>
		    <th></th>
		  </tr>
		  
		<?php foreach($result as $row):?>

		  <tr>
		    <td><?=$row['id'];?></td>
		    <td><?=$row['title']?></td>
		    <td><?=$row['controller'];?></td>
		    <td><?=$row['page']?>
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
		    	<? if ($this->authorisation('sysadmin', 'edit_permission', 1)) { ?>
		    		<a title="Edit" href="<?=base_url()?>admin/sysadmin/edit_permission/<?=$row['id']?>"><span class="tb_ed"><i class="icon-edit"></i></span></a>
		    	<?} if ($this->authorisation('sysadmin', 'copy_permission', 1)) {?>
		    		<a title="Copy" href="<?=base_url()?>admin/sysadmin/copy_permission/<?=$row['id']?>"><span class="tb_ed"><img src="<?=base_url()?>/icons/copy.png"></span></a>
		    	<?}?>
		    </td>
		  </tr>

		<?php endforeach;?>
		  
		</table>
        

        <span>Total <?=$num_rows?> data</span>
        <div><?=$this->pagination->create_links();?></div>
</div>