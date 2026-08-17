<?php

$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$uploaded_files = [];
$errors = [];

if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['pdf_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext === 'pdf') {
        $filename = 'pdf_' . time() . '_' . basename($file['name']);
        $target = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $uploaded_files['pdf'] = ['name' => $file['name'], 'path' => $target];
        }
    } else { $errors[] = 'PDF file must have .pdf extension'; }
}

if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['audio_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext === 'mp3') {
        $filename = 'audio_' . time() . '_' . basename($file['name']);
        $target = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $uploaded_files['audio'] = ['name' => $file['name'], 'path' => $target];
        }
    } else { $errors[] = 'Audio file must have .mp3 extension'; }
}

if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image_file'];
    $allowed_image = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_image)) {
        $filename = 'image_' . time() . '_' . basename($file['name']);
        $target = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $uploaded_files['image'] = ['name' => $file['name'], 'path' => $target];
        }
    } else { $errors[] = 'Image file must be a valid image format'; }
}

if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['video_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext === 'mp4') {
        $filename = 'video_' . time() . '_' . basename($file['name']);
        $target = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $uploaded_files['video'] = ['name' => $file['name'], 'path' => $target];
        }
    } else { $errors[] = 'Video file must have .mp4 extension'; }
}

$has_uploads = !empty($uploaded_files);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Laboratory Activity #3B - Uploaded Files</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0b1730; --white: #fff; --gray: #202735; --muted: #aeb7c6; }
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: var(--gray); }
        .result-box {
            max-width: 900px;
            margin: 40px auto;
            background: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.35);
        }
        .title { color: var(--gray) !important; }
        .media-card {
            background: #f4f5f7;
            border: 1px solid #e2e4e8;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .media-card h4 { margin-bottom: 15px; }
        embed, iframe { width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 4px; }
        audio { width: 100%; }
        img.uploaded-img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        video { width: 100%; max-height: 500px; border-radius: 8px; }
        .button.is-link {
            background-color: var(--navy) !important;
            border-color: var(--navy) !important;
            color: var(--white) !important;
        }
        .button.is-link:hover {
            background-color: #0e1f3d !important;
            border-color: #0e1f3d !important;
        }
    </style>
</head>
<body>

<section class="section">
    <div class="result-box">
        <h1 class="title has-text-centered">Uploaded Files</h1>

        <?php if (!empty($errors)): ?>
            <div class="notification is-danger">
                <ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <?php if (!$has_uploads && empty($errors)): ?>
            <div class="notification is-warning has-text-centered">
                No files were uploaded. <a href="index.php">Go back and upload files</a>.
            </div>
        <?php endif; ?>

        <?php if (isset($uploaded_files['pdf'])): ?>
        <div class="media-card">
            <h4 class="title is-5">PDF: <?php echo htmlspecialchars($uploaded_files['pdf']['name']); ?></h4>
            <embed src="<?php echo htmlspecialchars($uploaded_files['pdf']['path']); ?>" type="application/pdf" />
        </div>
        <?php endif; ?>

        <?php if (isset($uploaded_files['audio'])): ?>
        <div class="media-card">
            <h4 class="title is-5">Audio: <?php echo htmlspecialchars($uploaded_files['audio']['name']); ?></h4>
            <audio controls>
                <source src="<?php echo htmlspecialchars($uploaded_files['audio']['path']); ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <?php endif; ?>

        <?php if (isset($uploaded_files['image'])): ?>
        <div class="media-card">
            <h4 class="title is-5">Image: <?php echo htmlspecialchars($uploaded_files['image']['name']); ?></h4>
            <img class="uploaded-img" src="<?php echo htmlspecialchars($uploaded_files['image']['path']); ?>" alt="Uploaded Image" />
        </div>
        <?php endif; ?>

        <?php if (isset($uploaded_files['video'])): ?>
        <div class="media-card">
            <h4 class="title is-5">Video: <?php echo htmlspecialchars($uploaded_files['video']['name']); ?></h4>
            <video controls>
                <source src="<?php echo htmlspecialchars($uploaded_files['video']['path']); ?>" type="video/mp4">
                Your browser does not support the video element.
            </video>
        </div>
        <?php endif; ?>

        <div class="has-text-centered" style="margin-top: 30px;">
            <a href="index.php" class="button is-link is-medium">Upload More Files</a>
        </div>
    </div>
</section>

</body>
</html>
