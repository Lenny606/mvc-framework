{% extends "/shared/base.mvc.php" %}

{% block title %} Add products {% endblock %}

{% block body %}

<h1>
   Edit {{ product["name"] }}
</h1>

<form method="post" action="/products/{{ product['id'] }}/update">

    {% include "__DIR__ . /../../views/shared/form.mvc.php" %}

</form>
</body>
</html>
<!--<a href="/products">all products</a>-->
<a href="/products/{{ $product['id']) }]/show">Back</a>
{% endblock %}