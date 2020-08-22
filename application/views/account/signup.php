<style>
    body {
        background-color: #f5f5f5;
    }

    .register {
        margin-top: 100px;
        margin-bottom: 50px;
    }

    #signup {

    }
</style>
<body>
<div class="container register">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?= $status ?></div>
                <div class="card-body">

                    <form class="form-horizontal" method="post" action="/signup">

                        <div class="form-group">
                            <label for="first_name" class="cols-sm-2 control-label">Your First Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                           value="<?= $_POST['first_name'] ?? '' ?>"
                                           placeholder="Enter your First Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="cols-sm-2 control-label">Your Last Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                           value="<?= $_POST['last_name'] ?? '' ?>" placeholder="Enter your Last Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">Username</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="username" id="username"
                                           value="<?= $_POST['username'] ?? '' ?>" placeholder="Enter your Username"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label">Your Email</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="email" id="email"
                                           value="<?= $_POST['email'] ?? '' ?>" placeholder="Enter your Email"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Enter your Password"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="confirm" id="confirm"
                                           placeholder="Confirm your Password"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="signup" class="btn btn-primary btn-lg btn-block login-button"
                                   value="Signup">
                        </div>
                        <div class="login-register">
                            <a href="/signin">Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>