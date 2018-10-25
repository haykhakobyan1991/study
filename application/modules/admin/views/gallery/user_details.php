<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    </head>
    <body>
    	<div class="w_40 det_g">
    		<div class="det_t"><h2><span class="float_l">User Details</span></h2><button><a href="<?=base_url()?>user">User list</a></button></div>
    	</div>
    	<div class="w_40 det_g">
			<div class="det_t">ID</div>
			<div class="det_v"><?=$id?></div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Admin</div>
			<div class="det_v"><?=($is_admin == '1' ? 'isAdmin' : 'Not isAdmin')?></div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Username</div>
			<div class="det_v"><?=$username?></div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Email</div>
			<div class="det_v"><?=$email?></div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Password</div>
			<div class="det_v">******</div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Photo</div>
			<div class="det_v"><?=$photo?></div>	
		</div>
		<div class="w_40 det_g">
			<div class="det_t">Status</div>
			<div class="det_v"><?=($status == '1' ? 'Active' : 'Passive')?></div>	
		</div>
    </body>
</html>