<?php $this->title = 'Login' ;?>
<div class="row mt-5">
    <div class="col-sm-2 col-lg-3 col-xl-4"></div>
    <div class="col-12 col-sm-8 col-lg-6 col-xl-4">

        <h1>
            Login
        </h1>

        <div class="row">
            <div class="col-12">

                <form method="post" action="index.php?route=login">
                    <div class="form-group">
                        <label for="pseudo">Username or email</label>
                        <br />
                        <input class="form-control" type="text" id="pseudo" name="pseudo" aria-label="Username/Email" aria-required="true" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <br />
                        <input class="form-control" type="password" id="password" name="password" aria-label="Password" aria-required="true" required>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Login" id="submit" name="submit">
                </form>
                <div class="row mt-5">
                    <div class="col-6 text-center">
                        <a type="button" class="btn btn-primary btn-block" href="index.php?route=register">
                            Register
                        </a>
                    </div>
                    <div class="col-6 text-center">
                        <a type="button" class="btn btn-info btn-block" href="index.php">
                            Go to Homepage
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-2 col-md-3 col-xl-4"></div>

            <div class="col-sm-2 col-md-3 col-xl-4"></div>
        </div>

    </div>

    <div class="col-sm-2 col-lg-3 col-xl-4"></div>

</div>
