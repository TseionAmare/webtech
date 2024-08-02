<?php
require_once '../config/connection.php'; // Ensure correct path

// Fetching the greenhouse data
if (isset($_GET['id'])) {
    $greenhouseId = intval($_GET['id']);
    
    // Fetch greenhouse details
    $sql = "SELECT * FROM Greenhouses WHERE greenhouse_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $greenhouseId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $greenhouse = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Fetch associated hydroponic systems
    $sql = "SELECT hs.system_id, hs.system_type, gh.quantity 
            FROM GreenhouseHydroponicSystems gh 
            LEFT JOIN HydroponicSystems hs ON gh.system_id = hs.system_id 
            WHERE gh.greenhouse_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $greenhouseId);
    mysqli_stmt_execute($stmt);
    $systems_result = mysqli_stmt_get_result($stmt);
    $systems = mysqli_fetch_all($systems_result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    // Fetch all hydroponic systems for dropdowns
    $sql = "SELECT * FROM HydroponicSystems";
    $systems_stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_execute($systems_stmt);
    $all_systems_result = mysqli_stmt_get_result($systems_stmt);
    $all_systems = mysqli_fetch_all($all_systems_result, MYSQLI_ASSOC);
    mysqli_stmt_close($systems_stmt);

    mysqli_close($con);
} else {
    echo "No greenhouse ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Greenhouse | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- Additional Font Awesome for more icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.html" class="brand-link">
      <img src="../dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">FARM OPERATIONS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Greenhouses 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_greenhouse.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Greenhouse</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="update_greenhouse.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Greenhouse</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view_greenhouse.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Greenhouse</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-seedling nav-icon"></i>
              <p>
                Crops 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_crop.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Crops</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="update_crop.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crop Tracking</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view_crop.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Crop Status</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="manage_resources.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Resources
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="water_scheduling.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Scheduling
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Greenhouse</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Greenhouse</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Greenhouse Details</h3>
              </div>
              <div class="card-body">
                <form id="updateGreenhouseForm" action="../actions/update_greenhouse_action.php" method="POST">
                  <input type="hidden" id="id" name="id" value="<?php echo $greenhouse['greenhouse_id']; ?>">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $greenhouse['name']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $greenhouse['location']; ?>" required>
                  </div>
                  <h4>Hydroponic System Type</h4>
                  <?php foreach ($systems as $system): ?>
                    <div class="form-group system-group">
                      <label for="system_<?php echo $system['system_id']; ?>">System</label>
                      <select class="form-control" name="systems[]">
                        <?php foreach ($all_systems as $all_system): ?>
                          <option value="<?php echo $all_system['system_id']; ?>" <?php echo $system['system_id'] == $all_system['system_id'] ? 'selected' : ''; ?>>
                            <?php echo $all_system['system_type']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <input type="text" class="form-control" name="quantities[]" placeholder="Quantity" value="<?php echo $system['quantity']; ?>">
                      <button type="button" class="btn btn-danger remove-system">Remove</button>
                    </div>
                  <?php endforeach; ?>
                  <div class="form-group">
                    <button type="button" class="btn btn-success" id="addSystem">Add System</button>
                  </div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmUpdateModal">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- Footer -->
  <!-- Add your footer here -->
  <!-- ... -->

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmUpdateModal" tabindex="-1" role="dialog" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmUpdateModalLabel">Confirm Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to update the greenhouse information?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmUpdateBtn" class="btn btn-primary">Confirm Update</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.modal -->

</div>
<!-- ./wrapper -->

<!-- Scripts -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Add more systems dynamically
    document.getElementById('addSystem').addEventListener('click', function() {
      const systemGroup = document.querySelector('.system-group');
      const newSystemGroup = systemGroup.cloneNode(true);
      newSystemGroup.querySelector('input[name="quantities[]"]').value = '';
      systemGroup.parentNode.insertBefore(newSystemGroup, this.parentNode);
      newSystemGroup.querySelector('.remove-system').addEventListener('click', function() {
        newSystemGroup.remove();
      });
    });

    // Add remove event to existing buttons
    document.querySelectorAll('.remove-system').forEach(button => {
      button.addEventListener('click', function() {
        button.closest('.system-group').remove();
      });
    });

    // Handle update confirmation
    document.getElementById('confirmUpdateBtn').addEventListener('click', function() {
      document.getElementById('updateGreenhouseForm').submit();
    });
  });
</script>
</body>
</html>
