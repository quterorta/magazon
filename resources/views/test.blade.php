<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>ТЕСТ</h1>

@foreach ($products->unique() as $product)
    <p>Название: {{ $product->title }} | Количество: {{ $products->countBy('id')[$product->id] }}</p>
@endforeach

</body>
</html>
