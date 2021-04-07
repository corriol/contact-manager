<?php
declare(strict_types=1);

// Including the getProvinces function
include 'inc/functions.php';

// getting provinces
$provinces = getProvinces();

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
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $phoneExpReg]]);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $zipCode = filter_input(INPUT_POST, "zip", FILTER_SANITIZE_STRING);
    $province = filter_input(INPUT_POST, "province");

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

    if (empty($province)) {
        $errors[] = "You must select a province";
    }

    // if there are errors we redirect to form page
    if (!empty($errors)) {
        // starting session management
        session_start();
        // saving errors in a session variable
        $_SESSION["errors"] = $errors;

        // saving valid data from form
        // other approach is to handle all valid data in an associative array
        $_SESSION["firstname"] = $firstname;
        $_SESSION["lastname"] = $lastname;
        $_SESSION["phone"] = $phone;
        $_SESSION["email"] = $email;
        $_SESSION["address"] = $address;
        $_SESSION["city"] = $city;
        $_SESSION["zipcode"] = $zipCode;
        $_SESSION["province"] = $province;

        header("Location: contact-create.php");
        exit();
    } else {
        // inserting
        $pdo = create_connection("mysql:host=mysql-server;dbname=contact-manager", "contacts-user_db",
            "user");

        $sql = "INSERT INTO `contact`(`firstname`, `lastname`, `phone`, `email`, `city`, `address`, `zipcode`,
                      `province`) VALUES (:firstname, :lastname,:phone,:email,:city,:address, :zipcode, :province)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("firstname", $firstname);
        $stmt->bindValue("lastname", $lastname);
        $stmt->bindValue("phone", $phone);
        $stmt->bindValue("email", $email);
        $stmt->bindValue("city", $city);
        $stmt->bindValue("address", $address);
        $stmt->bindValue("zipcode",  $zipCode);
        $stmt->bindValue("province",  $province);

        $stmt->execute();


    }


} else
    die('GET method not allowed');
?>
<?php include 'partials/header.partial.php' ?>

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


        <div class="container">
            <h2>Contact successfully created</h2>
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

                        <tr>
                            <th scope="row">Province</th>
                            <td><?= $provinces[$province] ?></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <p><a href="index.php">go home</a></p>
    </main>
<?php include 'partials/footer.partial.php' ?>