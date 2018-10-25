<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= (isset($meta_tags) ? $meta_tags : '') ?>
    <title>HOME</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/all.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/fontawesome.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>


    <style>
        header {
            height: 150px;
        }
    </style>

</head>

<body>

<header>
    <div class="center">
        <div class="logo pt_15">
            <a href="<?= base_url() ?>">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo" title="logo"/>
            </a>
        </div>

        <div class="nav_soc_wrapper">
            <nav>
                <li <?=($this->router->fetch_method() == 'index' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy')) ?>"><?=lang('Home')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'about' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/about') ?>"><?=lang('AboutUs')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'partner' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/partner') ?>"><?=lang('PartnerUniversity')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'courses' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/courses') ?>"><?=lang('Courses')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'requirements' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/requirements') ?>"><?=lang('Requirements')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'testimonials' ? 'class="active"' : '')?>>
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/testimonials') ?>"><?=lang('Testimonials')?>'</a>
                </li>
                <li <?=($this->router->fetch_method() == 'events' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/events') ?>"><?=lang('Events')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'register' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/register') ?>"><?=lang('Register')?></a>
                </li>
                <li <?=($this->router->fetch_method() == 'contact' ? 'class="active"' : '')?> >
                    <a href="<?= base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'hy') . '/contact') ?>"><?=lang('Contact')?></a>
                </li>

                <li class="langs" >
                    <ul class="">
                        <li class=" <?=(($this->uri->segment(1) == 'hy' or $this->uri->segment(1) == '') ? 'active' : '')?>" data-lang="hy"><a class="nav-link" href="javascript:void(0)">Հայ</a></li>
                        <li class=" <?=($this->uri->segment(1) == 'fr' ? 'active' : '')?>" data-lang="fr"><a class="nav-link" href="javascript:void(0)">Fra</a></li>
                        <li class=" <?=($this->uri->segment(1) == 'en' ? 'active' : '')?>" data-lang="en"><a class="nav-link" href="javascript:void(0)">Eng</a></li>
                    </ul>
                </li>
            </nav>

            <div class="social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google-plus"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</header>
