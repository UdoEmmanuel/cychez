<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- About Start -->
    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="video">
                        <img src="assets/images/about/about-img-3.jpg" class="img-fluid rounded" alt="" loading="lazy">
                        
                        <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div>

                        <p class="fs-3 text-uppercase text-primary ">Who We Are?</p>
                        <h1 class="display-5 mb-3">We Are Dedicated To Providing You The Best Quality Products</h1>
                        <p class="mb-4 fs-5">
                            We are a customer-focused brand committed to delivering
                            high-quality products and services that enhance everyday
                            living. Our approach blends creativity, innovation, and
                            attention to detail to ensure every experience with us
                            feels intentional and valuable.
                        </p>
                        <hr style="width: 50px; height: 2px; color: #000">
                        <p class="mb-4 fs-5">
                            From concept to execution, we prioritize excellence,
                            transparency, and long-term relationships. Our team is
                            driven by a passion for craftsmanship and a deep
                            understanding of what our customers truly need.
                        </p>
                        <hr style="width: 50px; height: 2px; color: #000">
                        <p class="mb-4 fs-5">
                            Whether you are discovering us for the first time or
                            have been with us for years, our promise remains the
                            same — to consistently deliver quality you can trust.
                        </p>

                    </div>
                    <a href="<?= base_url('contact')?>" class="btn btn-primary rounded-pill py-3 px-5">Get In Touch</a>
                </div> 
            </div>
        </div>
    </div>
    <!-- Modal Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">About Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

<!-- Template Javascript -->
<script src="js/main.js"></script>

<?= $this->endSection() ?>