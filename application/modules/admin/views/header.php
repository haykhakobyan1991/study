<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url() ?>application/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>application/css/font-awesome-ie7.css">
    <link rel="stylesheet" href="<?=base_url()?>application/jquery/choosen/chosen.css">
    <link rel="stylesheet" href="<?=base_url()?>application/jquery/choosen/docsupport/style.css">
    <link rel="stylesheet" href="<?=base_url()?>application/jquery/choosen/docsupport/prism.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />
    <!--    todo  -->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <!--  end  -->
    <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>application/css/style.css">

    <style type="text/css">
        .container > div {
                z-index: 10000;
                float: left;
                display: inline;
                margin: 0.8%;
                width: 100px;
                position: relative;
                padding: 2%;
                border: 2px solid gray;
                background: #95a9af
        }

        .container {
            padding: 120px 15px 10px;
            max-width: 960px;
            margin: 0 auto;
            float: none;
        }

        .content div {
            border-top: 1px solid;
        }

        .header {
        	     top: 0; 
			     left: 0; 
			    height: 70px;
			    background: #fafafa;
			    border-bottom: solid 2px #c7bfbf;
			    padding: 15px 15px 0 0;
    			z-index: 100000;
    			position: fixed; 
        }

        .logo {
        	margin-left: 1.5%;
        }

        header {
        	width: 100%;
        	float: left;
        	clear: both;
        }

        .logout {
        	width: 2%;
        }

        a.active {
            color: red;
        }
    </style>
</head>
<body>
	<?
		$sql = "SELECT 
					`user`.`id`,
					CONCAT_WS(' ', `user`.`first_name`, `user`.`last_name`) AS `name`
				FROM 
					`user`				
				WHERE (`username` = '".$this->session->username."' 
					OR `email` = '".$this->session->username."')
				LIMIT 1
				";

		$query = $this->db->query($sql);

		$account = $query->row_array();	
	?>
<header>
	<div class="header wh_100">
		<div class="logo wh_40"><a href="<?=base_url().'admin?lng='.($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy')?>"><img src="<?=base_url().'icons/logo.jpg'?>"></a></div>
		<div class="wh_50">
		    <div class="wh_10"><img width="50px" src="<?=base_url().'icons/user.png'?>"></div>
			<div class="wh_20 mt_3"><b><?=$account['name']?></b></div>
			<div class="wh_10" style="margin-left: 60%;"><a target="_blank" href="<?=base_url()?>">Web Site</a></div>
		</div>
        <div class=" wh_10 mt_2 float_r">
            <a <?=(($this->input->get('lng') == '' or $this->input->get('lng') == 'hy') ? 'class="active"' : '')?> title="HY" href="<?=current_url().'?lng=hy'?>">HY</a>
            <a <?=(($this->input->get('lng') == 'ru') ? 'class="active"' : '')?> title="RU" href="<?=current_url().'?lng=ru'?>">RU</a>
            <a <?=(($this->input->get('lng') == 'en') ? 'class="active"' : '')?> title="EN" href="<?=current_url().'?lng=en'?>">EN</a>
		    <a style="margin-left: 30%" title="Logout" href="<?=base_url().'admin/logout'?>"><img src="<?=base_url().'icons/small/logout.png'?>"></a>
		</div>




	</div>
</header>


