<style>
    body {
        padding-top: 56px;
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
            <img class="img-fluid rounded" src="/img/<?php echo $image; ?>" alt="image">

            <hr>

            <!-- Post Content -->
            <p class="lead"><?= $data[0]['content'] ?></p>

            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            <!-- Single Comment -->
            <?php if (!empty($comments)): ?>
            <?php for ($i = 0; $i < count($comments); $i++): ?>
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="https://img.pngio.com/user-profile-avatar-login-account-svg-png-icon-free-download-user-profile-png-980_982.png"  width="50px" height="50px" alt="">
                <div class="media-body">
                    <h5 class="mt-0"><?= $comment_authors[$i][0]['first_name'] . ' ' . $comment_authors[$i][0]['last_name'] ?></h5>
                    <?= $comments[$i]['content'] ?>
                </div>
            </div>
            <?php endfor; ?>
            <?php else: ?>
            <?= 'No comments' ?>
            <?php endif ?>
        </div>

    </div>
</div>