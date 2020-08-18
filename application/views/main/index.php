<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .jumbotron {
        padding-top: 3rem;
        padding-bottom: 3rem;
        margin-bottom: 0;
        background-color: #fff;
    }

    @media (min-width: 768px) {
        .jumbotron {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }
    }

    .jumbotron p:last-child {
        margin-bottom: 0;
    }

    .jumbotron h1 {
        font-weight: 300;
    }

    .jumbotron .container {
        max-width: 40rem;
    }

    .img-container {
        position: relative;
    }

    .card-caption {
        font-weight: bold;
        font-size: 24px;
    }

    footer {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    footer p {
        margin-bottom: .25rem;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>

<main role="main">

    <?php if ($_SESSION['account'] === 'user'): ?>
        <section class="jumbotron text-center">
            <div class="container">
                <h1>Hello <?= $_SESSION['username'] ?></h1>
                <p class="lead text-muted">You can view articles add comments and appreciate articles and comments with
                    like or dislike.</p>
            </div>
        </section>

    <?php elseif ($_SESSION['account'] === 'admin'): ?>
        <section class="jumbotron text-center">
            <div class="container">
                <h1>Hello <?= $_SESSION['username'] ?></h1>
                <p class="lead text-muted">You can view articles add comments and appreciate articles and comments with
                    like or dislike edit, delete and add articles.</p>
                <p>
                    <a href="/add" class="btn btn-primary my-2">Add article</a>
                </p>
            </div>
        </section>

    <?php else: ?>
        <section class="jumbotron text-center">
            <div class="container">
                <h1>Hello guest</h1>
                <p class="lead text-muted">To view articles add comments and appreciate articles and comments with
                    like or dislike edit signin or signup.</p>
                <p>
                    <a href="/signin" class="btn btn-primary my-2">Signin</a>
                    <a href="/signup" class="btn btn-primary my-2">Signup</a>
                </p>
            </div>
        </section>

    <?php endif ?>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php for ($i = 0; $i < count($articles); $i++): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="img-container">
                                <img src="/img/<?= $images[$i]['image'] ?>" alt="image" width="100%" height="225">
                            </div>
                            <div class="card-body">
                                <p class="card-caption"><?= $articles[$i]['title'] ?></p>
                                <p class="card-text"> <?= $articles[$i]['content'] ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="/show/<?= $articles[$i]['id']; ?>">
                                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                                View
                                            </button>
                                        </a>
                                        <?php if ($_SESSION['account'] === 'admin'): ?>
                                            <a href="/edit/<?= $articles[$i]['id']; ?> ">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit
                                                </button>
                                            </a>
                                            <a href="/delete/<?= $articles[$i]['id']; ?>">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Delete
                                                </button>
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <?= $pages ?>

</main>


