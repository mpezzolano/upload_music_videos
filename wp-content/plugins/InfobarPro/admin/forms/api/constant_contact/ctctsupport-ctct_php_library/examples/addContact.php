<h2>Add Contact Form Example</h2>
<?php
session_start();
include_once('../ConstantContact.php');
$username = 'jaya.rai007@gmail.com';
$apiKey = '515faf7a-6f1a-4421-bf6f-17d32db7c33b';
$consumerSecret = '73dd5315145d48878d8abdc5d987fbc3';
$Datastore = new CTCTDataStore();
$DatastoreUser = $Datastore->lookupUser($username);

if($DatastoreUser){
    $ConstantContact = new ConstantContact('oauth', $apiKey, $DatastoreUser['username'], $consumerSecret);
    $ContactLists = $ConstantContact->getLists();
?>
<form name="addContact" action="" method="post">
    Email Address: <input type="text" name="email_address"><br />
    First Name: <input type="text" name="first_name"><br />
    Last Name: <input type="text" name="last_name"><br />
    <h4>Contact Lists</h4>
    <div style="border: 1px #000 solid; overflow: auto; width: 400px; height: 400px;">
    <?php
    foreach($ContactLists['lists'] as $list){
        echo '<input type="checkbox" name="lists[]" value="'.$list->id.'"> '.$list->name.'<br />';
    }
    ?>
    </div>
    <input type="submit" name="submit" value="Add Contact"><br />
</form>

<?php
    if(isset($_POST['email_address'])){
        $Contact = new Contact();
        $Contact->emailAddress = $_POST['email_address'];
        $Contact->firstName = $_POST['first_name'];
        $Contact->lastName = $_POST['last_name'];
        $Contact->lists = $_POST['lists'];

        $NewContact = $ConstantContact->addContact($Contact);
            }
} else {echo ' Click <a href="example_verification.php?apiKey='.$apiKey.'&secret='.$consumerSecret.'&return='.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'">here</a> to authorize';}
?>
