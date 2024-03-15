{% extends "/shared/base.mvc.php" %}

{% block title %} Articles {% endblock %}
{% block body %}
<div class="container">
    <h1>Food Articles</h1>

    <!-- Sample article 1 -->
    <div class="article">
        <h2>Delicious Recipes for Summer BBQ</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tristique lacus vitae ex porta, nec pulvinar felis tincidunt.</p>
        <a href="#">Read more</a>
    </div>

    <!-- Sample article 2 -->
    <div class="article">
        <h2>Top 10 Healthy Breakfast Ideas</h2>
        <p>Phasellus dictum magna eu lacus interdum, ac facilisis nisl fringilla. Donec nec dolor at ex feugiat venenatis.</p>
        <a href="#">Read more</a>
    </div>

    <!-- Sample article 3 -->
    <div class="article">
        <h2>Exploring Street Food Culture Around the World</h2>
        <p>Vivamus tempor orci a sem aliquet, vel viverra nisi venenatis. Integer vel turpis sit amet elit tempus commodo.</p>
        <a href="#">Read more</a>
    </div>
</div>

</body>
</html>
{% endblock %}