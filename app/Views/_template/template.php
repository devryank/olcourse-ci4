<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
  <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
  <!-- Twitter meta-->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:site" content="@pratikborsadiya">
  <meta property="twitter:creator" content="@pratikborsadiya">
  <!-- Open Graph Meta-->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Vali Admin">
  <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
  <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
  <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
  <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
  <title><?= $title; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="title" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendor/ckeditor/style.css">
  <script src="<?= base_url(); ?>/assets/vendor/ckeditor/ckeditor.js"></script>
</head>

<body class="app sidebar-mini">
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="index.html">Vali</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp; <?= session()->get('full_name'); ?></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?= site_url('auth/logout'); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
      <div>
        <p class="app-sidebar__user-name"><?= session()->get('full_name'); ?></p>
        <p class="app-sidebar__user-designation"><?= session()->get('level'); ?></p>
      </div>
    </div>
    <ul class="app-menu">
      <li><a class="app-menu__item <?php if ($segment[0] == 'admin') {
                                      if (isset($segment[1])) {
                                        if ($segment[1] == 'dashboard') {
                                          echo 'active';
                                        }
                                      } else {
                                        echo 'active';
                                      }
                                    } ?>" href="<?= site_url('admin/'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
      <li class="treeview <?php if ($segment[0] == 'admin') {
                            if (isset($segment[1])) {
                              if ($segment[1] == 'paket' || $segment[1] == 'kelas' || $segment[1] == 'topik' || $segment[1] == 'user') {
                                echo 'is-expanded';
                              } else {
                                echo '';
                              }
                            }
                          } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Master</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item <?php if ($segment[0] == 'admin') {
                                        if (isset($segment[1])) {
                                          if ($segment[1] == 'paket') {
                                            echo 'active';
                                          }
                                        } else {
                                          echo '';
                                        }
                                      }
                                      ?>" href="<?= site_url('admin/paket'); ?>"><i class="icon fa fa-circle-o"></i> Paket</a></li>
          <li><a class="treeview-item <?php if ($segment[0] == 'admin') {
                                        if (isset($segment[1])) {
                                          if ($segment[1] == 'kelas') {
                                            echo 'active';
                                          }
                                        } else {
                                          echo '';
                                        }
                                      }
                                      ?>" href="<?= site_url('admin/kelas'); ?>"><i class="icon fa fa-circle-o"></i> Kelas</a></li>
          <li><a class="treeview-item <?php if ($segment[0] == 'admin') {
                                        if (isset($segment[1])) {
                                          if ($segment[1] == 'topik') {
                                            echo 'active';
                                          }
                                        } else {
                                          echo '';
                                        }
                                      }
                                      ?>" href="<?= site_url('admin/topik'); ?>"><i class="icon fa fa-circle-o"></i> Topik</a></li>
          <li><a class="treeview-item <?php if ($segment[0] == 'admin') {
                                        if (isset($segment[1])) {
                                          if ($segment[1] == 'user') {
                                            echo 'active';
                                          }
                                        } else {
                                          echo '';
                                        }
                                      }
                                      ?>" href="<?= site_url('admin/user'); ?>"><i class="icon fa fa-circle-o"></i> User</a></li>
          <li><a class="treeview-item <?php if ($segment[0] == 'admin') {
                                        if (isset($segment[1])) {
                                          if ($segment[1] == 'diskon') {
                                            echo 'active';
                                          }
                                        } else {
                                          echo '';
                                        }
                                      }
                                      ?>" href="<?= site_url('admin/diskon'); ?>"><i class="icon fa fa-circle-o"></i> Diskon</a></li>
        </ul>
      </li>
      <li><a class="app-menu__item <?php if ($segment[0] == 'admin') {
                                      if (isset($segment[1])) {
                                        if ($segment[1] == 'paket' || $segment[1] == 'kelas' || $segment[1] == 'topik' || $segment[1] == 'user') {
                                          echo 'is-expanded';
                                        } else {
                                          echo '';
                                        }
                                      }
                                    } ?>" href="<?= site_url('admin/transaksi'); ?>"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Transaksi</span></a>
      </li>
    </ul>
  </aside>

  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><?= $title; ?></h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <?php foreach ($segment as $key => $value) : ?>
          <li class="breadcrumb-item"><?= $value; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?= $this->renderSection('main'); ?>
    <!-- Essential javascripts for application to work-->
    <script src="<?= base_url(); ?>/assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= base_url(); ?>/assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/plugins/chart.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/plugins/select2.min.js"></script>
    <script type="text/javascript">
      $('#sampleTable').DataTable();
      $('#demoSelect').select2();
    </script>
    <script type="text/javascript">
      var data = {
        labels: <?php if (!empty($labelMonth)) {
                  echo $labelMonth;
                } ?>,
        datasets: [{
          label: "My First dataset",
          fillColor: "rgba(151,187,205,0.2)",
          strokeColor: "rgba(151,187,205,1)",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(151,187,205,1)",
          data: <?php if (!empty($labelTransaction)) {
                  echo $labelTransaction;
                } ?>
        }]
      };
      var pdata = [{
          value: <?php if (!empty($transaction_package_this_month)) {
                    echo $transaction_package_this_month->total;
                  } ?>,
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: "Paket"
        },
        {
          value: <?php if (!empty($transaction_class_this_month)) {
                    echo $transaction_class_this_month->total;
                  } ?>,
          color: "#F7464A",
          highlight: "#FF5A5E",
          label: "Kelas"
        }
      ]

      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);

      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if (document.location.hostname == 'pratikborsadiya.in') {
        (function(i, s, o, g, r, a, m) {
          i['GoogleAnalyticsObject'] = r;
          i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
          }, i[r].l = 1 * new Date();
          a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
          a.async = 1;
          a.src = g;
          m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
      }
    </script>
    <script>
      $(function() {
        CKEDITOR.replace('editor', {
          filebrowserImageBrowseUrl: '<?php echo base_url('assets/vendor/kcfinder/browse.php'); ?>',
          height: '400px'
        });
      });
    </script>

    <script>
      $('#file').change(myUploadOnChangeFunction);

      function createObjectURL(object) {
        return (window.URL) ? window.URL.createObjectURL(object) : window.webkitURL.createObjectURL(object);
      }

      function revokeObjectURL(url) {
        return (window.URL) ? window.URL.revokeObjectURL(url) : window.webkitURL.revokeObjectURL(url);
      }

      function myUploadOnChangeFunction() {
        if (this.files.length) {
          for (var i in this.files) {
            if (this.files.hasOwnProperty(i)) {
              console.log(i);
              var src = createObjectURL(this.files[i]);
              var image = new Image();
              image.src = src;
              $('#img').attr('src', src);
            }
            // Do whatever you want with your image, it's just like any other image
            // but it displays directly from the user machine, not the server!
          }
        }
      }
    </script>
</body>

</html>