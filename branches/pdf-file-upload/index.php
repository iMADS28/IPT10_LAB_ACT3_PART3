<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Laboratory Activity #3B - File Upload (PDF Only)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <style>
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: #202735; }
        .upload-box {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35);
        }
        .file-card {
            background: #f4f5f7;
            border: 1px solid #e2e4e8;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }
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
    <div class="upload-box">
        <h1 class="title has-text-centered">📁 File Upload</h1>
        <h2 class="subtitle has-text-centered">Upload a PDF file</h2>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <div class="file-card">
                <h4 class="title is-5">📄 PDF File</h4>
                <div class="file has-name is-fullwidth is-info">
                    <label class="file-label">
                        <input class="file-input" type="file" name="pdf_file" accept=".pdf" onchange="updateFileName(this)">
                        <span class="file-cta"><span class="file-label">Choose PDF…</span></span>
                        <span class="file-name">No file selected</span>
                    </label>
                </div>
            </div>
            <div class="field" style="margin-top: 20px;">
                <div class="control">
                    <button type="submit" class="button is-link is-fullwidth is-medium">⬆️ Upload</button>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'No file selected';
    input.closest('.file').querySelector('.file-name').textContent = fileName;
}
</script>
</body>
</html>
