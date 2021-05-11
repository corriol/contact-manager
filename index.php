<?php

require "src/bootstrap.php";

use App\Database;
use App\Model\ContactModel;

session_start();

$contactModel = new ContactModel(Database::getConnection());
$contacts = $contactModel->findAll();
?>
<?php include 'partials/header.partial.php' ?>
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Contacts</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <a href="contacts-create.php" class="btn btn-sm btn-outline-secondary">New contact</a>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Other option</button>
                </div>
            </div>
        </div>
        <div>
            <!--TODO: Implement Bootstrap alert format -->
            <?php
                echo $_SESSION["message"]?? "";
                session_unset()
            ?>

            <table class="table">
                <tr><th>Name</th><th>Last name</th><th>Phone number</th><th>Email address</th><th>Actions</th></tr>
                <?php foreach ($contacts as $contact):?>
                    <tr>
                        <td><?=$contact->getFirstname()?></td>
                        <td><?=$contact->getLastname() ?></td>
                        <td><?=$contact->getPhone();?></td>
                        <td><?=$contact->getEmail();?></td>
                        <td><a href="contacts.php?id=<?=$contact->getId()?>">Show</a>
                            <a href="contacts-edit.php?id=<?=$contact->getId()?>">Edit</a>
                            <a href="contacts-delete.php?id=<?=$contact->getId()?>">Delete</a>
                            </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
<?php include 'partials/footer.partial.php' ?>