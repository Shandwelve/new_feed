<div class="popup_create_container" id="popup_edit">
    <div class="popup_create_new">
        <form action="/edit/<?= $this->route['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="popup_header">
                Edit article
            </div>
            <div><?= $status ?? '' ?></div>
            <div class="popup_inputs_container">
                <input type="text" placeholder="title" name="new_title" value="<?= $data[0]['title']; ?>">
                <input type="text" placeholder="first name" name="new_first_name"
                       value="<?= $author[0]['first_name'] ?>" readonly>
                <input type="text" placeholder="last name" name="new_last_name" value="<?= $author[0]['last_name'] ?>"
                       readonly>
                <input type="date" placeholder="post date" name="new_post_date" value="<?= $data[0]['created_at']; ?>">
                <input type="file" placeholder="post image" name="new_post_image">
                <textarea name="new_description"> <?= $data[0]['content'] ?></textarea>
            </div>
            <div class="popup_footer">
                <input type="submit" name="submit">
            </div>
        </form>
    </div>
</div>