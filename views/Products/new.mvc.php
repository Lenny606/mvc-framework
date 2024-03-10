{% extends "/shared/base.mvc.php" %}

{% block title %} Add products {% endblock %}

{% block body %}

<h1>
    ADD PRODUCT
</h1>
<a href="/products">all products</a>
<form method="post" action="/products/create">

    {% include "__DIR__ . /../../views/shared/form.mvc.php" %}

</form>
{% endblock %}