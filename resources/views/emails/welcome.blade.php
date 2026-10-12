<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background: #0a0a0a; font-family: 'Instrument Sans', system-ui, sans-serif; color: #e5e5e5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background: #111111; border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; overflow: hidden;">
                    <tr>
                        <td style="background: linear-gradient(135deg, #c9ff55 0%, #7c5cff 100%); padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #0a0a0a; letter-spacing: -0.02em;">Brand Connect</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #ffffff;">Welcome, {{ $user->name }}!</h2>
                            <p style="margin: 0 0 16px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                Your account has been created successfully as a <strong style="color: #c9ff55;">{{ ucfirst($user->role) }}</strong>.
                            </p>
                            @if($user->isCreator())
                                <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                    You can now start browsing campaigns and applying for collaborations with top brands.
                                </p>
                            @else
                                <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                    You can now start creating campaigns and finding the perfect creators for your brand.
                                </p>
                            @endif
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('dashboard') }}" style="display: inline-block; background: #c9ff55; color: #0a0a0a; font-size: 15px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 10px;">
                                            Go to Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #666666;">
                                Complete your profile to get the best experience on Brand Connect.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 40px; border-top: 1px solid rgba(255,255,255,0.06); text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #555555;">&copy; {{ date('Y') }} Brand Connect. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
