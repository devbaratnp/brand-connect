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
                            <h2 style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #ffffff;">New application received!</h2>
                            <p style="margin: 0 0 16px; font-size: 15px; line-height: 1.6; color: #a0a0a0;">
                                <strong style="color: #ffffff;">{{ $application->creator->name }}</strong> has applied to your campaign
                                <strong style="color: #c9ff55;">"{{ $campaign->title }}"</strong>.
                            </p>
                            @if($application->message)
                                <div style="background: #1a1a1a; border-left: 3px solid #7c5cff; padding: 16px 20px; border-radius: 0 8px 8px 0; margin: 0 0 24px;">
                                    <p style="margin: 0; font-size: 14px; color: #888888; margin-bottom: 4px;">Application message:</p>
                                    <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #cccccc; font-style: italic;">
                                        "{{ Str::limit(strip_tags($application->message), 200) }}"
                                    </p>
                                </div>
                            @endif
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('brand.applications', $campaign->id) }}" style="display: inline-block; background: #c9ff55; color: #0a0a0a; font-size: 15px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 10px;">
                                            Review Application
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #666666;">
                                You can accept or reject this application from your campaign dashboard.
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
