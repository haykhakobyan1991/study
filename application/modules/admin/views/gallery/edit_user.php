<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
	</head>
	<body>
	
	<div class="form-style-10">
		<h1>Edit User!<span>edit user for TeamTime!  <button><a href="<?=base_url()?>user">User list</a></button></span></h1>
		
		<?php echo form_open(); ?>

		<div class="inner-wrap">
			<label id="message_suc" ><div class="success d_none"></div></label>
			<label id="message_err" ><div class="error d_none"></div></label>
			<input type="hidden" name="id" value="<?=$id?>">
	        <label>IS admin <input type="text" name="is_admin" value="<?=$is_admin?>" size="50" /></label>
	        <label>Username <input type="text" name="name" value="<?=$username?>" size="50" /></label>
	        <label>Email <input type="email" name="email" value="<?=$email?>" size="50" /></label>
	        <label>Photo <input type="text" name="photo" value="<?=$photo?>" size="50" /></label>
	    </div>


		</form>
		<div class="button-section" id="submit">
			<input type="submit" name="submit" value="Submit">
		</div>
	</div>
	</body>
</html>