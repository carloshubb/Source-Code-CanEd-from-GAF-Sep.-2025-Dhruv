<!DOCTYPE html>
<html>

<head>
    <title>You have an invitaion email</title>
</head>

<body>
    <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
            </td>
        </tr>
    </table>
    {{-- <h1 style="margin: 10px 0; text-align: center; font-size: 24px; line-height: 24px; color: #000;">Dear {{ $emailData['open_house'] }}</h1> --}}
    <h4 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Dear {{ $emailData['visitor_name'] }}</h4>
    {{-- <p style="margin: 0 0 10px; text-align: center; font-size: 16px; color: #000;">We hope this email finds you well. We are reaching out to inform you that a potential customer has submitted an
        inquiry through our website. They are interested in your Open house and have a query that requires your attention.
    </p> --}}
    <p style="text-align: left;">
        <h3 style="margin: 16px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Message details</h3>
    </p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Name:{{ $emailData['visitor_name'] }}.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Email:{{ $emailData['visitor_email'] }}.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Message: {{ $emailData['visitor_message'] }}.</p>


    {{-- <p style="margin: 0 0 10px; text-align: center; font-size: 16px; color: #000;">We kindly request you to respond to the customer's inquiry as soon as possible. Providing a prompt and helpful
        response will greatly enhance your chances of engaging with the customer and potentially securing their
        open house.

        If you have any questions or require any assistance, please feel free to reach out to us at
        {{ isset($data['support_email']) ? $data['support_email'] : 'support@proximastudy.com' }}. We are here to support you in connecting with potential customers and growing your
        open house.

        Thank you for being a valued partner on our platform. We appreciate your prompt attention to this inquiry.
    </p> --}}
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">
        Thank you and have a great day
    </p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards</p>

    <p style="margin: 0 0 10px; text-align: left;font-weight: 700; font-size: 16px; color: #000;">The Proxima Study Team</p>

    <table style="width: 100%;margin-top: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td class="sm-px-6" style="background-color: #f3f4f6; padding: 16px 48px; text-align: left; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05)">
                {{-- <table style="margin-left: auto; margin-right: auto; margin-bottom: 8px" cellpadding="0" cellspacing="0" role="none">
                    <tr>
                        <td>
                            <img src="{{ asset('assets/images/canedu-black-logo.png') }}" alt="Canedu Logo" style="max-width: 100%; vertical-align: middle; margin-left: auto; margin-right: auto; width: 192px">
                        </td>
                    </tr>
                </table> --}}
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
</body>

</html>
