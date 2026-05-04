<?php
// -------------------------------------------------------
// process_contact.php
// Handles the Contact Us form submission.
// Uses a class, array of objects, and a display function
// as required by Part 3 of the project.
// -------------------------------------------------------

require 'db.php';

// ---- Class definition ----
class Contact {
    public $full_name;
    public $email;
    public $subject;
    public $message;

    // Constructor
    public function __construct($full_name, $email, $subject, $message) {
        $this->full_name = $full_name;
        $this->email     = $email;
        $this->subject   = $subject;
        $this->message   = $message;
    }

    // Getter methods
    public function getName()    { return $this->full_name; }
    public function getEmail()   { return $this->email; }
    public function getSubject() { return $this->subject; }
    public function getMessage() { return $this->message; }
}

// ---- Function to display array of Contact objects in a table ----
function displayContacts($contacts) {
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>Full Name</th><th>Email</th><th>Subject</th><th>Message</th></tr>";
    foreach ($contacts as $c) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($c->getName())    . "</td>";
        echo "<td>" . htmlspecialchars($c->getEmail())   . "</td>";
        echo "<td>" . htmlspecialchars($c->getSubject()) . "</td>";
        echo "<td>" . htmlspecialchars($c->getMessage()) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// ---- Process the submitted form ----
$submitted_name    = "";
$submitted_email   = "";
$submitted_subject = "";
$submitted_message = "";
$saved = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_name    = trim($_POST["name"]);
    $submitted_email   = trim($_POST["email"]);
    $submitted_subject = trim($_POST["subject"]);
    $submitted_message = trim($_POST["message"]);

    // Insert into database
    $stmt = mysqli_prepare($conn, "INSERT INTO contacts (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $submitted_name, $submitted_email, $submitted_subject, $submitted_message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $saved = true;
}

// ---- Load all contacts from database into array of objects ----
$contacts = [];
$result = mysqli_query($conn, "SELECT * FROM contacts");
while ($row = mysqli_fetch_assoc($result)) {
    $contacts[] = new Contact($row["full_name"], $row["email"], $row["subject"], $row["message"]);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">

    <?php if ($saved): ?>
        <div class="alert alert-success">
            Your message was sent successfully!
        </div>

        <h4>Your Submitted Information</h4>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Full Name</td><td><?php echo htmlspecialchars($submitted_name); ?></td></tr>
            <tr><td>Email</td><td><?php echo htmlspecialchars($submitted_email); ?></td></tr>
            <tr><td>Subject</td><td><?php echo htmlspecialchars($submitted_subject); ?></td></tr>
            <tr><td>Message</td><td><?php echo htmlspecialchars($submitted_message); ?></td></tr>
        </table>
        <br>
    <?php endif; ?>

    <h4>All Contacts in Database</h4>
    <?php displayContacts($contacts); ?>

    <br>
    <a href="contact.html">Go Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
