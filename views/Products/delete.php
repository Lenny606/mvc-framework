
<h1>
   Delete  <?= $product["name"] ?>
</h1>

<form method="post" action="/products/<?= $product["id"] ?>/destroy">

    <p>Really Delete?</p>
    <button>YES</button>

</form>
</body>
</html>
<!--<a href="/products">all products</a>-->
<a href="/products/<?= htmlspecialchars($product["id"]) ?>/show">Back</a>
</body>
</html>