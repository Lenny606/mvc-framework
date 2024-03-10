
<h1>
   Edit  <?= $product["name"] ?>
</h1>

<form method="post" action="/products/<?= $product["id"] ?>/update">

    <?php require __DIR__ . "/../shared/form.php"; ?>

</form>
</body>
</html>
<!--<a href="/products">all products</a>-->
<a href="/products/<?= htmlspecialchars($product["id"]) ?>/show">Back</a>
</body>
</html>