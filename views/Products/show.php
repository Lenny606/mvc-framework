
<h1>
    <?= htmlspecialchars($product["name"]) ?>
</h1>
    <p><?= htmlspecialchars($product["description"]) ?></p>
<a href="/products">all products</a>
<a href="/products/<?= htmlspecialchars($product["id"]) ?>/edit">Edit product</a>
<a href="/products/<?= htmlspecialchars($product["id"]) ?>/delete">Delete product</a>
</body>
</html>