<?php
include('includes/conn.inc.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section = $_POST['section'];
    $content = $_POST['content'];

    // Escape user inputs for security
    $section = mysqli_real_escape_string($con, $section);
    $content = mysqli_real_escape_string($con, $content);

    // Use REPLACE INTO to update or insert content
    $query = "REPLACE INTO landing_page_content (section, content) VALUES ('$section', '$content')";
    if (!mysqli_query($con, $query)) {
        die("Error executing query: " . mysqli_error($con));
    }
}

// Fetch existing content
$sections = ['home', 'services', 'contact', 'about'];
$contents = [];
foreach ($sections as $section) {
    $section = mysqli_real_escape_string($con, $section);
    $query = "SELECT content FROM landing_page_content WHERE section = '$section'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error executing query: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    $contents[$section] = $row['content'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Admin Panel</h1>
        <form method="post">
            <?php foreach ($sections as $section): ?>
                <div class="form-group">
                    <label for="content-<?php echo $section; ?>">Edit <?php echo ucfirst($section); ?> Section:</label>
                    <textarea id="content-<?php echo $section; ?>" name="content" class="form-control" rows="5"><?php echo htmlspecialchars($contents[$section]); ?></textarea>
                    <input type="hidden" name="section" value="<?php echo $section; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            <?php endforeach; ?>
        </form>
    </div>
</body>

</html>