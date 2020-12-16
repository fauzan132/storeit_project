<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Data</title>
</head>
<body>
    <form  method="POST" action="{{ url('admin-data/simpan') }}">
        {{ csrf_field() }}
        <label>Plant Type</label>
        <input type="text" name="planttype">
        <label>Plant Organ</label>
        <input type="text" name="plantorgan">
        <label>General Ident</label>
        <input type="text" name="generalident">
        <label>Status</label>
        <input type="text" name="status">
        <label>Image URL</label>
        <input type="text" name="imageurl">
        <label>Image Comment</label>
        <input type="text" name="imagecomment">
 
        <a href="{{ url('admin-data/index/') }}">Batal</a>
        <button type="submit">Simpan</button>

    </form>    
</body>
</html>