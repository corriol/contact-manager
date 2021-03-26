<?php
declare(strict_types=1);
$errors = [];
$isPost = false;

$email = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isPost = true;

    //Regular expressions
    $phoneExpReg = "/^\d{9}$/";
    $zipCodeExpReg = "/^\d{5}$/";

    //Getting values from $_POST with filter_input
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $phoneExpReg]]);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $zipCode = filter_input(INPUT_POST, "zip", FILTER_SANITIZE_STRING);

    if (empty($firstname)) {
        $errors["firstname"] = "First name is mandatory";

    } elseif (strlen($firstname) > 25) {
        $errors["firstname"] = "First name should be lower than 25 characters";
    }

    if (empty($lastname)) {
        $errors[] = "Last name is mandatory";
    }

    if (empty($phone)) {
        $errors[] = "You must insert a number phone or phone doesn't match pattern";
    }

    if (empty($email)) {
        $errors[] = "Email is mandatory";
    }

    if (!empty($zipCode)) {
        if (!preg_match($zipCodeExpReg, $zipCode)) {
            $errors[] = "ZipCode doesn't match pattern";
        }
    }
}
?>
<!DOCTYPE html>
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
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Contact Manager</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
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
                        <a class="nav-link active" href="index.php">
                            Contacts <span class="sr-only">(current)</span>
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

        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">New contact</h1>
                <!--<div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary">New contact</a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Other option</button>
                    </div>
                </div>-->
            </div>
            <?php if ($isPost && !empty($errors)): ?>
                <div class="container">
                    <ul class="text-danger">
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form class="row" action="contact-create.php" method="post" novalidate>
                <div class="col-6 form-group">
                    <label for="firstname">First name:</label>
                    <input id="firstname" type="text" name="firstname" value="<?= $firstname ?? "" ?>"
                           class="form-control" placeholder="First name..." required>
                    <?php if (!empty($errors["firstname"])) : ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors["firstname"] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group col-6">
                    <label for="lastname">Last name:</label>
                    <input id="lastname" type="text" name="lastname" value="<?= $lastname ?? "" ?>"
                           class="form-control" placeholder="Last name..." required>
                </div>

                <div class="form-group col-6">
                    <label for="phone">Phone:</label>
                    <input id="phone" type="text" name="phone" value="<?= $phone ?? "" ?>"
                           class="form-control" placeholder="Phone number..." required>
                </div>

                <div class="form-group col-6">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" value="<?= $email; ?>"
                           class="form-control" placeholder="Email..." required>
                </div>

                <div class="form-group col-6">
                    <label for="address">Address:</label>
                    <input id="address" type="text" name="address" value="<?= $address ?? "" ?>"
                           class="form-control" placeholder="Adress...">
                </div>

                <div class="form-group col-4">
                    <label for="city">City:</label>
                    <input class="form-control" id="city" type="text" name="city"
                           value="<?= $city ?? "" ?>" placeholder="City...">
                </div>

                <div class="form-group col-2">
                    <label for="zip">Zip Code:</label>

                    <input id="zip" type="text" name="zip" value="<?= $zipCode ?? "" ?>"
                           class="form-control" placeholder="Zip code...">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-danger"><i
                                class="fa fa-trash"></i> Reset
                    </button>
                </div>

            </form>

            <?php if ($isPost && (empty($errors))) : ?>
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-7 col-xl-7 card flex-row mx-auto px-0 mt-5 border">
                            <table class="table">
                                <tr>
                                    <th scope="row">First name</th>
                                    <td><?= $firstname ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Last name</th>
                                    <td><?= $lastname ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone</th>
                                    <td><?= $phone ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?= $email ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Address</th>
                                    <td><?= $address ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">City</th>
                                    <td><?= $city ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Zip code</th>
                                    <td><?= $zipCode ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
</body>
</html>
