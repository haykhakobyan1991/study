<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/admin/assets/images/favicon.png') ?>">
    <title>Admin template</title>

    <!-- Font Awesome  -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.css')?>" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/assets/extra-libs/multicheck/multicheck.css')?>">
    <link href="<?= base_url('assets/admin/assets/libs/flot/css/float-chart.css') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/assets/libs/quill/dist/quill.snow.css') ?>">
    <link href="<?= base_url('assets/admin/dist/css/style.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <style>
        .navbar-dark .navbar-nav .active > .nav-link {
            color: #fff !important;
        }

        .form-control, .thumbnail {
            border-radius: 2px;
        }
        .btn-danger {
            background-color: #B73333;
        }

        /* File Upload */
        .fake-shadow {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
        }
        .fileUpload #logo-id {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 33px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .img-preview {
            max-width: 100%;
        }


    </style>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

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


<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy')) ?>">
                    <!-- Logo icon -->
                    <b class="logo-icon p-l-10">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="<?= base_url('assets/admin/assets/images/logo-icon.png') ?>" alt="homepage"
                             class="light-logo"/>

                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                        <!-- dark Logo text -->
                        <img src="<?= base_url('assets/admin/assets/images/logo-text.png') ?>" alt="homepage"
                             class="light-logo"/>
                    </span>
                    <!-- Logo icon -->
                    <!-- <b class="logo-icon"> -->
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <!-- <img src="<?= base_url('assets/admin/assets/images/logo-text.png') ?>" alt="homepage" class="light-logo" /> -->

                    <!-- </b> -->
                    <!--End Logo icon -->
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                   aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                                                              href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                                    class="mdi mdi-menu font-24"></i></a></li>


                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right langs">
                    <!-- ============================================================== -->
                    <!-- language -->
                    <!-- ============================================================== -->
                    <li class="nav-item lang <?= (($this->uri->segment(2) == 'hy' or $this->uri->segment(1) == '') ? 'active' : '') ?>" data-lang="hy">
                        <a class="nav-link" href="javascript:void(0)">Հայ</a></li>
                    <li class="nav-item lang <?= ($this->uri->segment(2) == 'fr' ? 'active' : '') ?>" data-lang="fr">
                        <a class="nav-link" href="javascript:void(0)">Fra</a>
                    </li>
                    <li class="nav-item lang <?= ($this->uri->segment(2) == 'en' ? 'active' : '') ?>" data-lang="en">
                        <a class="nav-link" href="javascript:void(0)">Eng</a>
                    </li>
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->


                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <span class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="<?= base_url('assets/admin/assets/images/users/1.jpg') ?>" alt="user"
                                    class="rounded-circle m-3" width="31"></span>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">
                            <a  href="javascript:void(0)" class="dropdown-item"> <i class="ti-user m-r-5 m-l-5"></i> <?=$account['name']?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?=base_url('admin/logout')?>"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            <div class="dropdown-divider"></div>
                            <div class="p-l-30 p-10"><a target="_blank" href="<?=base_url()?>"
                                                        class="btn btn-sm btn-success btn-rounded">Web site</a>
                            </div>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->

    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <?
        $page = $this->router->fetch_method();

        ?>
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="p-t-30">

                    <li class="sidebar-item <?= ($page == 'index' ? 'selected' : '') ?>">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link <?= ($page == 'index' ? 'active' : '') ?>"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy')) ?>" aria-expanded="false">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/about_us') ?>" aria-expanded="false">
                            <i class="mdi mdi-face"></i>
                            <span class="hide-menu">About us</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/partner_university') ?>" aria-expanded="false">
                            <i class="fas fa-university"></i>
                            <span class="hide-menu">Partner University</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/grade_converter') ?>" aria-expanded="false">
                            <i class="fas fa-user-graduate "></i>
                            <span class="hide-menu">Grade Converter</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/courses') ?>" aria-expanded="false">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="hide-menu">Courses</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/requirements') ?>" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="hide-menu">Requirements</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/testimonials') ?>" aria-expanded="false">
                            <i class="fas fa-comments"></i>
                            <span class="hide-menu">Testimonials</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/events') ?>" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="hide-menu">Events</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="<?= base_url('admin/'.($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy').'/contact') ?>" aria-expanded="false">
                            <i class="fas fa-phone-square"></i>
                            <span class="hide-menu">Contact</span>
                        </a>
                    </li>




                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
