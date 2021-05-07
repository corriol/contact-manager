<?php
declare(strict_types=1);
define ("ANSWER_YES", "YES");
define ("ANSWER_NO", "NO");

// Checking request method
$isPost = $_SERVER["REQUEST_METHOD"] === "POST";

// Including the getProvinces function
include 'inc/functions.php';
$pdo = create_connection("mysql:host=mysql-server;dbname=contact-manager", "contacts-user_db", "user");

if ($isPost === false) {
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
        } else
            die ("Contact error");
    }
} else {
    // enabling session management to send messages after redirection
    session_start();
    // as the request method is POST we get the user answer
    $userAnswer = filter_input(INPUT_POST, "user_answer");
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    if ($userAnswer === ANSWER_YES) {
        $stmt = $pdo->prepare("DELETE FROM contact WHERE id = :id");
        $stmt->bindValue("id", $id);
        $stmt->execute();
        $_SESSION["message"] = "The contact has been deleted successfully!";
    }
    else
        $_SESSION["message"] = "Delete process has been cancelled!";

    header("Location: index.php");
    exit();
}




?>
<?php include 'partials/header.partial.php' ?>

<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Delete contact</h1>
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
    <?php if (!$isPost) :?>
    <form class="row" action="contacts-delete.php" method="post" novalidate>
        <input name="id" type="hidden" value="<?=$contactId?>">

        <div>

            <table class="table">
                <tr>
                    <th scope="row">First name</th>
                    <td><?= $firstname  ?></td>
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
            </table>

            <p>This contact will be deleted. Are you sure?</p>

            <button type="submit" name="user_answer" class="btn btn-danger" value="<?=ANSWER_YES?>"><i class="fa fa-trash"></i> Yes
            </button>
            <button type="submit" name="user_answer" class="btn btn-primary" value="<?=ANSWER_NO?>"><i
                        class="fa fa-eject"></i> No
            </button>
        </div>
        <?php endif ?>
    </form>
</main>
<?php include 'partials/footer.partial.php' ?>