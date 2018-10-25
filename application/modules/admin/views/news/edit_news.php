
	<div class="form-style-10">
		<div class="p_head">
        	<button class="float_r"><a href="<?= base_url() ?>admin/sysadmin/news">News</a></button>
    	</div>

		<?php echo form_open_multipart(); ?>

		<div class="inner-wrap">
			<label id="message_suc" ><div class="success d_none"></div></label>
			<label id="message_err" ><div class="error d_none"></div></label>
			<br>
			<input type="hidden" name="lng" value="<?=$lng?>">
			<input type="hidden" name="id" value="<?=$id?>">
	        <label>Title <input type="text" name="title" value="<?=$title?>" size="50" /></label>
	        <label>Alias <input type="text" name="alias" value="<?=$alias?>" size="50" /></label>
            <label class="photo" >Photo
                <?if($photo and $photo != '') {?>
                    <ul >
                        <li style="margin: 0 auto; list-style: none">
                            <input id="dell" style="padding: 0" type="button" value="X" >
                        </li>
                        <li style="width: 15%; list-style: none">
                            <img width="100%" src="<?=$photo_url.$photo?>" alt="">
                        </li>
                    </ul>
                    <input type="hidden" name="photo" value="<?=$photo?>">
                <?} else {?>
                    <input type="file" name="photo" value="" size="50" />
                <?}?>
            </label>

            <label>Date
                <div class="well">
                    <div id="datetimepicker1" class="input-append date">
                        <input name="date" data-format="yyyy-MM-dd hh:mm:ss" type="text" value="<?=$date?>" />
                        <span class="add-on">
                          <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                          </i>
                        </span>
                    </div>
                </div>
            </label>
            <label>Short Text  <textarea name="short_text" class="short_text" rows="10" cols="80"><?=$short_text?></textarea></label>
            <label>Text  <textarea name="text" class="text" rows="10" cols="80"><?=$text?></textarea></label>
	        <label>Status <div class="switch" data-name="status" data-yes="Active" data-y="1" data-n="-1" data-no="Passive" <?=($status == '1' ? 'checked' : '')?>  ></div></label>

            <hr style="font-size: 40px; color: #fff ">

            <label>Meta Description <textarea name="meta_desc" class="meta_desc" rows="10" cols="80"><?=$meta_desc?></textarea></label>
            <label>Meta Tag <textarea name="meta_tag" class="meta_tag" rows="10" cols="80"><?=$meta_tag?></textarea></label>
	    </div>


		</form>
		<div class="button-section" id="submit">
			<input type="submit" name="submit" value="Submit">
		</div>
	</div>
