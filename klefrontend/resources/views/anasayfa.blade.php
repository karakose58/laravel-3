<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/w.css" rel="stylesheet" />
</head>
<body>











<div class="container-sm mt-5 ca">
    <div class="asas ">
        <div class="cc">
            <h1>Ürün Listesi</h1>
        </div>
        <div class="cc">
            <div class="asaa">
                <a style="margin-right:10px; float:right;" href="{{ route('add.product') }}" class="btn btn-success btn-md a">Ürün Ekle</a>
                <form style="margin-right:10px; float:right" method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-danger btn-md a" type="submit">Çıkış Yap</button>
</form>
            </div>
        </div>
    </div>
</div>


@foreach($posts as $post)
    <div class="container urun_tablo">
        <div class="row r">
            <div class="col c">Ürün Adı</div>
            <div class="col">{{ $post['title'] }}</div>
        </div>
        <div class="row r">
            <div class="col c">Ürün Fiyatı</div>
            <div class="col">{{ $post['text'] }}</div>
        </div>
        <div class="row r">
        <div class="">


        <form  method="GET" action="{{ route('show.product', $post['id']) }}" style="display: inline;">
                @csrf
                <button class="btnnn " type="submit">Göster</button>
            </form>



     
        </div>
    </div>
    @endforeach








</body>
</html>


 
    




