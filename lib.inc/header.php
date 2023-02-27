<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Sync Hub</title>
    <script src="lib.assets/jquery/jquery.min.js"></script>
    <link href="lib.assets/dist/css/bootstrap.min.css" rel="stylesheet">    
    <!-- Custom styles for this template -->
    <link href="lib.assets/dashboard/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Sync Hub</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="sign-out.php">Keluar</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <?php
            $self = basename($_SERVER['PHP_SELF']);
            ?>

          <li class="nav-item">
            <a class="nav-link<?php echo $self == 'index.php' ? ' active' : '';?>" aria-current="page" href="index.php">
              Depan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $self == 'sync-database.php' ? ' active' : '';?>" href="sync-database.php">
              Database
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $self == 'sync-file.php' ? ' active' : '';?>" href="sync-file.php">
              File
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $self == 'sync-user.php' ? ' active' : '';?>" href="sync-user.php">
              Pengguna
            </a>
          </li>
        </ul>

        
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $pageTitle;?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div>
