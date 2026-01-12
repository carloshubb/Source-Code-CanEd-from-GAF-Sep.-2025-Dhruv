<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoho OAuth Popup</title>
    <script>
         var zohoAuthUrl = "{{ isset($authUrl) ? $authUrl : '' }}";
        if(zohoAuthUrl == ''){
            window.opener.postMessage("Event from child", "*");
            window.close();
        }
    </script>
</head>

<body>
</body>

</html>
