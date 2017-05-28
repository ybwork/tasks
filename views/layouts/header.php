<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks</title>

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/public/css/app.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">Home</a>
        <a class="navbar-brand" href="/admin">Admin</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <?php if (!Auth::is_guest()): ?>
          <li><a href="/admin/login">Login</a></li>
        <?php else: ?>
          <li><a href="/admin/logout">Logout</a></li>
        <?php endif; ?>>
      </ul>
    </div>
  </nav>