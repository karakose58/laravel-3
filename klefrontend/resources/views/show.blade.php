<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post['title'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/w.css" rel="stylesheet" />
</head>
<body>


<style>
    .a{
        font-size:20px;
        border-bottom:solid 1px black;
    }
</style>


    <div class="container urun_tablo_show">
    <h1>Ürün Detayı</h1>

    <p class="a" ><strong>Ürün Adı:</strong> {{ $post['title'] }}</p>
    <p class="a" ><strong>Açıklama:</strong> {{ $post['text'] }}</p>
    
    <form  method="GET" action="{{ route('home') }}" style="display: inline;">
                @csrf
                <button class="btnnn " type="submit">anasayfaya dön</button>
            </form>

            <form  method="POST" action="{{ route('delete.product', $post['id']) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button class=btnn type="submit" >Ürün sil</button>
        </form>

        <form  method="GET" action="{{ route('edit.product', $post['id']) }}" style="display: inline;">
           @csrf
          <button class=btnnn  type="submit">Düzenle</button>
        </form>
    </div>







</body>
</html>





