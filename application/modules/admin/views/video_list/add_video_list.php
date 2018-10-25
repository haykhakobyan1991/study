	<div class="form-style-10">
		<div class="p_head">
        	<button class="float_r"><a href="<?= base_url() ?>admin/sysadmin/video_list">Video Category</a></button>
    	</div>

		<?php echo form_open_multipart(); ?>

		<div class="inner-wrap">
			<label id="message_suc" ><div class="success d_none"></div></label>
			<label id="message_err" ><div class="error d_none"></div></label>
			<br>
			<input type="hidden" name="lng" value="<?=$lng?>">
	        <label>Title <input type="text" name="title" value="" size="50" /></label>
	        <label>Alias <input type="text" name="alias" value="" size="50" /></label>
            <label>Text  <textarea name="text" class="text" rows="10" cols="80"></textarea></label>
	        <label>Status <div class="switch" data-name="status" data-yes="Active" data-y="1" data-n="-1" data-no="Passive" checked ></div></label>
	    </div>


		</form>
		<div class="button-section" id="submit">
			<input type="submit" name="submit" value="Submit">
		</div>
	</div>
