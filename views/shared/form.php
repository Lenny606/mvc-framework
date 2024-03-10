<label for="name">Name</label>
<input type="text" name="name" id="name" value="<?php echo $product["name"] ?? ""?>">

<?php if (isset($errors["name"])) : ?>
    <p style="color: red"><?php echo $errors["name"] ?></p>
<?php endif; ?>

<label for="description">Description</label>
<textarea  name="description" id="description"><?php echo $product["description"] ?? ""?></textarea>

<button>Save</button>