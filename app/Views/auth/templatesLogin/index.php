<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sistem Pendampingan Ujian</title>
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/auth/css/montserrat-font.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/auth/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/auth/css/style.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>

    <!-- Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,500&display=swap');
    </style>

    <!-- My Style CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/auth/css/myStyle.css">
</head>

<body>
    <?= $this->renderSection('auth-content'); ?>

    <!-- My Javascript -->
    <script type='text/javascript' src="<?= base_url(); ?>/auth/js/myJavascript.js">
    </script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- My JS -->
    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 'madif' ? 'block' : 'none';
        }
    </script>
</body>

</html>