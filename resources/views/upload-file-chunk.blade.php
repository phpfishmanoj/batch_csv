<form action="/upload-file-chunk" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csvFile" id="csvFile"> <br/>
    <input type="submit" value="Upload">
</form>