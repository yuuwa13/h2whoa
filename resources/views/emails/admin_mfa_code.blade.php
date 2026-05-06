<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H2WHOA Admin Login Code</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 40px 20px; }
        .card { background: #fff; max-width: 480px; margin: 0 auto; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .header { background: #1a1a2e; padding: 28px 36px; }
        .header h1 { color: #fff; font-size: 1.2rem; margin: 0; letter-spacing: .04em; }
        .header span { color: #4ac9b0; }
        .body { padding: 36px; }
        .body p { color: #555; font-size: .92rem; line-height: 1.7; margin: 0 0 20px; }
        .otp-box { background: #f4f6f9; border: 2px dashed #4ac9b0; border-radius: 10px; text-align: center; padding: 20px; margin: 24px 0; }
        .otp-box .code { font-size: 2.4rem; font-weight: 700; letter-spacing: .3em; color: #1a1a2e; font-family: 'Courier New', monospace; }
        .otp-box .expiry { font-size: .78rem; color: #999; margin-top: 8px; }
        .footer { background: #f9fafb; padding: 18px 36px; border-top: 1px solid #f0f0f0; }
        .footer p { color: #aaa; font-size: .75rem; margin: 0; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1><span>H2WHOA</span> — Admin Access</h1>
        </div>
        <div class="body">
            <p>A login attempt was made to the H2WHOA admin panel. Use the code below to complete sign-in.</p>
            <div class="otp-box">
                <div class="code">{{ $otp }}</div>
                <div class="expiry">Expires in 10 minutes</div>
            </div>
            <p>If you did not attempt to log in, your admin credentials may be compromised. Change your password immediately.</p>
        </div>
        <div class="footer">
            <p>This is an automated security email from H2WHOA. Do not share this code with anyone.</p>
        </div>
    </div>
</body>
</html>
