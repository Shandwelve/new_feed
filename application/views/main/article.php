<div class="buttons_tab">
    <button id="button_delete_article">
        <a href="/delete/<?= $this->route['id'] ?>">Delete</a>
    </button>

    <button id="button_update_article" class="popup_button">
        <a href="/edit/<?= $this->route['id'] ?>">Edit</a>
    </button>

</div>

<div class="article_container">
    <div class="article_header">
        <div>
            <?= $data[0]['title']; ?>
        </div>
        <div>
            <span><?= $article_author[0]['first_name'] . ' ' . $article_author[0]['last_name'] ?></span>
            <span><?= $data[0]['created_at']; ?></span>
        </div>
    </div>
    <div class="article_image">
        <img src="/img/<?php echo $image; ?>" alt="">
    </div>
    <div class="article_description">
        <?= $data[0]['content'] ?>
    </div>
</div>
<div class="comments_container">
    <div class="comments_header">
        comments
    </div>

    <div class="message"><?= $status ?></div>
    <form action="/article/<?= $this->route['id'] ?>" method="POST">
        <div class="comments_inputs_container">
            <div class="comments_name_inputs_container">
                <input type="text" placeholder="first name" name="comment_first_name"
                       value="<?= $_POST['comment_first_name'] ?? '' ?>">
                <input type="text" placeholder="last name" name="comment_last_name"
                       value="<?= $_POST['comment_last_name'] ?? '' ?>">
            </div>
            <textarea name="comment_message" id="" cols="30" rows="10"><?= $_POST['comment_message'] ?? '' ?></textarea>
            <div class="comments_bottom">
                <div>
                    <input type="checkbox" id="like_input" name="like">
                    <label for="like_input">Like</label>
                </div>
                <input type="submit" value="Comment" name="add_comment">
            </div>
        </div>
    </form>

    <div class="message"><?= $likes ?> likes</div>

    <div class="comments_written">
        <?php if (!empty($comments)): ?>
            <?php for ($i = 0; $i < count($comments); $i++): ?>
                <div class="comment">
                    <div class="comment_data">
                        <div class="comment_author">
                            <?= $comment_authors[$i][0]['first_name'] . ' ' . $comment_authors[$i][0]['last_name'] ?>
                        </div>
                        <div class="comment_date">
                            <?= $comments[$i]['commented_at']; ?>
                        </div>
                    </div>
                    <div class="comment_itself">
                        <?= $comments[$i]['content'] ?>
                    </div>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <?= 'No comments' ?>
        <?php endif ?>
    </div>

