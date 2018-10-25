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
	        <label>Title <input type="text" name="title" value="" size="50" /></label>
	        <label>Alias <input type="text" name="alias" value="" size="50" /></label>
            <label>Photo <input type="file" name="photo" value="" size="50" /></label>
            <label>Date
                <div class="well">
                    <div id="datetimepicker1" class="input-append date">
                        <input name="date" data-format="yyyy-MM-dd hh:mm:ss" type="text" />
                        <span class="add-on">
                          <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                          </i>
                        </span>
                    </div>
                </div>
            </label>
            <label>Short Text  <textarea name="short_text" class="short_text" rows="10" cols="80"></textarea></label>
            <label>Text  <textarea name="text" class="text" rows="10" cols="80"></textarea></label>
	        <label>Status <div class="switch" data-name="status" data-yes="Active" data-y="1" data-n="-1" data-no="Passive" checked ></div></label>
	        <hr style="font-size: 40px; color: #fff ">

            <label>Meta Description <textarea name="meta_desc" class="meta_desc" rows="10" cols="80"></textarea></label>
            <label>Meta Tag <textarea name="meta_tag" class="meta_tag" rows="10" cols="80"></textarea></label>

        </div>


		</form>
		<div class="button-section" id="submit">
			<input type="submit" name="submit" value="Submit">
		</div>
	</div>


    <style>
        hr {
            display: block;
            height: 10px;
            border: 2px solid;
            margin: 1em 0;
            padding: 0;
            background: #fff;
            border-radius: 2px;
        }

    </style>
