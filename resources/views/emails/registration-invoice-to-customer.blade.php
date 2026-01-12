<div style="padding:20px">
    <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 100%; padding: 0; margin: 0;">
                <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
            </td>
        </tr>
    </table>

    @if (!empty($data1['customer']['school']) && !empty($data1['customer']['school']['schoolDetail']))
        <h2 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">
            Dear {{$data1['customer']['school']['schoolDetail'][0]['school_name']}},
        </h2>
    @else
        <h3 style="margin: 10px 0; text-align: left; font-size: 24px; line-height: 24px; color: #000;">
            Dear {{$data1['customer']['first_name']}} {{$data1['customer']['last_name']}},
        </h3>
    @endif

    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">

        This is the receipt for your transaction on Proxima Study. We recommend you save this email or print it out for your records    </p>

    {{-- <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">
        If you have any questions or concerns regarding this invoice or your subscription, feel free to reach out to our support team at support@xelentweb.com.
    </p> --}}

    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">
Payment Details:
    </p>

    @php
        $price = $data1['package_price'];
    @endphp
    {{-- @if($data1['payment_frequency'] == 'monthly')
        @php
            $payment_frequency = 'Monthly';
            $price = $data1['package_price'];
        @endphp
    @elseif($data1['payment_frequency'] == 'quarterly')
        @php
            $payment_frequency = 'Quarterly';
            $price = $data1['package_price']*3;
        @endphp
    @elseif($data1['payment_frequency'] == 'semi_annually')
        @php
            $payment_frequency = 'Semi annually';
            $price = $data1['package_price']*6;
        @endphp
    @elseif($data1['payment_frequency'] == 'annually')
        @php
            $payment_frequency = 'Annually';
            $price = $data1['package_price']*12;
        @endphp
    @endif --}}

    <ul style="text-align: left;color:#000; margin: 16px 0;">
        @if(isset($data1['invoice_no']))
            <li><strong>Invoice #:</strong> {{$data1['invoice_no']}}</li>
        @endif
        <li><strong>Transaction:</strong> {{$data1['customer']['user_type']}} Profile Registration</li>
        {{-- <li><strong>Package name:</strong> {{$data1['package_name']}}</li> --}}
        {{-- <li><strong>Payment frequency:</strong> {{ $payment_frequency }}</li> --}}
        <li><strong>Amount:</strong> ${{ number_format((isset($price) ? $price : 0), 2) }}</li>
        <li><strong>Package validity:</strong> {{date('F d, Y', strtotime($data1['package_expiry_date']))}}</li>
    </ul>

    <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">Thank you,</p>
    <p style="margin: 0 0 10px; text-align: left;font-weight:700; font-size: 16px; color: #000;">Proxima Study Team</p>

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
</div>