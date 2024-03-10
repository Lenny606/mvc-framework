{% extends "/shared/base.mvc.php" %}

{% block title %} Delete Products {% endblock %}

{% block body %}

<h1>
   Delete  {{ product["name"] }}
</h1>

<form method="post" action="/products/{{ product['id'] }}/destroy">

    <p>Really Delete?</p>
    <button>YES</button>

</form>

<!--<a href="/products">all products</a>-->
<a href="/products/{{ product['id'] }}/show">Back</a>
{% endblock %}