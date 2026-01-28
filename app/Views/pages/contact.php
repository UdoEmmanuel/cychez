<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Contact Us</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><span>Contact Us</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Contact Us Start -->
    <div class="contact-us-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="contact-us-wrapper">
                <div class="row gy-5">

                    <!-- CONTACT FORM START -->
                    <div class="col-md-8">
                        <div class="contact-us">
                            <h2 class="contact-us__title">
                                Contact us for any questions
                            </h2>

                            <!-- ERRORS SECTION -->
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- ERROR MESSAGE -->
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <!-- SUCCESS MESSAGE -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>

                            <!-- CONTACT FORM -->
                            <div class="contact-us-form">
                                <form action="<?= base_url('contact') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="single-form__label">First Name*</label>
                                                <input class="single-form__input" type="text" 
                                                       name="first_name" value="<?= old('first_name') ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="single-form__label">Last Name*</label>
                                                <input class="single-form__input" type="text" 
                                                       name="last_name" value="<?= old('last_name') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single-form">
                                        <label class="single-form__label">Email*</label>
                                        <input class="single-form__input" type="email" 
                                               name="email" value="<?= old('email') ?>" required>
                                    </div>

                                    <div class="single-form">
                                        <label class="single-form__label">Phone Number*</label>
                                        <input class="single-form__input" type="text" 
                                               name="phone" value="<?= old('phone') ?>" required>
                                    </div>

                                    <div class="single-form">
                                        <label class="single-form__label">Subject*</label>
                                        <input class="single-form__input" type="text" 
                                               name="subject" value="<?= old('subject') ?>" required>
                                    </div>

                                    <div class="single-form">
                                        <label class="single-form__label">How can we help?*</label>
                                        <textarea class="single-form__input" 
                                                  name="message" rows="5" required><?= old('message') ?></textarea>
                                    </div>

                                    <div class="single-form">
                                        <button class="single-form__btn btn" type="submit">
                                            Send Message
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- CONTACT FORM END -->

                    <!-- CONTACT INFO START -->
                    <div class="col-md-4">
                        <div class="contact-us">
                            <h2 class="contact-us__title">
                                Contact info
                            </h2>

                            <div class="contact-us-info">

                                <div class="contact-info-item">
                                    <h4 class="contact-info-item__title">Call Us:</h4>
                                    <p>We're available from 8 am – 10 pm GMT+1, 7 days a week.</p>

                                    <div class="contact-info-item__service">
                                        <h4 class="contact-info-item__service--title">Customer Service</h4>
                                        <p>
                                            <a href="tel:+2348033095016">+234 803 309 5016</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="contact-info-item">
                                    <h4 class="contact-info-item__title">Email Us</h4>
                                    <p><a href="mailto:info@cychez.com">info@cychez.com</a></p>
                                </div>

                                <div class="contact-info-item">
                                    <h4 class="contact-info-item__title">Find Us</h4>
                                    <p>
                                        1 Psychiatric Hospital Rd, Rumuigbo,<br>
                                        Port Harcourt, Rivers State, Nigeria
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- CONTACT INFO END -->

                </div>
            </div>
        </div>
    </div>
    <!-- Contact Us End -->
</main>

<?= $this->endSection() ?>