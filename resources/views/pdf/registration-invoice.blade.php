<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Payment Invoice</title>
    <style>
        html {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body lang="en-US" dir="ltr">
    <div style="overflow: hidden; margin-top: 20px; width: 100%">
        <table style="width: 100%; padding-left: 20px;">
            <tbody>
                <tr>
                    <td style="vertical-align: text-top;">
                        <div style="margin-left: auto; margin-top: 0px;">
                            @if (isset($_GET['view']))
                                <img style="max-width: 100%; height:auto;" src="{{ asset('assets/images/canedu-black-logo.png') }}"
                                    width="200" height="35" border="0">
                            @else
                                <img style="max-width: 100%; height:auto;"
                                    src="{{ public_path('assets/images/canedu-black-logo.png') }}" width="200" height="35"
                                    border="0">
                            @endif
                            <div style="margin-top: 40px;">1051 Blvd Decarie</div>
                            <div style="margin-top: 4px;">P.O. Box: 53555 NORGATE</div>
                            <div style="margin-top: 4px;">Montreal - Qc.</div>
                            <div style="margin-top: 4px;">Canada</div>
                            <div style="margin-top: 4px;">Postal code: H4L 3M0</div>
                            <div style="margin-top: 4px;"><a
                                    href="mailto:info@xelentweb.org" style="text-decoration:none">info@xelentweb.org</a></div>
                            <div style="margin-top: 4px;"><a href="env('APP_URL')" style="text-decoration:none">{{ env('APP_URL') }}</a></div>
                        </div>
                    </td>
                    <td style="vertical-align: text-top;">
                        <div style="margin-top: 10px; text-align: right; ">
                            <div style="color:#b1040e; font-weight:600; font-size: 30px; line-height: 20px;">
                                Payment invoice
                            </div>
                            <div style="font-size: 18px; margin-top: 4px;">
                                <span style="font-weight:500;">Invoice # </span>{{ $data1['order']['invoice_no'] ?? '' }}
                            </div>
                            <div style="font-size: 18px; margin-top: 4px;">
                                
								<span style="font-weight:500;">Date: </span>{{ isset($data1['order']->created_at) ? date('F d, Y', strtotime($data1['order']->created_at)) : '' }}
                            </div>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        

        
    </div>
    <div
        style="margin-top: 40px; overflow: hidden; box-shadow:0px 3px 20px #0000000b; position: relative; border-radius: 5px; border-bottom-style:solid; border-color: transparent; background-color:rgba(255, 255, 255, 1);">
        <div style="padding-left:20px; padding-right:20px; padding-top: 20px; padding-bottom: 40px;">
            <div style="overflow-x:auto;">
				<table style="display: table; width:100%; border-collapse:collapse; text-indent:0; border: 1px solid #ccc; margin-bottom: 10px">
                    <tbody>
                        <tr>
                            <td
                                style="padding-top:8px; padding-bottom: 8px; border:1px solid #ccc; font-size: 16px; font-weight:500;  line-height:24px; text-align: center">
                                Customer name
                            </td>
                            <td
                                style="padding-top:8px; padding-bottom: 8px; border:1px solid #ccc; font-size: 16px; font-weight:500;  line-height:24px; text-align: center">
                                Customer email
                            </td>
                            <td
                                style="padding-top:8px; padding-bottom: 8px; border:1px solid #ccc; font-size: 16px; font-weight:500;  line-height:24px; text-align: center">
                                Payment method
                            </td>
                        </tr>
						<tr>
                            @php
                            $companyName = $data1['customer']['first_name'] ?? ''. ' '. $data1['customer']['last_name'];
                            @endphp
                            <td
                                style="padding-top: 8px; padding-bottom: 8px; border:1px solid #ccc; text-align:center;">
                                {{ $companyName }}
                            </td>
                            @php
                            $companyEmail = $data1['customer']->email ?? '';
                            @endphp
                            <td
                                style="padding-top: 8px; padding-bottom: 8px; border:1px solid #ccc; text-align:center;">
                                {{ $companyEmail }}
                            </td>
                            <td
                                style="padding-top: 8px; padding-bottom: 8px; border:1px solid #ccc; text-align:center;">
                                {{ isset($data1['order']->payment_method) ? $data1['customer']->payment_method : 'Free' }}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table style="display: table; width:100%; border-collapse:collapse; text-indent:0;">
                    <tbody>
						<tr>
                            <td
                                style="padding:8px; border: 1px solid #ccc; font-size: 16px; font-weight:500;  line-height:24px;">
                                Description
                            </td>
                            <td
                                style="padding:8px; border: 1px solid #ccc; font-size: 16px; font-weight:500;  line-height:24px; text-align: right">
                                Amount
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding:8px; border: 1px solid #ccc; font-size: 16px; line-height:24px;">
                                {{ $data1['package_name'] ?? '' }}
                            </td>
                            <td
                                style="padding: 8px; border: 1px solid #ccc; text-align:right;">
                                {{-- @if ($data1['payment_frequency'] == 'monthly') --}}
@php
$price = $data1['package_price'];
@endphp
{{-- @elseif($data1['payment_frequency'] == 'quarterly')
@php
$price = $data1['package_price']*3;
@endphp
@elseif($data1['payment_frequency'] == 'semi_annually')
@php
$price = $data1['package_price']*6;
@endphp
@elseif($data1['payment_frequency'] == 'annually')
@php
$price = $data1['package_price']*12;
@endphp @endif --}}
                                ${{ number_format(isset($price) ? $price : 0, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding:8px;
                                    border: 1px solid #ccc; color:#b1040e; font-weight:500; font-size: 18px;
                                    line-height:24px;">
                                    Sub total
                    </td>
                    <td
                        style="padding: 8px; border: 1px solid #ccc; font-size: 18px; font-weight:500; text-align:right;">
                        ${{ number_format(isset($price) ? $price : 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td
                        style="padding:8px; border: 1px solid #ccc; color:#b1040e; font-weight:500; font-size: 18px; line-height:24px;">
                        Total amount
                    </td>
                    <td
                        style="padding: 8px; border: 1px solid #ccc; font-size: 18px; font-weight:500; text-align:right;">
                        ${{ number_format(isset($price) ? $price : 0, 2) }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    </div>
    <div style="padding-left:20px; padding-right:20px; padding-bottom:20px; display: flex; flex-direction:row;">
        <div style="text-align: left; margin-top:0;">
            <div style="color: rgba(82, 82, 82, 1); font-size: 16px; line-height: 24px;">If you have any questions or
                concerns regarding this invoice, please do not hesitate to contact our dedicated customer support team
                at <a style="text-decoration:none" href="mailto:info@xelentweb.org">info@xelentweb.org</a>
                or <a style="text-decoration:none" href="tel:+18773333014">1-877-333-3014</a>. We are here to assist you
                with any inquiries you may have.

            </div>
        </div>
    </div>
    </div>
</body>

</html>
