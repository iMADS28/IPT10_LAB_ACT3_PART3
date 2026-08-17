<?php
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
$uploaded_files = [];
$errors = [];

if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image_file'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        $filename = 'image_' . time() . '_' . basename($file['name']);
        $target = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $uploaded_files['image'] = ['name' => $file['name'], 'path' => $target];
        }
    } else { $errors[] = 'File must be a valid image format'; }
}
$has_uploads = !empty($uploaded_files);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <style>
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: #202735; }
        .result-box { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 10px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.35); }
        .media-card { background: #f4f5f7; border: 1px solid #e2e4e8; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        img.uploaded-img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .button.is-link {
            background-color: #0b1730 !important;
            border-color: #0b1730 !important;
        }
        .button.is-link:hover {
            background-color: #0e1f3d !important;
            border-color: #0e1f3d !important;
        }
        .file-cta {
            background-color: #0b1730 !important;
            border-color: #0b1730 !important;
            color: #ffffff !important;
        }
    </style>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<section class="section">
    <div class="result-box">
        <h1 class="title has-text-centered">📂 Uploaded Files</h1>
        <?php if (!empty($errors)): ?>
            <div class="notification is-danger"><ul><?php foreach ($errors as $e): ?><li><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <?php if (!$has_uploads && empty($errors)): ?>
            <div class="notification is-warning has-text-centered">No files were uploaded. <a href="index.php">Go back</a>.</div>
        <?php endif; ?>
        <?php if (isset($uploaded_files['image'])): ?>
        <div class="media-card">
            <h4 class="title is-5">🖼️ Image: <?php echo htmlspecialchars($uploaded_files['image']['name']); ?></h4>
            <img class="uploaded-img" src="<?php echo htmlspecialchars($uploaded_files['image']['path']); ?>" alt="Uploaded Image" />
        </div>
        <?php endif; ?>
        <div class="has-text-centered" style="margin-top: 30px;"><a href="index.php" class="button is-link is-medium">⬆️ Upload More</a></div>
    </div>
</section>
</body>
</html>
