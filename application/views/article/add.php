<style>
    body {
        background-color: #f5f5f5;
    }

    .register {
        margin: 80px auto 25px auto;
    }

    textarea {
        resize: none;
    }
</style>

<div class="container register">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?= $status ?></div>
                <div class="card-body">

                    <form class="form-horizontal" method="post" action="/add" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Title</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="new_title"
                                           value="<?= $_POST['new_title'] ?? '' ?>" id="name"
                                           placeholder="Enter title"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date" class="cols-sm-2 control-label">Post date</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="date" class="form-control" name="new_post_date"
                                           value="<?= $_POST['new_post_date'] ?? '' ?>" id="date"
                                           placeholder="Enter post date"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time" class="cols-sm-2 control-label">Post time</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="time" class="form-control" name="new_post_time"
                                           value="<?= $_POST['new_post_time'] ?? '' ?>" id="time"
                                           placeholder="Enter post time"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="cols-sm-2 control-label">Image</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="new_post_image"
                                           value="<?= $_FILES['new_post_image']['name'] ?>" id="image"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="cols-sm-2 control-label">Content</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <textarea name="new_description" id="content" cols="30" rows="10"
                                              class="form-control"><?= $_POST['new_description'] ?? '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
