<?php
session_start();

if (isset($_POST['reset'])) {
    session_destroy(); 
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if (!isset($_SESSION['comments'])) {
    $_SESSION['comments'] = [];
}

if (isset($_GET['comment']) && isset($_GET['name'])) {
    $new_comment = [
        "name" => htmlspecialchars($_GET['name']),
        "comment" => $_GET['comment']
    ];
    array_push($_SESSION['comments'], $new_comment);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Comment Section</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        .comment-section {
            margin: 50px auto;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="comment-section">
            <h2 class="mb-4">Leave a Comment</h2>
            <form method="GET">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Your Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <!-- Bouton pour réinitialiser les commentaires -->
            <form method="POST">
                <button type="submit" name="reset" class="btn btn-danger mt-3">Reset Comments</button>
            </form>

            <h3 class="mt-5">Comments</h3>
            <div class="comment">
                <strong>John Doe</strong>
                <p>This is a great article! I really learned a lot from it.</p>
            </div>
            <div class="comment">
                <strong>Jane Smith</strong>
                <p>Thanks for sharing this information! Very helpful.</p>
            </div>
            <div class="comment">
                <strong>Mike Johnson</strong>
                <p>I disagree with some points, but overall a good read.</p>
            </div>
            <?php
            if ($_SESSION['comments']) {
                for ($i = 0; $i < count($_SESSION['comments']); $i++) {
                    echo '<div class="comment">';
                    echo '<strong>' . $_SESSION['comments'][$i]['name'] . '</strong>';
                    echo '<p>' . $_SESSION['comments'][$i]['comment'] . '</p>';
                    echo '</div>';
                }
            }
            
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
