@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Data Tanaman</li>
        <li class="active">Index</li></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">    
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Data Tanaman</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <a href="{{ url('admin-data/create') }}"><button type="button" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Tambah Data</button></a>
            <a href="{{ url('admin-data/cropping') }}"><button type="button" class="btn btn-success btn-md"><i class="fa fa-crop"></i> Crop Foto/Gambar</button></a><br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>General Ident</th>
                    <th>Status</th>
                    <th>Current Date</th>
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
                    <td><a data-toggle="lightbox" data-gallery="gallery" href="{{ URL::asset("images/{$value->ImageURL}") }}">
<img class="imggallery"src="{{ URL::asset("images/{$value->ImageURL}") }}"></a></td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->generalIdent }}</td>
                    <td>{{ $value->status }}</td>
                    <td>{{ $value->currentDate }}</td>
                    <td>{{ $value->ImageComment }}</td>
                    <td>
                        <a href="{{ url('admin-data/edit', $value->imageID) }}" class="btn btn-warning btn-md" title="Ubah Data ini"><i class="fa fa-edit"></i> Ubah</a>
                    </td>
                    <td>
                        <a href="{{ url('admin-data/hapus', $value->imageID) }}" class="btn btn-danger btn-md" title="Hapus Data ini"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>General Ident</th>
                    <th>Status</th>
                    <th>Current Date</th>
                    <th>Image Comment</th>
                    <th>Ubah Data</th>
                    <th>Hapus Data</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
</section>

@endsection


