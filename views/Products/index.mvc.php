{% extends "/shared/base.mvc.php" %}

{% block title %} Products {% endblock %}

{% block body %}

<!--<h1>-->
<!--    PRODUCTS-->
<!--</h1>-->
<!---->
<!--<a href="/products/new">New product</a>-->
<!--<p>{{ total }} product found </p>-->

{% foreach ($products as $product): %}
    <h2>
        <a href="/products/{{ product['id'] }}/show">
            {{ product["name"] }}
        </a>
    </h2>
{% endforeach; %}

{% endblock %}