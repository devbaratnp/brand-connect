<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; background: #0a0a0a; font-family: 'Instrument Sans', system-ui, sans-serif; color: #e5e5e5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background: #111111; border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #c9ff55 0%, #7c5cff 100%); padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #0a0a0a; letter-spacing: -0.02em;">Brand Connect</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em;">Reset Your Password</h2>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                Hello <strong style="color: #ffffff;">{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                We received a request to reset the password for your Brand Connect account. Click the button below to set a new password.
                            </p>
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="display: inline-block; background: #c9ff55; color: #0a0a0a; font-size: 15px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 10px; letter-spacing: 0.01em;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #666666;">
                                This link will expire in <strong style="color: #a0a0a0;">60 minutes</strong>.
                            </p>
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #666666;">
                                If you did not request a password reset, no further action is required. Your password will remain unchanged.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; border-top: 1px solid rgba(255,255,255,0.06); text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #555555;">
                                &copy; {{ date('Y') }} Brand Connect. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
