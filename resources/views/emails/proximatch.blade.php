<div style="padding:20px">
    <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
            </td>
        </tr>
    </table>
    <h3 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Dear {{ $proximatch['name'] }},<h3>
    @if (isset($proximatch['quotation_amount']) && $proximatch['quotation_amount'] != '')
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">We are excited to provide you with a personalized quotation for our Proxima Match module, designed to
            help you find the best-suited schools based on your profile. We value your educational journey and
            believe that our services can greatly enhance your school selection process.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Quotation_amount : {{ $proximatch['quotation_amount'] }}</p>
        @if (!empty($proximatch['quotation_detail']))
            <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Quotation_detail : {{ $proximatch['quotation_detail'] }}</p>
        @endif
        <p style="text-align: left;">
            <a href="{{ env('APP_URL')."/en/proxima/checkout" }}" style="color: #b1040e; font-size: 16px; font-weight: 500; text-decoration: underline; display: inline-block;">Pay now</a>
        </p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">We understand that selecting the right educational path is important to you, and we want to provide
            you with all the necessary information to make an informed decision. Our Proxima Match module is
            built to empower you with the tools needed for a successful educational journey.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Should you have any questions or require further details about the quotation, please feel free to
            contact us. Your satisfaction and educational success are our priorities.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards,</p>
        <p style="margin: 0 0 10px; text-align: left;font-weight: 700; font-size: 16px; color: #000;">Proxima Study</p>
    @else
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Thank you for submitting your information on Proxima Study. We appreciate your interest in finding
            the
            best-matched schools based on your requirements.
        </p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">We have received your information and our team is working diligently to assist you in your search for
            the
            perfect school. We understand the importance of finding the right educational environment, and we
            will
            do our best to provide you with suitable options.
        </p>

        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Please note that it may take some time to review your information and gather relevant school
            recommendations. We kindly request your patience during this process. Rest assured, we will get back
            to
            you soon with personalized suggestions based on your preferences.</p>

        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Should you have any questions or need any further assistance, feel free to contact us at
            {{ isset($data['support_email']) ? $data['support_email'] : 'support@proximastudy.com' }}. Our team is here to help you.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Thank you again for choosing Proxima Study. We look forward to assisting you in finding the ideal
            school
            that meets your requirements.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards,</p>
        <p style="margin: 0 0 10px; text-align: left;font-weight: 700; font-size: 16px; color: #000;">Proxima Study</p>
    @endif

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
</div>
