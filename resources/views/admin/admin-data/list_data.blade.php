<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Data</title>
</head>
<body>
    <table>
        <thead>
            <tr>
               <th>No</th>
               <th>Plant Type</th>
               <th>Plant Organ</th>
               <th>General Ident</th>
               <th>Status</th>
               <th>Current Date</th>
               <th>Image URL</th>
               <th>Image Comment</th>
               <th>Ubah Data</th>
               <th>Hapus Data</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0;?>
            @foreach($data as $row => $value)
                <?php $no++ ;?>
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->generalIdent }}</td>
                    <td>{{ $value->status }}</td>
                    <td>{{ $value->currentDate }}</td>
                    <td>{{ $value->ImageURL }}</td>
                    <td>{{ $value->ImageComment }}</td>
                    <td>
                        <a href="{{ url('admin-data/edit', $value->imageID) }}" title="Ubah Data ini">Ubah</a>
                    </td>
                    <td>
                        <a href="{{ url('admin-data/hapus', $value->imageID) }}" title="Hapus Data ini">Hapus</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Plant Type</th>
                <th>Plant Organ</th>
                <th>General Ident</th>
                <th>Status</th>
                <th>Current Date</th>
                <th>Image URL</th>
                <th>Image Comment</th>
                <th>Ubah Data</th>
                <th>Hapus Data</th>
            </tr>
        </tfoot>
    </table>
    
</body>
</html>