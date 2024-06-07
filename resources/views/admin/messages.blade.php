<!--
=========================================================
* * Black Dashboard - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/black-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)


* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    myReno - Admin
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="/template/assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="/template/assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/template/assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            
          </a>
          <a href="/admin/dashboard" class="simple-text logo-normal">
            Admin
          </a>
        </div>
        <ul class="nav">
          <li>
            <a href="dashboard">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="project">
              <i class=>P</i>
              <p>Projects</p>
            </a>
          </li>
          <li>
            <a href="users">
              <i class="tim-icons icon-single-02"></i>
              <p>Users</p>
            </a>
          </li>
          <li>
            <a href="finances">
              <i class="tim-icons icon-pin"></i>
              <p>Finances</p>
            </a>
          </li>
          <li class="active ">
            <a href="{{ url('messenger') }}">
              <i class="tim-icons icon-bell-55"></i>
              <p>Messages</p>
            </a>
          </li>
          <li>
            <a href="collaborations">
              <i class="tim-icons icon-atom"></i>
              <p>Collaborations</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">            
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="/template/assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link">
                      <a href="#" class="nav-item dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log out
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">

      @include('Chatify::layouts.headLinks')

      <div style="margin-left: 50px; margin-right: 50px;">
        <div class="container mx-auto px-4">
            <div class="messenger" data-id="{{ $id }}">
                {{-- Messenger content --}}
                <div class="messenger-listView">
                    {{-- Users/Groups list side --}}
                    <div class="m-header">
                        <nav>
                            <i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span>
                        </nav>
                        <input type="text" class="messenger-search" placeholder="Search" />
                    </div>
                    <div class="m-body contacts-container">
                        <div class="show messenger-tab users-tab app-scroll" data-view="users">
                            <div class="favorites-section">
                                <p class="messenger-title"><span>Favorites</span></p>
                                <div class="messenger-favorites app-scroll-hidden"></div>
                            </div>
                            <p class="messenger-title"><span>Your Space</span></p>
                            {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                            <p class="messenger-title"><span>All Messages</span></p>
                            <div class="listOfContacts" style="width: 100%; height: calc(100% - 272px); position: relative;"></div>
                        </div>
                        <div class="messenger-tab search-tab app-scroll" data-view="search">
                            <p class="messenger-title"><span>Search</span></p>
                            <div class="search-records">
                                <p class="message-hint center-el"><span>Type to search..</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Messaging side --}}
                <div class="messenger-messagingView">
                    <div class="m-header m-header-messaging">
                        <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                            <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px;"></div>
                                <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                            </div>
                            <nav class="m-header-right">
                                <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                                <a href="/dashboard"><i class="fas fa-home"></i></a>
                                <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                            </nav>
                        </nav>
                        <div class="internet-connection">
                            <span class="ic-connected">Connected</span>
                            <span class="ic-connecting">Connecting...</span>
                            <span class="ic-noInternet">No internet access</span>
                        </div>
                    </div>

                    <div class="m-body messages-container app-scroll">
                        <div class="messages">
                            <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                        </div>
                        <div class="typing-indicator">
                            <div class="message-card typing">
                                <div class="message">
                                    <span class="typing-dots">
                                        <span class="dot dot-1"></span>
                                        <span class="dot dot-2"></span>
                                        <span class="dot dot-3"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Chatify::layouts.sendForm')
                </div>

                {{-- Info side --}}
                <div class="messenger-infoView app-scroll">
                    <nav>
                        <p>User Details</p>
                        <a href="#"><i class="fas fa-times"></i></a>
                    </nav>
                    {!! view('Chatify::layouts.info')->render() !!}
                </div>
            </div>
        </div>
    </div>
    @include('Chatify::layouts.modals')
    @include('Chatify::layouts.footerLinks')



        
        
      <footer class="footer">
        <div class="container-fluid">      
          <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-gray-500 dark:text-gray-400">
              &copy; {{ date('Y') }} MyReno. All rights reserved.
          </div>
        </div>
      </footer>
      
    </div>
  </div>
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Background</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="badge-colors text-center">
              <span class="badge filter badge-primary active" data-color="primary"></span>
              <span class="badge filter badge-info" data-color="blue"></span>
              <span class="badge filter badge-success" data-color="green"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="adjustments-line text-center color-change">
          <span class="color-label">LIGHT MODE</span>
          <span class="badge light-badge mr-2"></span>
          <span class="badge dark-badge ml-2"></span>
          <span class="color-label">DARK MODE</span>
        </li>
        
        
        
      </ul>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="/template/assets/js/core/jquery.min.js"></script>
  <script src="/template/assets/js/core/popper.min.js"></script>
  <script src="/template/assets/js/core/bootstrap.min.js"></script>
  <script src="/template/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="/template/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/template/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/template/assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="/template/assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
</body>

</html>