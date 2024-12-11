<?phprequire("connection/connection.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS</title>
</head>
<body>

<h2>Send SMS Message</h2>

<form method="POST" action="includes/action.php">
    <label for="contact_number">Contact Number:</label>
    <input type="text" id="contact_number" name="contact_number" required>
    <br><br>

    <label for="message_text">Message:</label>
    <textarea id="message_text" name="message_text" required></textarea>
    <br><br>

    <button type="submit">Send Message</button>
</form>

</body>
</html>
<div class="card-header">
                            <h6><b><i class="fas fa-list"></i> Animal Information</b></h6>
                            <a href="#" role="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#AddCattleModal">+ New</a>
                        </div>