<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/global.css" rel="stylesheet">
    <title>Contact manager</title>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>

</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/index.php">Contact Manager</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="w-100" action="contacts-search.php">
        <input class="form-control form-control-dark" type="text" name="text" placeholder="Search" aria-label="Search"
        value="<?=$text ?? "" ?>">
    </form>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href=""></a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="">
                            Option 1 <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            Option 2
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            Option 2
                        </a>
                    </li>

                </ul>

            </div>
        </nav>
