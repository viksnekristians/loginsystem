<form action="/update" method="post">
    <input type="text" name="title" value="<?php echo $data[1]; ?>">
    <input type="text" name="description" value="<?php echo $data[2]; ?>">
    <button type="submit" class="btn btn-primary" name="id" value="<?php echo $data[0]; ?>">Save</button>
</form>
