<!DOCTYPE html>
<html>
<head>
    <title>
        {% yield title %}
    </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

<h1>
    PRODUCTS
</h1>

<a href="/products/new">New product</a>
<p>{{ total }} product found </p>

{% yield body %}

</body>
</html>