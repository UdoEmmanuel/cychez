<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Log In</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><span>Log In</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login-register-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="login-register">
                        <h3 class="login-register__title">Log In</h3>

                        <!-- Success Message -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Error Message -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Validation Errors -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="login-register__form">
                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="email"
                                        name="email"
                                        placeholder="Email address *"
                                        value="<?= old('email') ?>"
                                        required
                                    />
                                </div>

                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="password"
                                        name="password"
                                        placeholder="Password *"
                                        required
                                    />
                                </div>

                                <div class="single-form d-flex justify-content-between align-items-center">
                                    <div>
                                        <input type="checkbox" id="remember" name="remember">
                                        <label for="remember" class="single-form__label checkbox-label">
                                            <span></span> Remember me
                                        </label>
                                    </div>

                                    <!-- <p class="lost-password mb-0">
                                        <a href="<?= base_url('forgot-password') ?>">Lost your password?</a>
                                    </p> -->
                                </div>

                                <div class="single-form">
                                    <button type="submit" class="single-form__btn btn">
                                        Log In
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Don't have an account?
                                <a href="<?= base_url('register') ?>">Register here</a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->
</main>

<?= $this->endSection() ?>