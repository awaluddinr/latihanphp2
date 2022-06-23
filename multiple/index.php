<?php

$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');


if (isset($_POST['kirim'])) {

    $filecount = count($_FILES['data']['name']);

    for ($i = 0; $i < $filecount; $i++) {
        $nama = $_FILES['data']['name'][$i];
        $type = $_FILES['data']['type'][$i];
        $error = $_FILES['data']['error'][$i];
        $tmp = $_FILES['data']['tmp_name'][$i];

        if ($type == 'image/jpeg' || $type == 'image/png') {
            $ext1 = explode('.', $nama);
            $ext1 = strtolower(end($ext1));

            $namabaru = uniqid();
            $namabaru .= '.';
            $namabaru .= $ext1;

            move_uploaded_file($tmp, 'upload/img/' . $namabaru);
            $query = "INSERT INTO files VALUES ('','$namabaru','$type')";
            $hasil = mysqli_query($conn, $query);

            if ($hasil) {
                $sukses = true;
            } else {
                $error = true;
            }
        } elseif ($type == 'video/mp4' || $type == 'video/mkv' || $type == 'video/x-matroska' || $type == 'video/avi') {
            $ext1 = explode('.', $nama);
            $ext1 = strtolower(end($ext1));

            $namabaru = uniqid();
            $namabaru .= '.';
            $namabaru .= $ext1;

            move_uploaded_file($tmp, 'upload/vid/' . $namabaru);
            $query = "INSERT INTO files VALUES ('','$namabaru','$type')";
            $hasil = mysqli_query($conn, $query);

            if ($hasil) {
                $sukses = true;
            } else {
                $error = true;
            }
        } elseif ($type == 'audio/mpeg' || $type == 'audio/wav' || $type == 'audio/aac') {
            $ext1 = explode('.', $nama);
            $ext1 = strtolower(end($ext1));

            $namabaru = uniqid();
            $namabaru .= '.';
            $namabaru .= $ext1;
            move_uploaded_file($tmp, 'upload/aud/' . $namabaru);
            $query = "INSERT INTO files VALUES ('','$namabaru','$type')";
            $hasil = mysqli_query($conn, $query);

            if ($hasil) {
                $sukses = true;
            } else {
                $error = true;
            }
        } else {
            $ekstensi = 'Tipe File Tidak Diizinkan !!!';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>


    <div class="container py-5 bg-dark">
        <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
            <small class="text-white mb-2 d-block">
                <font class="text-danger" style="font-size: 22px;">*</font>Tipe file yang boleh di upload yaitu(' jpg , jpeg , png , mp4 , mkv , avi , mp3 , aac , wav ')
            </small>
            <input type="file" name="data[]" class="form-control" accept="image/png, image/jpg, image/jpeg ,video/mp4, video/mkv, video/x-matroska, video/avi, audio/mpeg, audio/aac, audio/wav" multiple required>
            <div class="tombol text-center mt-3">

                <button type="submit" name="kirim" class="btn btn-primary col-4 py-2"> <i class="fa fa-upload"></i> Upload</button>
            </div>
        </form>
        <?php if (isset($ekstensi)) : ?>
            <div class="error bg-warning text-center" style="background-color: red;">
                <p style="font-size: 25px;" class="text-white"><?= $i . ' ' . $ekstensi; ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($sukses)) : ?>
            <div class="sukses bg-success text-center">
                <p style="font-size: 25px;" class="text-white py-2"><?= $i; ?> Data Sukses ditambahkan</p>
            </div>
        <?php elseif (isset($error)) : ?>
            <div class="error bg-warning text-center" style="background-color: red;">
                <p style="font-size: 25px;" class="text-white"><?= $i; ?> Data Gagal ditambahkan !!!</p>
            </div>
        <?php endif; ?>



        <!-- foto -->
        <div class="col-12">
            <h4 class="mt-5 ">Pengelompokkan gambar berdasarkan extensi</h4>
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Semua File</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">JPG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-messages-tab" data-toggle="pill" href="#custom-content-above-messages" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">PNG</a>
                </li>
            </ul>
            <div class="tab-custom-content">
                <p class="lead mb-0">Custom Content goes here</p>
            </div>
            <div class="tab-content" id="custom-content-above-tabContent">
                <?php

                $query = "SELECT * FROM files";
                $result = mysqli_query($conn, $query);

                ?>
                <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                    <div class="mb-0 d-flex flex-wrap ">
                        <?php while ($img = mysqli_fetch_assoc($result)) : ?>
                            <?php

                            $ekstensi = ['jpg', 'jpeg', 'png'];
                            $ext = explode('.', $img['nama']);
                            $ext = strtolower(end($ext));

                            ?>
                            <?php if (in_array($ext, $ekstensi)) : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a data-fancybox="galleryImg" href="upload/img/<?= $img['nama']; ?>" class="image" style="text-decoration: none;">
                                        <img src="upload/img/<?= $img['nama']; ?>" class="card-img-top" alt="..." height="200" width="180">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($jpg = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($jpg['tipe'] == 'image/jpeg') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a data-fancybox="galleryjpg" href="upload/img/<?= $jpg['nama']; ?>" class="image" style="text-decoration: none;">
                                        <img src="upload/img/<?= $jpg['nama'];  ?>" class="card-img-top" alt="..." height="200" width="180">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-messages" role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($png = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($png['tipe'] == 'image/png') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <img src="upload/img/<?= $png['nama'];  ?>" class="card-img-top" alt="..." height="200" width="180">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- video -->
        <div class="col-12">
            <h4 class="mt-5 ">Pengelompokkan video berdasarkan extensi</h4>
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-vid-tab" data-toggle="pill" href="#custom-content-above-vid" role="tab" aria-controls="custom-content-above-vid" aria-selected="true">Semua File</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-mp4-tab" data-toggle="pill" href="#custom-content-above-mp4" role="tab" aria-controls="custom-content-above-mp4" aria-selected="false">Mp4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-mkv-tab" data-toggle="pill" href="#custom-content-above-mkv" role="tab" aria-controls="custom-content-above-mkv" aria-selected="false">mkv</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-avi-tab" data-toggle="pill" href="#custom-content-above-avi" role="tab" aria-controls="custom-content-above-avi" aria-selected="false">avi</a>
                </li>
            </ul>
            <div class="tab-custom-content">
                <p class="lead mb-0">Custom Content goes here</p>
            </div>
            <div class="tab-content" id="custom-content-above-tabContent">
                <?php

                $query = "SELECT * FROM files";
                $result = mysqli_query($conn, $query);

                ?>
                <div class="tab-pane fade show active" id="custom-content-above-vid" role="tabpanel" aria-labelledby="custom-content-above-vid-tab">
                    <div class="mb-0 d-flex flex-wrap ">
                        <?php while ($vid = mysqli_fetch_assoc($result)) : ?>
                            <?php

                            $ekstensi = ['mp4', 'mkv', 'avi'];
                            $ext = explode('.', $vid['nama']);
                            $ext = strtolower(end($ext));

                            ?>
                            <?php if (in_array($ext, $ekstensi)) : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <video src="upload/vid/<?= $vid['nama']; ?>" height="200" width="180" controls>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-mp4" role="tabpanel" aria-labelledby="custom-content-above-mp4-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($mp4 = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($mp4['tipe'] == 'video/mp4') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <video src="upload/vid/<?= $mp4['nama']; ?>" height="200" width="180" controls>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-mkv" role="tabpanel" aria-labelledby="custom-content-above-mkv-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($mkv = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($mkv['tipe'] == 'video/mkv' || $mkv['tipe'] == 'video/x-matroska') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <video src="upload/vid/<?= $mkv['nama']; ?>" height="200" width="180" controls>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-avi" role="tabpanel" aria-labelledby="custom-content-above-avi-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($avi = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($avi['tipe'] == 'video/avi') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <video src="upload/vid/<?= $avi['nama']; ?>" height="200" width="180" controls>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- audio -->
        <div class="col-12">
            <h4 class="mt-5 ">Pengelompokkan audio berdasarkan extensi</h4>
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-aud-tab" data-toggle="pill" href="#custom-content-above-aud" role="tab" aria-controls="custom-content-above-aud" aria-selected="true">Semua File</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-mp3-tab" data-toggle="pill" href="#custom-content-above-mp3" role="tab" aria-controls="custom-content-above-mp3" aria-selected="false">Mp3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-wav-tab" data-toggle="pill" href="#custom-content-above-wav" role="tab" aria-controls="custom-content-above-wav" aria-selected="false">wav</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-aac-tab" data-toggle="pill" href="#custom-content-above-aac" role="tab" aria-controls="custom-content-above-aac" aria-selected="false">aac</a>
                </li>
            </ul>
            <div class="tab-custom-content">
                <p class="lead mb-0">Custom Content goes here</p>
            </div>
            <div class="tab-content" id="custom-content-above-tabContent">
                <?php

                $query = "SELECT * FROM files";
                $result = mysqli_query($conn, $query);

                ?>
                <div class="tab-pane fade show active" id="custom-content-above-aud" role="tabpanel" aria-labelledby="custom-content-above-aud-tab">
                    <div class="mb-0 d-flex flex-wrap justify-content-between ">
                        <?php while ($aud = mysqli_fetch_assoc($result)) : ?>
                            <?php

                            $ekstensi = ['mp3', 'wav', 'aac'];
                            $ext = explode('.', $aud['nama']);
                            $ext = strtolower(end($ext));

                            ?>
                            <?php if (in_array($ext, $ekstensi)) : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10 d-flex justify-content-between px-0 mx-0 mx-2">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <audio src="upload/aud/<?= $aud['nama']; ?>" height="200" width="150" controls>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-mp3" role="tabpanel" aria-labelledby="custom-content-above-mp3-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($mp3 = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($mp3['tipe'] == 'audio/mpeg') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <audio src="upload/aud/<?= $mp3['nama']; ?>" height="200" width="180" controls>
                                        </audio>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-wav" role="tabpanel" aria-labelledby="custom-content-above-wav-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($wav = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($wav['tipe'] == 'audio/wav') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <audio src="upload/aud/<?= $wav['nama']; ?>" height="200" width="180" controls>
                                        </audio>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-above-aac" role="tabpanel" aria-labelledby="custom-content-above-aac-tab">
                    <?php

                    $query = "SELECT * FROM files";
                    $result = mysqli_query($conn, $query);

                    ?>
                    <div class="mb-0 d-flex flex-wrap">
                        <?php while ($aac = mysqli_fetch_assoc($result)) : ?>
                            <?php if ($aac['tipe'] == 'audio/aac') : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a href="" class="image" style="text-decoration: none;">
                                        <audio src="upload/aud/<?= $aac['nama']; ?>" height="200" width="180" controls>
                                        </audio>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
</body>

</html>