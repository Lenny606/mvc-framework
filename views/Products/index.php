<h1>
    PRODUCTS
</h1>

<a href="/products/new">New product</a>
<p><?= htmlspecialchars($total)?> product found </p>

<?php foreach ($products as $product): ?>
    <h2>
        <a href="/products/<?= $product['id'] ?>/show">
            <?= htmlspecialchars($product["name"]) ?>
        </a>
    </h2>
<!--    <p>--><?php //= htmlspecialchars($product["description"]) ?><!--</p>-->
<?php endforeach; ?>
</body>
</html>