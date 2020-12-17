<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data</title>
</head>
<body>
<form  method="POST" action="{{ url('admin-data/simpan-test',$data['imageID']) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label>Image ID</label>
        <input type="text" name="imageid" value="{{ $data['imageID'] }}" disabled>
        <label>Plant Type</label>
        <input type="text" name="planttype" value="{{ $data['plantType'] }}">
        <label>Plant Organ</label>
        <input type="text" name="plantorgan" value="{{ $data['plantOrgan'] }}">
        <label>General Ident</label>
        <input type="text" name="generalident" value="{{ $data['generalIdent'] }}">
        <label>Status</label>
        <input type="text" name="status" value="{{ $data['status'] }}">
        <label>Image URL</label>
        <img src="{{ url($data['ImageURL']) }}" width="150px">
        <input type="hidden" name="tmp_image" value="{{ $data['ImageURL'] }}">
        <label>Image Comment</label>
        <input type="text" name="imagecomment" value="{{ $data['ImageComment'] }}">
 
        <a href="{{ url('admin-data/index/') }}">Batal</a>
        <button type="submit">Simpan</button>
    </form>   
    
</body>
</html>