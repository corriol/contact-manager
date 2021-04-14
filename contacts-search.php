<?php
include "inc/functions.php";
$pdo = create_connection("mysql:host=mysql-server;dbname=contact-manager", "contacts-user_db", "user");

$text = filter_input(INPUT_GET, "text", FILTER_SANITIZE_SPECIAL_CHARS);

$contacts = [];
if (!empty($text)) {
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE firstname LIKE :text OR lastname LIKE :text ");
    $stmt->bindValue("text", "%$text%");
    $stmt->execute();
    $contacts = $stmt->fetchAll();
}

?>

<?php include 'partials/header.partial.php' ?>
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Contacts search</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <a href="contacts-create.php" class="btn btn-sm btn-outline-secondary">New contact</a>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Other option</button>
                </div>
            </div>
        </div>
        <div>
            <?php if (empty($contacts)): ?>
                <h3>No contacts found!</h3>
            <?php else :?>
            <table class="table">
                <thead class="thead-dark">
                    <tr><th>Name</th><th>Last name</th><th>Phone number</th><th>Email address</th><th>Actions</th></tr>
                </thead>
                <?php foreach ($contacts as $contact):?>
                    <tr>
                        <td><?=$contact["firstname"]?></td>
                        <td><?=$contact["lastname"]?></td>
                        <td><?=$contact["phone"]?></td>
                        <td><?=$contact["email"]?></td>
                        <td><a href="contacts.php?id=<?=$contact["id"]?>">Show</a>
                            <a href="contacts-edit.php?id=<?=$contact["id"]?>">Edit</a>
                            <a href="contacts-delete.php?id=<?=$contact["id"]?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>
        </div>
    </main>
<?php include 'partials/footer.partial.php' ?>