<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Register</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><span>Register</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Register Start -->
    <div class="login-register-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="login-register">
                        <h3 class="login-register__title">Register</h3>

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

                        <form action="<?= base_url('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="login-register__form">
                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="text"
                                        name="first_name"
                                        placeholder="First Name *"
                                        value="<?= old('first_name') ?>"
                                        required
                                    />
                                </div>

                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="text"
                                        name="last_name"
                                        placeholder="Last Name *"
                                        value="<?= old('last_name') ?>"
                                        required
                                    />
                                </div>

                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="email"
                                        name="email"
                                        placeholder="Email Address *"
                                        value="<?= old('email') ?>"
                                        required
                                    />
                                </div>

                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="tel"
                                        name="phone"
                                        placeholder="Phone Number *"
                                        value="<?= old('phone') ?>"
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

                                <div class="single-form">
                                    <input
                                        class="single-form__input"
                                        type="password"
                                        name="confirm_password"
                                        placeholder="Confirm Password *"
                                        required
                                    />
                                </div>

                                <div class="single-form">
                                    <p class="privacy-policy-text">
                                        Your personal data will be used to support your experience
                                        throughout this website, to manage access to your account,
                                        and for other purposes described in our
                                        <a href="<?= base_url('privacy-policy') ?>">privacy policy</a>.
                                    </p>
                                </div>

                                <div class="single-form">
                                    <button type="submit" class="single-form__btn btn">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Already have an account?
                                <a href="<?= base_url('login') ?>">Log in here</a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->
</main>

<?= $this->endSection() ?>