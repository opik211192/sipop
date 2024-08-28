<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPPOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .bg-image {
            background-image: url('{{ asset('img/dashboard.jpg') }}');
            /* filter: blur(8px);
            -webkit-filter: blur(8px); */
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .bg-text {
            background-color: rgba(0, 0, 0, 0.5);
            /* Black w/opacity */
            color: white;
            font-weight: bold;
            border: 3px solid #f1f1f1;
            position: absolute;
            bottom: -100px;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 80%;
            padding: 20px;
            text-align: center;
            border-radius: 15px;
        }

        .bg-text a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .bg-text a:hover {
            color: #f1f1f1;
        }
    </style>
</head>

<body>

    <div class="bg-image"></div>

    <div class="bg-text">
        <img style="max-width: 100px;" class="mb-2" src="{{ asset('img/citanduy.png') }}" alt="Logo SIPPOP">
        <h1>SIPPOP</h1>
        <p>Sistem Informasi Pemantauan Persiapan Operasi dan Pemeliharaan</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow"><span class="fas fa-share-from-square"></span> Login</a>
    </div>

</body>

</html>