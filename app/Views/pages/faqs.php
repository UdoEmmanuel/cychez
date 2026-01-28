<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-section">
            <div class="container-fluid custom-container">
                <div class="breadcrumb-wrapper text-center">
                    <h2 class="breadcrumb-wrapper__title">FAQ's</h2>
                    <ul class="breadcrumb-wrapper__items justify-content-center">
                        <li><a href="index.html">Home</a></li>
                        <li><span>FAQ's</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- FAQ's Start -->
        <div class="faq-section section-padding-2">
            <div class="container-fluid faq-container">
                <!-- FAQ's Wrapper Start -->
                <div class="faq-wrapper">
                    <!-- FAQ's Start -->
                    <div class="faq-accordion">
                        <h2 class="faq-accordion__title">
                            Shopping Information
                        </h2>

                        <div class="accordion">
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">
                                    <span class="text"
                                            >Delivery charges for orders from
                                            the Online Shop?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>

                                <div id="faqOne" class="accordion-collapse collapse">
                                    <p>
                                        Delivery charges are calculated based on your location and the weight of your order. The shipping cost will be automatically calculated and displayed at checkout before you complete your purchase. Different rates apply for local and international deliveries to ensure your cosmetic products arrive safely and in perfect condition.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">
                                    <span class="text"
                                            >How long will delivery take?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>

                                <div id="faqTwo" class="accordion-collapse collapse">
                                    <p>
                                        Delivery times vary depending on your location. Local deliveries typically take 3-5 business days, while international orders may take 7-14 business days. All orders are processed within 1-2 business days before shipping. You can track your order status through the tracking link provided in your user account dashboard.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">
                                    <span class="text"
                                            >What exactly happens after
                                            ordering?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>
                                <div id="faqThree" class="accordion-collapse collapse">
                                    <p>
                                        Once you place your order, you'll immediately receive a confirmation email with your order details and receipt. Our team will then carefully process and package your beauty products within 1-2 business days. When your package ships, your order details status will be updated accordingly. You can also check your order status anytime by logging into your account.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour">
                                    <span class="text"
                                            >Do I receive an invoice for my
                                            order?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>
                                <div id="faqFour" class="accordion-collapse collapse">
                                    <p>
                                        Yes, absolutely! A detailed invoice is automatically sent to your email address immediately after your purchase is confirmed. Any information you need regarding your order, including itemized costs, and shipping fees, will be clearly outlined in the invoice for your records.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ's End -->

                    <!-- FAQ's Start -->
                    <div class="faq-accordion">
                        <h2 class="faq-accordion__title">
                            Shopping Information
                        </h2>

                        <div class="accordion">
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqSeven">
                                    <span class="text"
                                            >What is wishlist?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>

                                <div id="faqSeven" class="accordion-collapse collapse">
                                    <p>
                                        A wishlist is your personal collection of favorite cosmetic products you'd like to purchase later. Simply click the heart icon on any product to save it to your wishlist. You can access your saved items anytime from your account, making it easy to keep track of products you love or want to try. It's perfect for planning future purchases or sharing gift ideas with friends and family.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqEight">
                                    <span class="text"
                                            >What should I do if I receive a
                                            damaged or wrong product?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>
                                <div id="faqEight" class="accordion-collapse collapse">
                                    <p>
                                        We sincerely apologize if this happens. Please contact our customer service team within 48 hours of receiving your order. Include photos of the damaged or incorrect item along with your order number. We'll immediately arrange for a replacement to be sent to you at no additional cost. Your satisfaction is our top priority.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqNine">
                                    <span class="text"
                                            >Can I change or cancel my
                                            order?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>
                                <div id="faqNine" class="accordion-collapse collapse">
                                    <p>
                                        We currently do not have an order cancellation or modification system in place. Once an order is placed, it is immediately processed to ensure quick delivery to you. We kindly advise all customers to carefully review their cart, shipping details, and product selections before completing their purchase. If you have any concerns about your order after checkout, please contact our customer service team and we'll do our best to assist you.
                                    </p>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTen">
                                    <span class="text"
                                            >What is "package tracking" in my
                                            orders?</span>
                                    <span class="icon"
                                            ><i
                                                class="lastudioicon-down-arrow"
                                            ></i
                                        ></span>
                                </button>
                                <div id="faqTen" class="accordion-collapse collapse">
                                    <p>
                                        Package tracking allows you to monitor your order's journey from our warehouse to your doorstep in real-time. Once your cosmetic products ship, you'll receive an email with a unique tracking number. You can also track your order through your account dashboard.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ's End -->

                    <!-- FAQ's Button Start -->
                    <div class="faq-button">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <!-- FAQ's Button Start -->
                                <a href="<?= base_url('contact')?>" class="faq-button__btn">Have more question ?</a>
                                <!-- FAQ's Button End -->
                            </div>
                        </div>
                    </div>
                    <!-- FAQ's Button End -->
                </div>
                <!-- FAQ's Wrapper End -->
            </div>
        </div>
        <!-- FAQ's End -->
    </main>

<?= $this->endSection() ?>