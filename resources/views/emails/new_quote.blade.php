<div style="padding:20px">
    <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
            </td>
        </tr>
    </table>
    <h3 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Dear Admin,<h3>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">The user “{{ $emailData['customer'] }}” has created a new quote on Proxima Study on {{ now()->format('l F d, Y') }}. As of now, its status is active.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">To review and update this quote, follow this link:</p>
    @isset($emailData['record']['id'])
        <p style="text-align: left;margin: 16px 0;color: #000;">URL: <a style="margin-left: 12px; border-radius: 4px; background-color: #b1040e; padding: 12px 24px; font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; display: inline-block;" href="{{ env('APP_URL') . '/admin/'.$emailData['record_url'].'/'.$emailData['record']['id'] . '/edit' }}">View Record</a></p>
    @endisset
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards</p>
    <p style="margin: 0 0 10px; text-align: left;font-weight: 700; font-size: 16px; color: #000;">Proxima Study Team</p>

    <table style="width: 100%;margin-top: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td class="sm-px-6" style="background-color: #f3f4f6; padding: 16px 48px; text-align: left; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05)">
                <table style="margin-bottom: 24px; margin-top: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
                    <tr>
                        <td align="center" style="display: flex;">
                            <div style="display: flex; margin: 0 auto;">
                                <a aria-label="Proxima Study" target="_blank" href="https://facebook.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                    <img src="{{ asset('assets/images/facebook.png') }}" alt="facebook icon" style="max-width: 100%; vertical-align: middle; height: 20px;margin-top: 10px;margin-left: 13px;">
                                </a>
                                <a aria-label="Proxima Study" target="_blank" href="https://twitter.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                    <img src="{{ asset('assets/images/twitter.png') }}" alt="twiiter icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 11px;margin-left: 10px;">
                                </a>
                                <a aria-label="Proxima Study" target="_blank" href="https://www.instagram.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                    <img src="{{ asset('assets/images/instagram.png') }}" alt="google icon" style="max-width: 100%; vertical-align: middle; height: 20px;margin-top: 9px;margin-left: 9px;">
                                </a>
                                <a aria-label="Proxima Study" target="_blank" href="https://youtube.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                    <img src="{{ asset('assets/images/youtube.png') }}" alt="youtube icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 11px;margin-left: 8px;">
                                </a>
                                <a aria-label="Proxima Study" target="_blank" href="https://www.linkedin.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;">
                                    <img src="{{ asset('assets/images/linkedin.png') }}" alt="linkedin icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 10px;margin-left: 12px;">
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="margin: 8px auto" cellpadding="0" cellspacing="0" role="none">
                    <tr>
                        <td>
                            <p style="margin: 0; white-space: nowrap; padding-left: 8px; padding-right: 8px; font-size: 16px; color: #000;">©2025 Proxima Study. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>