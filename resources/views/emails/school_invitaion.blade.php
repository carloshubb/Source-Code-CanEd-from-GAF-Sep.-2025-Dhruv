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
    <h1 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Dear {{$emailData['first_name']}} {{ $emailData['last_name']}}</h1>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">I hope this email finds you well.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Congratulations on your outstanding academic achievements! On behalf of [University Name], it is our pleasure to extend a formal invitation for you to join our prestigious institution.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">At [University Name], we are committed to fostering a dynamic learning environment that cultivates intellectual growth, critical thinking, and personal development. With our state-of-the-art facilities, world-class faculty, and diverse student community, we offer a remarkable platform to shape your future and unleash your potential.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">We wholeheartedly believe that [University Name] is the perfect destination to nurture your talents, expand your horizons, and shape your future. We invite you to join us on this transformative journey of knowledge and discovery.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Please confirm your acceptance. We eagerly look forward to welcoming you as a valued member of the [University Name] family.</p>
    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">If you have any questions or require further information, please do not hesitate to reach out to our admissions office at [contact information].</p>
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
                            <p style="margin: 0; white-space: nowrap; padding-left: 8px; padding-right: 8px; font-size: 16px; color: #000">©2025 Proxima Study. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
