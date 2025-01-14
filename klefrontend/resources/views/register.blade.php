<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kayıt yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/login.css" rel="stylesheet" />
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        şifre eşleşmiyor 
    </div>
@endif
    
        <div class="giriscon container d-flex justify-content-center  min-vh-100">
        <form class="form" action="{{ route('register')}}" method="post">
            @csrf
            <h1 class="h1">Kayıt Yap</h1>
            <div class="inputbox">
                <input class="input" type="text" name="name" placeholder="Adınız Soyadınız" required />
            </div>

            <div class="inputbox">
                <input class="input" type="email" name="email" placeholder="E-posta adresiniz" required />
            </div>

            <div class="inputbox">
            <input class="input" type="password" name="password" placeholder="şifreniz" required />
            </div>
            <div class="inputbox">
                <input class="input" type="password" name="password_confirmation" placeholder="Şifrenizi Tekrar Giriniz" required />
            </div>

            <div class="gonder">
                <input class="btngonder" type="submit" name="btn" value="gonder" />

            </div>


        </form>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>