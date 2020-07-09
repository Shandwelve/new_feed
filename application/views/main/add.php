<div class="popup_create_container">
    <div class="popup_create_new">
        <form action="/add" method="POST" enctype="multipart/form-data">
            <div class="popup_header">
                Add new
            </div>
            <div><?= $status ?? '' ?></div>
            <div class="popup_inputs_container">
                <input type="text" placeholder="title" name="new_title" value="<?= $_POST['new_title'] ?? '' ?>">
                <input type="text" placeholder="first name" name="new_first_name"
                       value="<?= $_POST['new_first_name'] ?? '' ?>">
                <input type="text" placeholder="last name" name="new_last_name"
                       value="<?= $_POST['new_last_name'] ?? '' ?>">
                <input type="date" placeholder="post date" name="new_post_date"
                       value="<?= $_POST['new_post_date'] ?? '' ?>">
                <input type="file" placeholder="post image" name="new_post_image"
                       value="<?= $_FILES['new_post_image']['name'] ?>">
                <textarea name="new_description"><?= $_POST['new_description'] ?? '' ?></textarea>
            </div>
            <div class="popup_footer">
                <input type="submit" name="submit">
            </div>
        </form>
    </div>
</div>
<?php var_dump($_FILES); ?>