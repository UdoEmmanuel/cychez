<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Term Of Use</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Term Of Use</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Term Of Use Start -->
    <div class="term-use-section section-padding-2">
        <div class="container-fluid faq-container">
            <!-- Term Of Use Wrapper Start -->
            <div class="term-use-wrapper">
                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Payment Policy</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. All prices on our website are displayed in Nigerian Naira (₦) and are subject to change without prior notice.
                        </li>
                        <li>
                            02. Payments can be made using debit cards, bank transfers, and other payment methods made available on our checkout page.
                        </li>
                        <li>
                            03. Orders will only be processed after full payment has been successfully received and confirmed.
                        </li>
                        <li>
                            04. In the event of a failed or reversed payment, the order will not be processed.
                        </li>
                        <li>
                            05. We do not store your card or payment details. All transactions are securely handled by our payment service providers.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->

                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Shipping & Delivery Policy</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. We currently deliver within Nigeria. Delivery timelines may vary based on your location.
                        </li>
                        <li>
                            02. Orders are typically processed within 1–3 business days, excluding weekends and public holidays.
                        </li>
                        <li>
                            03. Delivery timeframes provided at checkout are estimates and not guaranteed.
                        </li>
                        <li>
                            04. Once an order has been handed over to the delivery partner, we are not responsible for delays caused by logistics providers, weather conditions, strikes, or other unforeseen circumstances.
                        </li>
                        <li>
                            05. Customers are responsible for providing accurate delivery information. We will not be liable for failed deliveries due to incorrect or incomplete addresses.
                        </li>
                        <li>
                            06. Risk of loss passes to the customer once the order has been successfully delivered.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->

                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Returns, Refunds & Exchange Policy</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. Due to the nature of cosmetic and personal care products, we do not accept returns or exchanges on opened or used items.
                        </li>
                        <li>
                            02. Returns or exchanges may only be considered if the item received is damaged, defective, or incorrect.
                        </li>
                        <li>
                            03. Any issue must be reported within 48 hours of delivery, along with clear photo or video evidence.
                        </li>
                        <li>
                            04. Items approved for return must be unused, sealed, and in their original packaging.
                        </li>
                        <li>
                            05. Refunds (where applicable) will be processed to the original payment method after inspection.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->

                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Product Use & Disclaimer</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. Our products are for external use only unless stated otherwise.
                        </li>
                        <li>
                            02. Customers are advised to carefully read product descriptions, ingredients, and usage instructions before purchase.
                        </li>
                        <li>
                            03. We recommend conducting a patch test before full application of any cosmetic product.
                        </li>
                        <li>
                            04. We are not responsible for allergic reactions, skin sensitivities, or adverse effects resulting from product use.
                        </li>
                        <li>
                            05. If irritation occurs, discontinue use immediately and consult a qualified medical professional.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->

                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Limitation of Liability</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. We shall not be held liable for any indirect, incidental, or consequential damages arising from the use or inability to use our products or services.
                        </li>
                        <li>
                            02. Our total liability shall not exceed the value of the product purchased.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->
                <!-- Term Of Use Item Start -->
                <div class="term-use-item">
                    <h3 class="term-use-item__title">Contact & Support</h3>
                    <ul class="term-use-item__list">
                        <li>
                            01. For questions, complaints, or support, please contact us via the details provided on our <a href="<?= base_url('contact') ?>" class="text-decoration-underline">
                                Contact page
                            </a>.
                        </li>
                        <li>
                            02. We aim to respond to all inquiries within 24–48 business hours.
                        </li>
                    </ul>
                </div>
                <!-- Term Of Use Item End -->

                <p class="mt-4" style="font-weight: bold;">
                    By using this website and placing an order, you agree to these Terms of Use.
                </p>
            </div>
            <!-- Term Of Use Wrapper End -->
        </div>
    </div>
    <!-- Term Of Use End -->
</main>

<?= $this->endSection() ?>