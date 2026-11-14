<?php
$data = [
    'nama' => '',
    'kelas' => '',
    'jurusan' => '',
];
$errors = [];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($submitted) {
    // Ambil teks dari formulir dan tolak nilai yang kosong.
    foreach ($data as $field => $value) {
        if (isset($_POST[$field]) && is_string($_POST[$field])) {
            $data[$field] = trim($_POST[$field]);
        }

        if ($data[$field] === '') {
            $errors[$field] = 'Bagian ini wajib diisi.';
        }
    }
}

// Amankan teks sebelum ditampilkan sebagai HTML.
function aman($teks)
{
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Identitas Siswa</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #172033;
            background: #f3f6fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 48px 20px;
            background:
                radial-gradient(ellipse at 12% 10%, rgba(80, 135, 255, .12), transparent 34%),
                radial-gradient(ellipse at 90% 85%, rgba(48, 190, 166, .10), transparent 30%),
                #f3f6fb;
        }

        .page {
            width: min(100%, 560px);
            margin: 0 auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 18px 4px;
            color: #36445c;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .04em;
        }

        .brand-mark {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 11px;
            background: #e3edff;
            color: #2861c7;
            font-size: 15px;
            font-weight: 800;
        }

        .card {
            overflow: hidden;
            border: 1px solid #e8edf5;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 22px 60px rgba(34, 55, 90, .10);
        }

        .card-header {
            position: relative;
            overflow: hidden;
            padding: 34px 38px 32px;
            background: linear-gradient(125deg, #173b77, #2869c8 68%, #398bd2);
            color: #fff;
        }

        .card-header::after {
            position: absolute;
            top: -76px;
            right: -40px;
            width: 210px;
            height: 210px;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgba(255, 255, 255, .05), 0 0 0 58px rgba(255, 255, 255, .04);
            content: "";
        }

        .eyebrow {
            position: relative;
            z-index: 1;
            margin: 0 0 10px;
            color: #cfe0ff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .16em;
        }

        h1 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-size: clamp(25px, 5vw, 31px);
            letter-spacing: -.04em;
        }

        .intro {
            position: relative;
            z-index: 1;
            max-width: 390px;
            margin: 10px 0 0;
            color: #e1ebff;
            font-size: 14px;
            line-height: 1.6;
        }

        .card-body {
            padding: 32px 38px 30px;
        }

        .section-title {
            margin: 0 0 23px;
            color: #27344a;
            font-size: 16px;
            font-weight: 700;
        }

        .field {
            margin-bottom: 19px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #33415a;
            font-size: 13px;
            font-weight: 650;
        }

        input {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #dce3ee;
            border-radius: 10px;
            outline: none;
            background: #fbfcfe;
            color: #172033;
            font: inherit;
            font-size: 14px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        input::placeholder {
            color: #9aa6b8;
        }

        input:focus {
            border-color: #4a82dc;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(74, 130, 220, .13);
        }

        input[aria-invalid="true"] {
            border-color: #d84c56;
        }

        .error {
            margin: 7px 0 0;
            color: #bd303b;
            font-size: 12px;
        }

        button {
            display: flex;
            width: 100%;
            min-height: 49px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 25px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(100deg, #2864c5, #347bd5);
            box-shadow: 0 7px 16px rgba(40, 100, 197, .2);
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(40, 100, 197, .27);
        }

        button:focus-visible {
            outline: 3px solid #9dbcf2;
            outline-offset: 3px;
        }

        .privacy-note {
            margin: 17px 0 0;
            color: #8792a4;
            font-size: 12px;
            line-height: 1.5;
            text-align: center;
        }

        .result {
            margin-top: 25px;
            padding: 18px 20px;
            border: 1px solid #bde8d2;
            border-radius: 12px;
            background: #f0fbf5;
        }

        .result h2 {
            margin: 0 0 12px;
            color: #17643b;
            font-size: 15px;
        }

        .result p {
            margin: 7px 0 0;
            color: #315343;
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        @media (max-width: 520px) {
            body {
                padding: 28px 14px;
            }

            .card-header {
                padding: 28px 24px;
            }

            .card-body {
                padding: 27px 24px 25px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <div class="brand">
            <span class="brand-mark" aria-hidden="true">S</span>
            <span>PORTAL SISWA</span>
        </div>

        <section class="card" aria-labelledby="page-title">
            <header class="card-header">
                <p class="eyebrow">DATA DIRI</p>
                <h1 id="page-title">Identitas Siswa</h1>
                <p class="intro">Lengkapi formulir berikut dengan data diri yang benar.</p>
            </header>

            <div class="card-body">
                <h2 class="section-title">Informasi siswa</h2>
                <form method="POST" action="">
                    <div class="field">
                        <label for="nama">Nama lengkap</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Contoh: Andi Pratama"
                            value="<?= aman($data['nama']) ?>"
                            autocomplete="name"
                            aria-invalid="<?= isset($errors['nama']) ? 'true' : 'false' ?>"
                            required
                        >
                        <?php if (isset($errors['nama'])): ?>
                            <p class="error" role="alert"><?= aman($errors['nama']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="kelas">Kelas</label>
                        <input
                            type="text"
                            id="kelas"
                            name="kelas"
                            placeholder="Contoh: XI RPL 1"
                            value="<?= aman($data['kelas']) ?>"
                            aria-invalid="<?= isset($errors['kelas']) ? 'true' : 'false' ?>"
                            required
                        >
                        <?php if (isset($errors['kelas'])): ?>
                            <p class="error" role="alert"><?= aman($errors['kelas']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="field">
                        <label for="jurusan">Jurusan</label>
                        <input
                            type="text"
                            id="jurusan"
                            name="jurusan"
                            placeholder="Contoh: Rekayasa Perangkat Lunak"
                            value="<?= aman($data['jurusan']) ?>"
                            aria-invalid="<?= isset($errors['jurusan']) ? 'true' : 'false' ?>"
                            required
                        >
                        <?php if (isset($errors['jurusan'])): ?>
                            <p class="error" role="alert"><?= aman($errors['jurusan']) ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit">Kirim data <span aria-hidden="true">&rarr;</span></button>
                </form>

                <?php if ($submitted && empty($errors)): ?>
                    <section class="result" aria-live="polite">
                        <h2>Data berhasil dikirim</h2>
                        <p><strong>Nama:</strong> <?= aman($data['nama']) ?></p>
                        <p><strong>Kelas:</strong> <?= aman($data['kelas']) ?></p>
                        <p><strong>Jurusan:</strong> <?= aman($data['jurusan']) ?></p>
                    </section>
                <?php endif; ?>

                <p class="privacy-note">Pastikan data yang kamu masukkan sudah sesuai sebelum dikirim.</p>
            </div>
        </section>
    </main>
</body>
</html>
