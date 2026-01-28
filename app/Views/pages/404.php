<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <!-- Error Start -->
    <div class="error-section">
        <div class="container-fluid faq-container">
            <!-- Error Content Start -->
            <div class="error-content text-center">
                <img class="error-content__icon" src="<?= base_url('assets/images/404.svg') ?>" alt="404" width="62" height="62" />
                <h2 class="error-content__title">
                    404. Page not found.
                </h2>
                <p>
                    Sorry, we couldn’t find the page you where looking
                    for. We suggest that you return to homepage.
                </p>
                <a href="<?= base_url('/') ?>" class="error-content__btn btn">Back to homepage</a>
            </div>
            <!-- Error Content End -->
        </div>
    </div>
    <!-- Error End -->
</main>

<?= $this->endSection() ?>