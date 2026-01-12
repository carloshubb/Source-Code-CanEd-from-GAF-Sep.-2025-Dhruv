<form action="/upload-businesses" method="POST" enctype="multipart/form-data">
    @csrf
    <input name="excel_file" type="file" id="fileUpload" accept=".xls,.xlsx" /><br />
    <button type="submit" id="uploadExcel">Convert</button>
</form>
