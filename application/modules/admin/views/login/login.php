<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
	<link href="<?=base_url()?>application/css/styleadmin.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="lg-container">
		<h2>Sing in</h2>
		<?
		 $attributes = array('id' => 'lg-form');
		 echo form_open('admin/login', $attributes);
		?>
			
			<div>
				<label for="username">Login</label>
				<input type="text" name="name" id="username" placeholder="Login" required="" value="<?php echo $username;?>" >
			</div>
			
			<div>
				<label for="password">Password</label>
				<input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password;?>" >
			</div>
			
			<div>				
				 <input name="submit" type="submit" id="login" value="Login">
			</div>
			
		</form>
		<div id="message"><?php echo $error;?></div>
	</div>
</body>
</html>