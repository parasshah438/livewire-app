<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .field {
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 4px;
            border-left: 4px solid #667eea;
        }
        .label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .footer {
            background: #333;
            color: white;
            padding: 15px;
            border-radius: 0 0 8px 8px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Message</h2>
        <p>You have received a new message through your website contact form.</p>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div>{{ $name }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email:</div>
            <div>{{ $email }}</div>
        </div>
        
        @if($phone)
        <div class="field">
            <div class="label">Phone:</div>
            <div>{{ $phone }}</div>
        </div>
        @endif
        
        <div class="field">
            <div class="label">Subject:</div>
            <div>{{ $subject }}</div>
        </div>
        
        <div class="field">
            <div class="label">Message:</div>
            <div>{{ nl2br(e($message)) }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This message was sent from {{ config('app.name') }} contact form on {{ date('F j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>