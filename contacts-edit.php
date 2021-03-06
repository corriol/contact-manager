<?php
declare(strict_types=1);

// Including the getProvinces function
include 'inc/functions.php';

$pdo = create_connection("mysql:host=mysql-server;dbname=contact-manager", "contacts-user_db", "user");

$contactId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$contact = [];

if (!empty($contactId)) {
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE id = :id");
    $stmt->bindValue("id", $contactId);
    $stmt->execute();
    $contact = $stmt->fetch();
}

// getting provinces
$provinces = getProvinces();


//starting session management
session_start();

//getting the errors array from session variable errors
//using the coalesce operator in case session variable doesn't exist
$errors = $_SESSION["errors"] ?? [];

$email = "";

//Getting values from database row
$firstname = $contact["firstname"] ?? "";
$lastname = $contact["lastname"] ?? "";
$phone = $contact["phone"] ?? "";
$email = $contact["email"] ?? "";
$address = $contact["address"] ?? "";
$city = $contact["city"] ?? "";
$zipCode = $contact["zipcode"] ??"";
$province = $contact["province"]??"";
$photo = $contact["photo"] ?? "";
// once read we must clean session variables
session_unset();
?>
<?php include 'partials/header.partial.php' ?>

<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit contact</h1>
        <!--<div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" class="btn btn-sm btn-outline-secondary">New contact</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Other option</button>
            </div>
        </div>-->
    </div>
    <?php if (!empty($errors)): ?>
    <div class="container">
        <ul class="text-danger">
            <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <form class="row" action="contacts-update.php" method="post"  enctype="multipart/form-data" novalidate>
        <input name="id" type="hidden" value="<?=$contactId?>">
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

        <div class="form-group col-4">
            <label for="photo">Photo:</label>

            <input type="hidden" name="photo"
                   value="<?=$photo ?? "" ?>">

            <input id="photo" type="file" name="photo"
                   class="form-control-file">
            <small><?=$photo ?? "" ?></small>
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

        <div class="form-group col-6">
            <label for="city">City:</label>
            <input class="form-control" id="city" type="text" name="city"
                   value="<?= $city ?? "" ?>" placeholder="City...">
        </div>

        <div class="form-group col-4">
            <label for="zip">Zip Code:</label>

            <input id="zip" type="text" name="zip" value="<?= $zipCode ?? "" ?>"
                   class="form-control" placeholder="Zip code...">
        </div>

        <div class="form-group col-8">
            <label for="province">Province:</label>

            <select id="province" name="province" class="custom-select">
                <?php if (!empty($province)) : ?>
                    <option disabled value="">Choose...</option>
                <?php else: ?>
                    <option selected disabled value="">Choose...</option>
                <?php endif; ?>

                    <?php foreach ($provinces as $key => $name) : ?>
                        <?php if ($key != ($province ?? "")) : ?>
                <option value="<?= $key ?>"><?= $name ?></option>
                <?php else: ?>
                <option selected value="<?= $key ?>"><?= $name ?></option>
                <?php endif; ?>
                    <?php endforeach; ?>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Update
            </button>
            <button type="reset" class="btn btn-danger"><i
                        class="fa fa-trash"></i> Reset
            </button>
        </div>
    </form>
</main>
<?php include 'partials/footer.partial.php' ?>