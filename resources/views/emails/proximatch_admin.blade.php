<div style="padding:20px">
    <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
            </td>
        </tr>
    </table>
    <h3 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">Dear Admin,<h3>
    @if (isset($proximatch['quotation_amount']) && $proximatch['quotation_amount'] != '')
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">We wanted to inform you that the quotation for the Proxima Match services has been successfully
            shared with the student, {{ $proximatch['name'] }}. The quotation details are as follows:</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Quotation_amount : {{ $proximatch['quotation_amount'] }}</p>
        @if (!empty($proximatch['quotation_detail']))
            <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Quotation_detail : {{ $proximatch['quotation_detail'] }}</p>
        @endif
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Please keep this in your records for future reference. If there are any further steps required or if
            you have any questions, please do not hesitate to reach out.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Thank you for your attention to this matter.</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards,</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Proxima Study</p>
    @else
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">A new student information form has been submitted on Proxima Study. Please find the details below:
        </p>

        <h1 style="margin: 0 0 24px; text-align: left; font-size: 24px; line-height: 24px; color: #000;">name : {{ $proximatch['name'] }}</h1>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Email : {{ $proximatch['email'] }}</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Phone : {{ $proximatch['phone'] }}</p>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Inquiry : {{ $proximatch['inquiry'] }}</p>

        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Kindly review the information and take appropriate action to assist the student in finding the
            best-matched schools based on their requirements. Please reach out to the student using the provided
            contact details to initiate further communication.</p>

        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Thank you for your attention to this matter.
        </p>

        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Best regards</p>

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
