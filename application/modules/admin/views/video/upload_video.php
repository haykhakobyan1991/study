	<style type="text/css">
		progress {
			border: 1px solid #0c99d6;
		    border-radius: 5px;
		    width: 30%;
		    height: 5%;
		}
	</style>
	<div class="form-style-10">

		<?php echo form_open_multipart(); ?>

		<div class="inner-wrap">
			<label id="message_suc" ><div class="success d_none"></div></label>
			<label id="message_err" ><div class="error d_none"></div></label>
			<br>
        	<label>Video <input id="video" type="file" name="video" value="" size="50" /></label>
	      
	        <br>
	        <label>progress <progress id="progress" value="0" max="100"></label>
        	<label><h3 id="status"></h3></label>
  			<label><p id="loaded_n_total"></p></label>
	        
	    </div>


		</form>
		<div class="button-section" id="submit">
			<input type="submit" name="submit" onclick="uploadFile()" value="Submit">
		</div>

		
	</div>
