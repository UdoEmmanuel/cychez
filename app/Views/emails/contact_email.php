<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }
        .email-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .email-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .info-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .info-value {
            color: #333;
        }
        .message-section {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .message-section h3 {
            margin-top: 0;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- LOGO HEADER -->
        <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #007bff;">
            <img src="<?= base_url('assets/images/Logo-modified.jpg') ?>" 
                 alt="Cychez Store" 
                 style="max-width: 200px; height: auto; display: block; margin: 0 auto;">
            <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
                Premium Products, Delivered with Care
            </p>
        </div>
        
        <div class="email-header">
            <h2>New Contact Form Submission</h2>
        </div>

        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value"><?= esc($first_name) ?> <?= esc($last_name) ?></span>
        </div>

        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value"><a href="mailto:<?= esc($email) ?>"><?= esc($email) ?></a></span>
        </div>

        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value"><a href="tel:<?= esc($phone) ?>"><?= esc($phone) ?></a></span>
        </div>

        <div class="info-row">
            <span class="info-label">Subject:</span>
            <span class="info-value"><?= esc($subject) ?></span>
        </div>

        <div class="message-section">
            <h3>Message:</h3>
            <p><?= nl2br(esc($message)) ?></p>
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
            <p>This email was sent from the contact form on your website.</p>
            <p>Submitted on: <?= date('F j, Y, g:i a') ?></p>
        </div>
    </div>
</body>
</html>