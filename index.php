<?php
include_once("koneksi.php");
?>
<?php
if (isset($_POST['simpan'])) {
    $isi = $_POST['isi'];
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];

    if (strtotime($tgl_akhir) < strtotime($tgl_awal)) {
        echo "<script>alert('Tanggal Akhir tidak boleh lebih awal dari Tanggal Awal');</script>";
    } else {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE kegiatan SET 
                                            isi = '" . $_POST['isi'] . "',
                                            tgl_awal = '" . $_POST['tgl_awal'] . "',
                                            tgl_akhir = '" . $_POST['tgl_akhir'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
        } else {
            $tambah = mysqli_query($mysqli, "INSERT INTO kegiatan(isi,tgl_awal,tgl_akhir,status) 
                                            VALUES ( 
                                                '" . $_POST['isi'] . "',
                                                '" . $_POST['tgl_awal'] . "',
                                                '" . $_POST['tgl_akhir'] . "',
                                                '0'
                                                )");
        }
        echo "<script> 
                document.location='index.php';
                </script>";
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM kegiatan WHERE id = '" . $_GET['id'] . "'");
    } else if ($_GET['aksi'] == 'ubah_status') {
        $ubah_status = mysqli_query($mysqli, "UPDATE kegiatan SET 
                                        status = '" . $_GET['status'] . "' 
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
    }
    echo "<script> 
            document.location='index.php';
            </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap-icons.css">

    <title>To Do List</title>

    <style>
        body {
            background-image: url('img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 1s ease-in-out;
        }

        .header {
            text-align: center;
            margin-bottom: 70px;
            color: #fff;
        }

        .form-container {
            width: 400px;
            background: linear-gradient(#212121, #212121) padding-box,
                        linear-gradient(145deg, transparent 35%,#e81cff, #40c9ff) border-box;
            border: 2px solid transparent;
            padding: 32px 24px;
            font-size: 14px;
            font-family: inherit;
            color: white;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            border-radius: 16px;
            background-size: 200% 100%;
            animation: gradient 5s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .form-container button:active {
            scale: 0.95;
        }

        .form-container .form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container .form-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .form-container .form-group label {
            display: block;
            margin-bottom: 5px;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }

        .form-container .form-group input,
        .form-container .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            color: #fff;
            font-family: inherit;
            background-color: transparent;
            border: 1px solid #414141;
        }

        .form-container .form-group input::placeholder {
            opacity: 0.5;
        }

        .form-container .form-group input:focus,
        .form-container .form-group textarea:focus {
            outline: none;
            border-color: #e81cff;
        }

        .form-container .form-submit-btn {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            align-self: flex-start;
            font-family: inherit;
            color: #717171;
            font-weight: 600;
            width: 40%;
            background: #313131;
            border: 1px solid #414141;
            padding: 12px 16px;
            font-size: inherit;
            gap: 8px;
            margin-top: 8px;
            cursor: pointer;
            border-radius: 6px;
        }

        .form-container .form-submit-btn:hover {
            background-color: #fff;
            border-color: #fff;
        }

        .table-container {
            margin-top: 20px;
        }

        .table th,
        .table td {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>To Do List</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <form class="form" method="POST" action="" name="myform">
                        <?php
                        $isi = '';
                        $tgl_awal = '';
                        $tgl_akhir = '';
                        if(isset($_GET['id'])) {
                            $ambil = mysqli_query($mysqli, "SELECT * FROM kegiatan WHERE id='".$_GET['id']."'");
                            while ($row = mysqli_fetch_array($ambil)) {
                                $isi = $row['isi'];
                                $tgl_awal = $row['tgl_awal'];
                                $tgl_akhir = $row['tgl_akhir'];
                            }
                            ?>
                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                        }
                        ?>
                        <!-- Form Input -->
                        <h2>Form Input</h2>
                        <div class="form-group">
                            <label for="isi">Kegiatan</label>
                            <input required="" name="isi" id="isi" type="text" value="<?php echo $isi ?>">
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input required="" name="tgl_awal" id="tgl_awal" type="date" value="<?php echo $tgl_awal ?>">
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input required="" name="tgl_akhir" id="tgl_akhir" type="date" value="<?php echo $tgl_akhir ?>">
                        </div>
                        <button type="submit" class="form-submit-btn" name="simpan">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 table-container">
                <!-- Table -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Awal</th>
                            <th scope="col">Akhir</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query(
                            $mysqli,"SELECT * FROM kegiatan ORDER BY status,tgl_awal"
                            );
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $no++ ?></th>
                                <td><?php echo $data['isi'] ?></td>
                                <td><?php echo $data['tgl_awal'] ?></td>
                                <td><?php echo $data['tgl_akhir'] ?></td>
                                <td>
                                    <?php
                                    if ($data['status'] == '1') {
                                    ?>
                                    <a class="btn btn-success rounded-pill px-3" type="button" 
                                    href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=0">
                                        Sudah
                                    </a>
                                    <?php
                                    } else {
                                    ?>
                                        <a class="btn btn-warning rounded-pill px-3" type="button" 
                                        href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=1">
                                        Belum</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-info rounded-pill px-3" 
                                    href="index.php?id=<?php echo $data['id'] ?>">Ubah
                                    </a>
                                    <a class="btn btn-danger rounded-pill px-3" 
                                        href="index.php?aksi=hapus&id=<?php echo $data['id'] ?>">Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
