<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dashboard - Admin Dominion</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{asset('assets/img/favicon.ico') }}" type="image/x-icon" />

        <!--<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">-->

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/c3/c3.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/dist/css/theme.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/jquery-bar-rating/dist/themes/css-stars.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css') }}">
        <style type="text/css">
        @media print {
           .noprint {
              /*visibility: hidden !important;*/
              display: none !important;
              height: 0;
           }
           .header-top{
               display: none !important;
           }
           
           .wrapper .page-wrap .main-content {
                padding-left: 0px;
           }
           .app-sidebar{
               display: none !important;
           }
           @page { margin: 0 !important;}
            body{ margin: 0.6 mm !important; }
        }
        </style>
        <!-- CSS only -->
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">--> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
        <link rel="stylesheet" href="{{asset('assets/dist/css/theme.min.css') }}">
        <link href="{{ asset('css/glyphicon.css') }}" rel="stylesheet">
        <!--<link href="{{ asset('css/preview.css') }}" rel="stylesheet">-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
        <script src="{{asset('assets/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        
        
       
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrapper">
            <header class="header-top noprint" header-theme="dark">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <div class="header-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                                </div>
                            </div>
                            <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
                        </div>
                        <div class="top-menu d-flex align-items-center">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span class="badge badge-notif bg-danger"></span></a>
                                <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                                    <h4 class="header">Notifications</h4>
                                    <div class="notifications-wrap notification-list">
                                        
                                    </div>
                                    <div class="footer"><a href="{{route('alerts.index')}}">Voir tout</a></div>
                                </div>
                            </div>
                            <!--<button type="button" class="nav-link ml-10 right-sidebar-toggle"><i class="ik ik-message-square"></i><span class="badge bg-success">3</span></button>-->
                            <!--<div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-plus"></i></a>
                                <div class="dropdown-menu dropdown-menu-right menu-grid" aria-labelledby="menuDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Dashboard"><i class="ik ik-bar-chart-2"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Message"><i class="ik ik-mail"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Accounts"><i class="ik ik-users"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Sales"><i class="ik ik-shopping-cart"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Purchase"><i class="ik ik-briefcase"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Pages"><i class="ik ik-clipboard"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Chats"><i class="ik ik-message-square"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Contacts"><i class="ik ik-map-pin"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Blocks"><i class="ik ik-inbox"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Events"><i class="ik ik-calendar"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Notifications"><i class="ik ik-bell"></i></a>
                                    <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="More"><i class="ik ik-more-horizontal"></i></a>
                                </div>
                            </div>-->
                            <!--<button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button>-->
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{url('/storage/profile_images/'.auth()->user()->profile_picture) }}" alt=""></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('profils.index')}}"><i class="ik ik-user dropdown-icon"></i> Profil</a>
                                    <a class="dropdown-item" href="{{ route('setting')}}"><i class="ik ik-settings dropdown-icon"></i> Paramètres</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ik ik-power dropdown-icon" ></i> Déconnexion</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <div class="page-wrap">
                <div class="app-sidebar colored noprint">
                    <div class="sidebar-header">
                        <a class="header-brand" href="{{ route('dashboard') }}">
                            <div class="logo-img">
                               <!--<img src="{{asset('assets/src/img/brand-white.svg') }}" class="header-brand-img" alt="lavalite">-->
                            </div>
                            <span class="text">DOMINION</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    
                    <div class="sidebar-content noprint">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                                <div class="nav-lavel">MENU</div>
                                <div class="nav-item active">
                                    <a href="{{ route('dashboard') }}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-layers"></i><span>Commandes</span> <!--<span class="badge badge-danger">10+</span>--></a>
                                    <div class="submenu-content">
                                        <a href="{{ route('orders.index') }}" class="menu-item">Demandes de commandes</a>
                                        <a href="{{route('pending-orders')}}" class="menu-item">Commandes à collecter</a>
                                        <a href="{{route('todeliver-orders')}}" class="menu-item">Commandes à livrer</a>
                                        <a href="{{route('totake')}}" class="menu-item">Commandes du jour à livrer</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-layers"></i><span>Livraisons</span> <!--<span class="badge badge-danger">10+</span>--></a>
                                    <div class="submenu-content">
                                        <a href="{{route('pending-deliveries')}}" class="menu-item">Livraisons en attente</a>
                                        <a href="{{ route('deliveries.index') }}" class="menu-item">Livraisons effectuées</a>
                                    </div>
                                </div>

                                <div class="nav-item">
                                    <a href="{{ route('payments.index') }}"><i class="ik ik-credit-card"></i><span>Paiements</span> <!--<span class="badge badge-success">New</span>--></a>
                                </div>

                                <div class="nav-lavel">Affectations collecteurs</div>
                                <div class="nav-item">
                                    <a href="{{ route('orders.index') }}"><i class="ik ik-server"></i><span>Collecteur à commande</span></a>
                                </div>

                                <div class="nav-item">
                                    <a href="{{route('todeliver-orders')}}"><i class="ik ik-server"></i><span>Collecteur à livraison</span></a>
                                </div>

                                <div class="nav-lavel">Reportings</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-monitor"></i><span>Reportings</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('singleCollectbyDay')}}" class="menu-item">Journalier/Collecteur</a>
                                        <a href="{{route('singleCollects')}}" class="menu-item">Du Collecteur/Période</a>
                                        <a href="{{route('allDayCollects')}}" class="menu-item">Journalier Global</a>
                                        <a href="{{route('allCollects')}}" class="menu-item">Global/Période</a>
                                    </div>
                                </div>


                                <div class="nav-lavel">Collecteurs</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-users"></i><span>Collecteurs</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('collectors.index')}}" class="menu-item">Collecteurs</a>
                                        <a href="{{route('collectors.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-lavel">Clients</div>
                                
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-users"></i><span>Clients</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('customers.index')}}" class="menu-item">Clients</a>
                                        <a href="{{route('customers.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <!--<div class="nav-item">
                                    <a href="{{route('customers.index')}}"><i class="ik ik-users"></i><span>Clients</span><span class="badge badge-success">New</span></a>
                                </div>-->

                                <div class="nav-lavel">Messages</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-message-square"></i><span>Messages</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('notifications.index')}}" class="menu-item">Messages</a>
                                        <a href="{{route('notifications.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>


                                <div class="nav-lavel">Configurations</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Etats des colis</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('status.index')}}" class="menu-item">Etats des colis</a>
                                        <a href="{{route('status.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Codes promos</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('codepromos.index')}}" class="menu-item">Codes promos</a>
                                        <a href="{{route('codepromos.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Delais de livraison</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('deliveryhours.index')}}" class="menu-item">Delais de livraison</a>
                                        <a href="{{route('deliveryhours.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Services</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('services.index')}}" class="menu-item">Services</a>
                                        <a href="{{route('services.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Articles</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('articles.index')}}" class="menu-item">Articles</a>
                                        <a href="{{route('articles.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>
                                
                               
                                <div class="nav-lavel">Administration</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-users"></i><span>Utilisateurs</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('users.index')}}" class="menu-item">Utilisateurs</a>
                                        <a href="{{route('users.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>
                                
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-lock"></i><span>Rôles</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('roles.index')}}" class="menu-item">Rôles</a>
                                        <a href="{{route('roles.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-lock"></i><span>Permissions</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('permissions.index')}}" class="menu-item">Permissions</a>
                                        <a href="{{route('permissions.create')}}" class="menu-item">Ajouter</a>
                                    </div>
                                </div>

                                <!--<div class="nav-lavel">Other</div>

                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-list"></i><span>Menu Levels</span></a>
                                    <div class="submenu-content">
                                        <a href="javascript:void(0)" class="menu-item">Menu Level 2.1</a>
                                        <div class="nav-item has-sub">
                                            <a href="javascript:void(0)" class="menu-item">Menu Level 2.2</a>
                                            <div class="submenu-content">
                                                <a href="javascript:void(0)" class="menu-item">Menu Level 3.1</a>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0)" class="menu-item">Menu Level 2.3</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-award"></i><span>Sample Page</span></a>
                                </div>
                                <div class="nav-lavel">Support</div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-monitor"></i><span>Documentation</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-help-circle"></i><span>Submit Issue</span></a>
                                </div>-->
                            </nav>
                        </div>
                    </div>
                </div>
                
                <div class="main-content">
                    <div class="container-fluid">

                        @yield('content')

                    <aside class="right-sidebar">
                    <div class="sidebar-chat" data-plugin="chat-sidebar">
                        <div class="sidebar-chat-info">
                            <h6>Chat List</h6>
                            <form class="mr-t-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search for friends ..."> 
                                    <i class="ik ik-search"></i>
                                </div>
                            </form>
                        </div>
                        <div class="chat-list">
                            <div class="list-group row">
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="chat-panel" hidden>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <a href="javascript:void(0);"><i class="ik ik-message-square text-success"></i></a>  
                            <span class="user-name">John Doe</span> 
                            <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="card-body">
                            <div class="widget-chat-activity flex-1">
                            </div>
                        </div>
                        <form action="javascript:void(0)" class="card-footer" method="post">
                            <div class="d-flex justify-content-end">
                                <textarea class="border-0 flex-1" rows="1" placeholder="Type your message here"></textarea>
                                <button class="btn btn-icon" type="submit"><i class="ik ik-arrow-right text-success"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <footer class="footer noprint">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2020 Dominion v1.0. Tous droits reservés. | </span>
                        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Développé <i class="fa fa-heart text-danger"></i> par <a href="https://sparkcorporation.org/" class="text-dark" target="_blank">SPARK CORPORATION</a></span>
                    </div>
                </footer>
                
            </div>
        </div>
        
        </div>
    </div>
        
        
        

        <div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="quick-search">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 ml-auto mr-auto">
                                    <div class="input-wrap">
                                        <input type="text" id="quick-search" class="form-control" placeholder="Search..." />
                                        <i class="ik ik-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="container">
                            <div class="apps-wrap">
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="app-item dropdown">
                                    <a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-command"></i><span>Ui</span></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-mail"></i><span>Message</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-users"></i><span>Accounts</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-shopping-cart"></i><span>Sales</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-briefcase"></i><span>Purchase</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-server"></i><span>Menus</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-clipboard"></i><span>Pages</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-message-square"></i><span>Chats</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-map-pin"></i><span>Contacts</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-box"></i><span>Blocks</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-calendar"></i><span>Events</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-bell"></i><span>Notifications</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-pie-chart"></i><span>Reports</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-layers"></i><span>Tasks</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-edit"></i><span>Blogs</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-settings"></i><span>Settings</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-more-horizontal"></i><span>More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
        $(document).ready(function(){  

         function timeSince(date) {

              var seconds = Math.floor((new Date() - date) / 1000);

              var interval = Math.floor(seconds / 31536000);

              if (interval > 1) {
                return interval + " années";
              }
              interval = Math.floor(seconds / 2592000);
              if (interval > 1) {
                return interval + " mois";
              }
              interval = Math.floor(seconds / 86400);
              if (interval > 1) {
                return interval + " jours";
              }
              interval = Math.floor(seconds / 3600);
              if (interval > 1) {
                return interval + " heures";
              }
              interval = Math.floor(seconds / 60);
              if (interval > 1) {
                return interval + " minutes";
              }
              return Math.floor(seconds) + " secondes";
            }
                
        
            setInterval(function(){
                $.ajax({
                    url: '{!!URL::route('getNotifs')!!}',
                    type: 'GET',
                    dataType: 'json',

                    success:function(data){

                        $('.notification-list').html('')
                        var liStyle = "";
                        var bodyStyle = "";
                        for(var i in data){
                            if(data[i].status === 0){
                             liStyle = 'style = "background: #eee !important"'
                             bodyStyle = 'style = "font-weight: bold !important"'
                            }else{
                               liStyle = "";
                               bodyStyle = "";
                            }
                            $('.notifications-wrap').append('<a href="'+data[i].route+'" class="media notification-message" data-id='+data[i].id+' '+liStyle+'><span class="d-flex"><img alt="" src="'+data[i].profile_picture+'" class="rounded-circle"></span><span class="media-body"><span class="heading-font-family media-heading">'+ data[i].sender_name +' '+'</span><span class="media-content"' +bodyStyle+ '>' + data[i].body + '</span><span class="chat-time"> Il y a '+timeSince(new Date(data[i].created_at))+ '</span></span></a>');
                            data[i].unread === 0 ? $('.badge-notif').html('') : $('.badge-notif').html(data[i].unread)

                        }

                    }
            })
            }, 5000)

            

             $('.notification-list').delegate('.notification-message','click', function(){
                    $.ajax({
                    url: '{!!URL::route('updateStatus')!!}',
                    type: 'GET',
                    dataType: 'json',
                    data: {_token : "{{ csrf_token() }}", id : $(this).attr('data-id')},
                    success:function(){}
                    })
            })

            })
    </script>
        <script>window.jQuery || document.write('<script src="{{asset('assets/src/js/vendor/jquery-3.3.1.min.js') }}"><\/script>')</script>
        <script src="{{asset('assets/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{asset('assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{asset('assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{asset('assets/plugins/screenfull/dist/screenfull.js') }}"></script>
        <script src="{{asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{asset('assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{asset('assets/plugins/moment/moment.js') }}"></script>
        <script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{asset('assets/plugins/d3/dist/d3.min.js') }}"></script>
        <script src="{{asset('assets/plugins/c3/c3.min.js') }}"></script>
        <script src="{{asset('assets/js/tables.js') }}"></script>
        <script src="{{asset('assets/dist/js/theme.min.js') }}"></script>
        <script src="{{asset('assets/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
        <script src="{{asset('assets/js/rating.js') }}"></script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>

        <script>
        $.extend( true, $.fn.dataTable.defaults, {
            "order" : [[0, "desc"]],
            "language": {
            "search" : "Recherche:",
            "oPaginate":{
              "sFirst":"Premier",
              "sLast":"Dernier",
              "sNext":"Suivant",
              "sPrevious":"Précédent"
            },
            "sInfo" : "Afficher _START_ à _END_ des _TOTAL_ lignes",
            "sInfoEmpty" : "Afficher 0 à 0 des 0 données",
            "sInfoFiltered" : "Trié de _MAX_ lignes totales",
            "sEmptyTable" : "Pas de données disponible dans la table",
            "sLengthMenu" : "Afficher _MENU_ lignes",
            "sZeroRecords" : "Aucune donnée correspondante trouvée"
          }
        });

        $(document).ready(function () {
            $('#data_table').DataTable();
        });
        
    </script>
        @stack('dashboard')
        @stack('verif')
        @stack('create')
        @stack('alldaycollects')
        @stack('periodallcollectors')
        @stack('periodsinglecollector')
        @stack('getcollector')
        @stack('etat')
        @stack('codepromo')
        @stack('kiloprice')
        @stack('collector')
        @stack('customer')
        @stack('article')
        @stack('service')
        @stack('user')
        @stack('role')
        @stack('permission')
    </body>
</html>
