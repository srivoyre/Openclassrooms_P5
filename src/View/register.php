<?php $this->title = 'Registration'; ?>

<div class="row mt-5">
    <div class="col-sm-2 col-xl-3"></div>

    <div class="col-12 col-sm-8 col-xl-6">

        <h1>
            Registration
        </h1>

        <form method="post" action="index.php?route=register">
            <div class="form-group">
                <label for="pseudo">Username *</label>
                <br />
                <input class="form-control"
                       type="text"
                       id="pseudo"
                       name="pseudo"
                       value="<?= isset($post) ? filter_var($post->get('pseudo'), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''; ?>"
                       aria-label="Username"
                       aria-required="true"
                       required />
                <br />
                <span class="alert-danger">
                    <?= isset($errors['pseudo']) ? filter_var($errors['pseudo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <br />
                <input class="form-control"
                       type="email"
                       id="email"
                       name="email"
                       value="<?= isset($post) ? filter_var((string)$post->get('email'), FILTER_SANITIZE_EMAIL) : '' ; ?>"
                       aria-label="Email"
                       aria-describedby="basic-addon1"
                       aria-required="true"
                       required />
                <br />
                <span class="alert-danger">
                    <?= isset($errors['email']) ? filter_var($errors['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="password">Password *</label><span class="small font-italic">(at least 6 characters)</span>
                <br />
                <input class="form-control" type="password" id="password" name="password" aria-label="Password" aria-required="true">
                <br />
                <span class="alert-danger">
                    <?= isset($errors['password']) ? filter_var($errors['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''; ?>
                </span>
            </div>
            <input class="btn btn-primary btn-block" type="submit" value="Register" id="submit" name="submit">
        </form>

        <div class="row mt-5">
            <div class="col-6 text-center">
                <a type="button" class="btn btn-primary btn-block" href="index.php?route=login">
                    I have an account!
                </a>
            </div>
            <div class="col-6 text-center">
                <a type="button" class="btn btn-info btn-block" href="index.php">
                    Go to Homepage
                </a>
            </div>
        </div>

    </div>

    <div class="col-sm-2 col-xl-3"></div>

</div>
