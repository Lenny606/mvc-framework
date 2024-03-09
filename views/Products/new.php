<h1>
    ADD PRODUCT
</h1>
<a href="/products">all products</a>
<form method="post" action="/products/create">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">

    <?php if(isset($errors["name"])) : ?>
        <p style="color: red"><?php echo $errors["name"] ?></p>
    <?php endif;?>

    <label for="description">Description</label>
    <input type="text" name="description" id="description">

    <button>Save</button>

</form>
</body>
</html>