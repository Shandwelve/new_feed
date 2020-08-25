<main id="main_show">
    <div class="container">

        <div class="row justify-content-center">

            <!-- Post Content Column -->
            <div>

                <!-- Title -->
                <h1 class="mt-4"><?= $data[0]['title']; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by
                    <?= $data[0]['username'] ?>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><?= $data[0]['created_at']; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-fluid rounded" src="/img/<?= $data[0]['image']; ?>" alt="image <?= $this->route['id'] ?>">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?= $data[0]['content'] ?></p>
            </div>
        </div>
        <hr>
    </div>
</main>