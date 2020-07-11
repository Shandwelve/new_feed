<div class="news_feed_header">
    News Feed
    <button id="btn_add_new" class="popup_button">
        <a href="/add">
            add new
        </a>
    </button>
</div>

<?php
if (isset($_POST['submit'])) {
    echo '<h1>' . $_POST['new_title'] . '</h1>';
}
?>

<?php for ($i = 0; $i < count($articles); $i++): ?>
    <a href="/article/<?= $articles[$i]['id']; ?>">
        <li class="news_container">
            <div class="news_image">
                <img class="b-lazy" src="" data-src="/img/<?= $images[$i]['image'] ?>" alt="image">
            </div>
            <div class="news_description_container">
                <div class="news_title">
                    <?= $articles[$i]['title'] ?>
                </div>
                <div class="news_description">
                    <?= $articles[$i]['content'] ?>
                </div>
            </div>
        </li>
    </a>
<?php endfor; ?>

<?= $pages ?>