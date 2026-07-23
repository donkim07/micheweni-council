<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        h1 {
            color: #198754;
            border-bottom: 2px solid #198754;
            padding-bottom: 10px;
        }
        .info-section {
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-content {
            margin-bottom: 10px;
        }
        .message-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eee;
            white-space: pre-line;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>New Contact Form Submission</h1>
        
        <div class="info-section">
            <div class="info-content">
                <span class="info-label">Name:</span> {{ $data['name'] }}
            </div>
            
            <div class="info-content">
                <span class="info-label">Email:</span> {{ $data['email'] }}
            </div>
            
            @if(!empty($data['phone']))
            <div class="info-content">
                <span class="info-label">Phone:</span> {{ $data['phone'] }}
            </div>
            @endif
            
            <div class="info-content">
                <span class="info-label">Subject:</span> {{ $data['subject'] }}
            </div>
        </div>
        
        <h3>Message:</h3>
        <div class="message-content">
            {{ $data['message'] }}
        </div>
        
        <div class="footer">
            <p>This email was sent from the contact form on Micheweni Waste Portal website.</p>
            <p>{{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html> 