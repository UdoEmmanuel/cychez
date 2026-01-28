<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Services Start -->
<div class="container-fluid services py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 800px;">
            <p class="fs-4 text-uppercase text-center text-primary">Our Service</p>
            <h1 class="display-3">Spa & Beauty Services</h1>
        </div>
        <div class="row g-4">
            <!-- Service 1: Skin Care -->
            <div class="col-12 col-md-6">
                <div class="services-item bg-light border-4 border-end border-primary rounded p-4">
                    <div class="row align-items-center flex-column flex-md-row">
                        <div class="col-12 col-md-8 order-2 order-md-1">
                            <div class="services-content text-center text-md-end">
                                <h3>Skin Care</h3>
                                <p>Radiant, even-toned skin with treatments for melanin-rich complexions. We address hyperpigmentation and dark spots using safe products for Nigerian skin.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 order-1 order-md-2 mb-3 mb-md-0">
                            <div class="services-img d-flex align-items-center justify-content-center rounded">
                                <img src="assets/images/services/service-1.jpg" class="img-fluid rounded" alt="Skin Care">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 2: Facials -->
            <div class="col-12 col-md-6">
                <div class="services-item bg-light border-4 border-start border-primary rounded p-4">
                    <div class="row align-items-center flex-column flex-md-row">
                        <div class="col-12 col-md-4 order-1 mb-3 mb-md-0">
                            <div class="services-img d-flex align-items-center justify-content-center rounded">
                                <img src="assets/images/services/service-2.jpg" class="img-fluid rounded" alt="Facials">
                            </div>
                        </div>
                        <div class="col-12 col-md-8 order-2">
                            <div class="services-content text-center text-md-start">
                                <h3>Facials</h3>
                                <p>Customized facial treatments for the Nigerian climate. From deep hydration for harmattan dryness to oil-control for humid weather.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3: Body Sculpting -->
            <div class="col-12 col-md-6">
                <div class="services-item bg-light border-4 border-start border-primary rounded p-4">
                    <div class="row align-items-center flex-column flex-md-row">
                        <div class="col-12 col-md-4 order-1 mb-3 mb-md-0">
                            <div class="services-img d-flex align-items-center justify-content-center rounded">
                                <img src="assets/images/services/service-3.jpg" class="img-fluid rounded" alt="Body Sculpting">
                            </div>
                        </div>
                        <div class="col-12 col-md-8 order-2">
                            <div class="services-content text-center text-md-start">
                                <h3>Body Sculpting</h3>
                                <p>Non-invasive body contouring for stubborn areas. Body wraps, firming treatments, and cellulite reduction to help you feel confident.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 4: Body Massage -->
            <div class="col-12 col-md-6">
                <div class="services-item bg-light border-4 border-end border-primary rounded p-4">
                    <div class="row align-items-center flex-column flex-md-row">
                        <div class="col-12 col-md-8 order-2 order-md-1">
                            <div class="services-content text-center text-md-end">
                                <h3>Body Massage</h3>
                                <p>Therapeutic massage services from traditional Nigerian techniques to Swedish and deep tissue. Relief from muscle aches and Lagos traffic stress.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 order-1 order-md-2 mb-3 mb-md-0">
                            <div class="services-img d-flex align-items-center justify-content-center rounded">
                                <img src="assets/images/services/service-4.jpg" class="img-fluid rounded" alt="Body Massage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->

<!-- Custom Mobile Styles -->
<style>
/* Mobile-First Responsive Styles */
@media (max-width: 767.98px) {
    /* Service Container Adjustments */
    .services.py-5 {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
    }
    
    .services .container.py-5 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }
    
    /* Header Adjustments */
    .services .mx-auto.mb-5 {
        margin-bottom: 2rem !important;
    }
    
    .services .display-3 {
        font-size: 1.75rem !important;
    }
    
    .services .fs-4 {
        font-size: 1rem !important;
    }
    
    /* Service Item Padding */
    .services-item {
        padding: 1rem !important;
    }
    
    /* Image Adjustments */
    .services-img {
        height: 150px !important;
        width: 100% !important;
        margin-bottom: 1rem !important;
    }
    
    .services-img img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }
    
    /* Content Adjustments */
    .services-content {
        text-align: center !important;
    }
    
    .services-content h3 {
        font-size: 1.25rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .services-content p {
        font-size: 0.875rem !important;
        line-height: 1.5 !important;
    }
    
    /* Gap Between Cards */
    .services .row.g-4 {
        row-gap: 1.5rem !important;
    }
}

/* Tablet Adjustments (768px to 991.98px) */
@media (min-width: 768px) and (max-width: 991.98px) {
    .services-item {
        padding: 1.5rem !important;
    }
    
    .services-content h3 {
        font-size: 1.5rem !important;
    }
    
    .services-content p {
        font-size: 0.9rem !important;
    }
    
    .services-img {
        height: 160px !important;
    }
}

/* Small Desktop (992px to 1199.98px) */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .services-content p {
        font-size: 0.95rem !important;
    }
}
</style>

<?= $this->endSection() ?>