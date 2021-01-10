@extends('layouts.layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
</style>
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
            <a href="{{ url('admin-data/create') }}"><button type="button" class="btn btn-primary btn-flat btn-md"><i class="fa fa-plus"></i> Tambah Data</button></a><br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>General Ident</th>
                    <th>Cropping Data</th>
                    <th>Lihat Metadata</th>
                    <th>Hapus Data</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
            @foreach($data as $row => $value)
                <?php $no++ ;?>
                <tr>
                <td>{{ $no }}</td>
                    <td><a href="{{ URL::asset("images/{$value->ImageURL}") }}" data-toggle="lightbox" data-gallery="image-gallery" data-title="Flower">
          <img src="{{ URL::asset("images/{$value->ImageURL}") }}" width="150px" class="img-fluid">
        </a></td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->generalIdent }}</td>
                    <td>
                        <a href="{{ url('admin-data/crop/awal', $value->imageID) }}" class="btn bg-navy btn-flat" title="Lihat Data Crop"><i class="fa fa-eye"></i> Lihat Data Crop</a><br><br>
                        <a href="{{ url('admin-data/cropping', $value->imageID) }}" class="btn bg-olive btn-flat" title="Crop Gambar ini"><i class="fa fa-crop"></i> Crop Gambar</a>
                    </td>
                    <td>
                        <a href="{{ url('admin-data/detail', $value->imageID) }}" class="btn bg-orange btn-flat" title="Lihat Data ini"><i class="fa fa-eye"></i> Lihat</a>
                    </td>
                    <td>
                        <a href="{{ url('admin-data/hapus', $value->imageID) }}" class="btn bg-maroon btn-flat" title="Hapus Data ini"><i class="fa fa-trash"></i> Hapus</a>
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
                    <th>Cropping Data</th>
                    <th>Lihat Metadata</th>
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


