<?php
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
$uploaded_files = [];
$errors = [];

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
        audio { width: 100%; }
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
        <?php if (isset($uploaded_files['audio'])): ?>
        <div class="media-card">
            <h4 class="title is-5">🎵 Audio: <?php echo htmlspecialchars($uploaded_files['audio']['name']); ?></h4>
            <audio controls>
                <source src="<?php echo htmlspecialchars($uploaded_files['audio']['path']); ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <?php endif; ?>
        <div class="has-text-centered" style="margin-top: 30px;"><a href="index.php" class="button is-link is-medium">⬆️ Upload More</a></div>
    </div>
</section>
</body>
</html>
