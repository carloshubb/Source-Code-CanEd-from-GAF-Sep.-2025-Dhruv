<div style="padding: 20px; background-color: #f4f4f4; border: 1px solid #ccc; font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto;">
    <h2 style="color: #333; font-size: 24px;">Receipt from Proxima Study</h2>
    <p style="font-size: 16px;">Dear {{ $proximatch['name'] }},</p>

    <p style="font-size: 16px;">Thank you for choosing Proxima Study. Below, you'll find the details of your recent transaction:</p>

    @if (isset($proximatch['quotation_amount']) && $proximatch['quotation_amount'] != '')
        <p style="font-size: 16px;">Transaction Date: {{ now()->toFormattedDateString() }}</p>
        <p style="font-size: 16px;">Service: Proxima Match Module</p>
        <p style="font-size: 16px;">Quotation Amount: {{ $proximatch['quotation_amount'] }}</p>
        @if (!empty($proximatch['quotation_detail']))
            <p style="font-size: 16px;">Quotation Details: {{ $proximatch['quotation_detail'] }}</p>
        @endif

        <p style="font-size: 16px;">If you have any questions or need further assistance regarding this transaction, please don't hesitate to contact us at {{ isset($data['support_email']) ? $data['support_email'] : 'support@proximastudy.com' }}.</p>
    @else
        <p style="font-size: 16px;">Your submission has been received and our team is working to assist you in finding the best-matched schools based on your requirements.</p>

        <p style="font-size: 16px;">Please note that it may take some time to review your information and gather relevant school recommendations. We kindly request your patience during this process. Rest assured, we will get back to you soon with personalized suggestions based on your preferences.</p>

        <p style="font-size: 16px;">If you have any questions or need any further assistance, feel free to contact us at {{ isset($data['support_email']) ? $data['support_email'] : 'support@proximastudy.com' }}. Our team is here to help you.</p>
    @endif

    <p style="font-size: 16px;">Thank you again for choosing Proxima Study. We look forward to assisting you in finding the ideal school that meets your requirements.</p>

    <p style="font-size: 16px; color: #777;">Best regards,<br>Proxima Study</p>
</div>

