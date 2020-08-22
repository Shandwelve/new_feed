<style>
    body {
        padding-top: 56px;
    }

    #like, #dislike {
        display: none;
    }

    #like-btn {
        background: #007bff;
        opacity: 0.5;
    }

    .active {
        opacity: 1 !important;
    }

    #dislike-btn {
        background: #dc3545;
        opacity: 0.5;
    }

    #likes-number {
        color: #007bff;
    }

    #dislikes-number {
        color: #dc3545;
    }

    .main {
        font-size: 25px;
    }

    .delete-comment {
        grid-area: 1/3/2/4;
        place-self: flex-start flex-end;
    }

    .grid-container {
        display: grid;
        grid-template-columns: 1fr 2fr 2fr;
        grid-template-rows: 50px auto 50px;
        place-items: center;
    }

    .grid-container img {
        grid-area: 1/1/2/2;
        margin: 20px 0 0 0;
    }

    .grid-container h5 {
        grid-area: 1/2/2/3;
        justify-self: flex-start;
    }

    .grid-container p {
        grid-area: 2/2/3/4;
    }


    .btn-group a {
        color: white;
    }

    .checked {
        pointer-events: none;
    }

</style>

<div class="container">

    <div class="row justify-content-center">

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4"><?= $data[0]['title']; ?></h1>

            <!-- Author -->
            <p class="lead">
                by
                <?= $article_author[0]['username'] ?>
            </p>

            <hr>

            <!-- Date/Time -->
            <p><?= $data[0]['created_at']; ?></p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src="/img/<?= $image; ?>" alt="image">

            <hr>

            <!-- Post Content -->
            <p class="lead"><?= $data[0]['content'] ?></p>

            <hr>

            <?php if ($_SESSION['account'] !== 'guest'): ?>
                <!-- Likes -->
                <div class="btn-group btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                    <div>
                        <label class="btn btn-secondary active d-flex justify-content-center" id="like-btn">
                            <input type="radio" name="options" id="like"
                                   autocomplete="off" <?= $appreciation['like_status'] ?> >
                            <a href="/addLike/<?= $this->route['id'] ?>" class="<?= $appreciation['like_status'] ?>">
                                <i class="far fa-thumbs-up main"></i>
                            </a>
                        </label>
                        <div class="d-flex justify-content-center" id="likes-number">
                            <?= $appreciation['likes_number'] ?>
                        </div>
                    </div>

                    <div>
                        <label class="btn btn-secondary d-flex justify-content-center" id="dislike-btn">
                            <input type="radio" name="options" id="dislike"
                                   autocomplete="off" <?= $appreciation['dislike_status'] ?>>
                            <a href="/addDislike/<?= $this->route['id'] ?>"
                               class="<?= $appreciation['dislike_status'] ?>">
                                <i class="far fa-thumbs-down main"></i>
                            </a>
                        </label>
                        <div class="d-flex justify-content-center" id="dislikes-number">
                            <?= $appreciation['dislikes_number'] ?>
                        </div>
                    </div>

                </div>
            <?php endif ?>

            <!-- Comments Form -->
            <?php if ($_SESSION['account'] !== 'guest'): ?>
                <div class="card my-4">
                    <h5 class="card-header"><?= $comments_status ?></h5>
                    <div class="card-body">
                        <form method="post" action="/addComment/<?= $this->route['id'] ?>">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="comment_message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            <?php endif ?>

            <!-- Single Comment -->
            <?php if (!empty($comments)): ?>
                <?php for ($i = 0; $i < count($comments); $i++): ?>
                    <div class="mb-4 grid-container">

                        <?php if ($_SESSION['account'] == 'admin'): ?>
                            <div class="delete-comment">
                                <a href="/deleteComment/<?= $comments[$i]['id'] ?>">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        <?php endif ?>

                        <img class="rounded-circle"
                             src="https://img.pngio.com/user-profile-avatar-login-account-svg-png-icon-free-download-user-profile-png-980_982.png"
                             width="50px" height="50px" alt="">
                        <h5 class="mt-0"><?= $comment_authors[$i][0]['username'] ?></h5>
                        <p>
                            <?= $comments[$i]['content'] ?>
                        </p>

                    </div>
                <?php endfor; ?>
            <?php else: ?>
                <?= 'No comments' ?>
            <?php endif ?>

        </div>
    </div>
</div>