<?

$controller = $this->router->fetch_class();	

// TODO

$urls = "&id=".$url_array['id']."&title=".$url_array['title']."&status=".$url_array['status']."";

?>

<div class="wh_100 p_1 mt_7">

    	<div class="p_head">

    		<? if ($this->authorisation('sysadmin', 'add_video_list', 1)) { ?>

    			<button class="float_r"><a href="<?=base_url().'admin/'.$controller.'/add_video_list'?>?lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">Add Video category</a></button>

    		<?}?>

    	</div>

    	<table class="responstable">





    	<?php echo form_open('admin/'.$controller.'/video_list'); ?>



    	  <tr>

		    <th><input type="number" name="id" value="<?=$url_array['id']?>"></th>

		    <th><input type="text" name="title" value="<?=$url_array['title']?>"></th>

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

			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_id=1<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&uArr;</a></div>

			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_id=2<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&dArr;</a></div>

			    	<div>ID</div>

			    </div>

		    </th>

		    <th>

		    	<div>

			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_title=1<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&uArr;</a></div>

				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_title=2<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&dArr;</a></div>

				    <div>Title</div>

		    	</div>

		    </th>

		    <th>

		    	<div>

			    	<div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_status=1<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&uArr;</a></div>

				    <div class="change" style="float: right;"><a href="<?=base_url()?>admin/Sysadmin/video_list?by_status=2<?=$urls?>&lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">&dArr;</a></div>

			    	<div>Status</div>

		    	</div>

		    </th>

		    <th></th>

		  </tr>

		  

		<?php foreach($result as $row):?>



		  <tr>

		    <td><?=$row['id'];?></td>

		    <td><?=$row['title']?></td>

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

		    	<? if ($this->authorisation('sysadmin', 'edit_video_list', 1)) { ?>

		    		<a title="Edit" href="<?=base_url()?>admin/Sysadmin/edit_video_list/<?=$row['id']?>?lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>">><span class="tb_ed"><i class="icon-edit"></i></span></a>

		    	<?}?>



		    	<? if ($this->authorisation('sysadmin', 'copy_video_list', 1)) { ?>

		    	<a title="Copy" href="<?=base_url()?>admin/Sysadmin/copy_video_list/<?=$row['id']?>?lang=<?=($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>"><span class="tb_ed"><img src="<?=base_url()?>/icons/copy.png"></span></a>

		    	<?}?>

		    </td>

		  </tr>



		<?php endforeach;?>

		  

		</table>

        



        <span>Total <?=$num_rows?> data</span>

        <div><?=$this->pagination->create_links();?></div>

</div>