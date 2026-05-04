<?php
// -------------------------------------------------------
// process_questionnaire.php
// Handles the Questionnaire / Customer Feedback form.
// -------------------------------------------------------

$name     = "";
$email    = "";
$rating   = "";
$features = [];
$comments = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $rating   = isset($_POST["rate"])     ? $_POST["rate"]     : "Not selected";
    $features = isset($_POST["features"]) ? $_POST["features"] : [];
    $comments = trim($_POST["comments"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Questionnaire Submitted</h2>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>Thank you for your feedback!</p>

        <table border="1" cellpadding="6" cellspacing="0">
            <tr><th>Field</th><th>Value</th></tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <td>Rating</td>
                <td><?php echo htmlspecialchars($rating); ?></td>
            </tr>
            <tr>
                <td>Features Liked</td>
                <td>
                    <?php
                    if (count($features) > 0) {
                        echo htmlspecialchars(implode(", ", $features));
                    } else {
                        echo "None selected";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Comments</td>
                <td><?php echo htmlspecialchars($comments); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No data submitted.</p>
    <?php endif; ?>

    <br>
    <a href="questionnaire.html">Go Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
