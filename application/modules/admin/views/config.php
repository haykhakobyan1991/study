<?$url=base_url()?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<?

		$yourfile = FCPATH.'application\config\routes.php';

		$file=fopen($yourfile,"r+");
		$str=file($yourfile);
		$conf = '';
		$arr = array();

		

		for ($i = 3; $i < sizeof($str); $i++) {
			$conf .= $str[$i];
		}

		$conf = strtr($conf, ' ', '');
		$conf = strtr($conf, ';', '=');
		$conf = substr($conf, 0, -2);
		$conf = explode('=', $conf);
		$conf_str = implode(',', $conf);
		$c = 0;	
	    
		echo '<div class="form-style-10">';
			echo form_open();
			fwrite($file, '<?'.PHP_EOL);
			fwrite($file, "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL);
			fwrite($file, '//start'.PHP_EOL);

				echo '<div class="inner-wrap">';
					echo '<label id="message_suc" ><div class="success d_none"></div></label>';
					echo '<label id="message_err" ><div class="error d_none"></div></label>';
				for ($n = 0; $n < sizeof($conf)-1; $n = $n+2) {
					$c = $n+1;
					echo '<label>'.$conf[$n];
					echo '<input name="route['.$c.']" type="text" value="'.($this->input->post('route')[$c] ? $this->input->post('route')[$c] : $conf[$c]).'" /></label>';

					$c = ($conf[$n].'='.($this->input->post('route')[$c] ? $this->input->post('route')[$c] : $conf[$c]).';');

					
					
					fwrite($file, $c);
					
				}



				
				fclose($file);
	
					
				echo '</div>';
				echo '<div class="button-section" id="submit">
						<input type="submit" name="submit" value="Submit">
					</div>';
			echo '</form>';
		echo '</div>';
		?>
	</body>
</html>