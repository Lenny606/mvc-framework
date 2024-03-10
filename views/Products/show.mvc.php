{% extends "/shared/base.mvc.php" %}

{% block title %} Products {% endblock %}

{% block body %}

<h1>
    {{ product["name"] }}
</h1>
    <p>{{ product["description"] }}</p>
<a href="/products">all products</a>
<a href="/products/{{ product['id'] }}/edit">Edit product</a>
<a href="/products/{{ product['id'] }}/delete">Delete product</a>
{% endblock %}