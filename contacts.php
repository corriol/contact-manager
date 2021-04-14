<?php
declare(strict_types=1);

// Including the getProvinces function
include 'inc/functions.php';

// getting provinces
$provinces = getProvinces();

$pdo = create_connection("mysql:host=mysql-server;dbname=contact-manager", "contacts-user_db", "user");

$contactId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$contact = [];

if (!empty($contactId)) {
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE id = :id");
    $stmt->bindValue("id", $contactId);
    $stmt->execute();
    $contact = $stmt->fetch();

    if (!empty($contact)) {
        //Getting values from database row
        $firstname = $contact["firstname"] ?? "";
        $lastname = $contact["lastname"] ?? "";
        $phone = $contact["phone"] ?? "";
        $email = $contact["email"] ?? "";
        $zipCode = $contact["zipcode"] ?? "";
        $city = $contact["city"] ?? "";
        $province = $contact["province"] ?? "";
        $address = $contact["address"] ?? "";

    } else
        die("Contact doesn't exist");
}

?>
<?php include 'partials/header.partial.php' ?>

    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Contact details</h1>
            <!--<div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <a href="#" class="btn btn-sm btn-outline-secondary">New contact</a>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Other option</button>
                </div>
            </div>-->
        </div>


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