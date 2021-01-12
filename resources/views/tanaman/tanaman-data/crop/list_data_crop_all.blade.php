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
      List Data Tanaman Crop
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Data Tanaman</li>
        <li class="active">Data Tanaman Crop</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">    
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <label>Image ID = {{$data->imageID}}</label><br>
            <label>Data Milik = {{ $data->name }} - {{ $data->role }}</label>
            <a href="{{ URL::asset("images/{$data->ImageURL}") }}" data-toggle="lightbox" data-gallery="image-gallery">
          <img src="{{ URL::asset("images/{$data->ImageURL}") }}" width="150px" class="img-fluid">
        </a><br>
            <a href="{{ url('tanaman-data/index_all/') }}" class="btn btn-default">Kembali ke list data</a>
            <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>Cropped By</th>
                    <th>Perbaharui Label</th>
                    <th>Lihat Data</th>
                    <th>Hapus Data</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
            @foreach($data2 as $row => $value)
                <?php $no++ ;?>
                <tr>
                <td>{{ $no }}</td>
                    <td>
                    <a href="{{ URL::asset("upload/{$value->ImageURL}") }}" data-toggle="lightbox" data-gallery="image-gallery" data-title="{{ $value->plantType }}">
                    <img src="{{ URL::asset("upload/{$value->ImageURL}") }}" width="150px" class="img-fluid">
                    </a></td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->name }} - {{ $value->role }}</td>
                    <td>
                        <a href="{{ url('tanaman-data/crop/edit_all', $value->imageID) }}" class="btn btn-success btn-md" title="Ubah Data ini"><i class="fa fa-plus"></i> Perbaharui</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/crop/detail_all', $value->imageID) }}" class="btn btn-default btn-md" title="Lihat Data ini"><i class="fa fa-eye"></i> Lihat</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/crop/hapus_all', $value->imageID) }}" class="btn btn-danger btn-md" title="Hapus Data ini"><i class="fa fa-trash"></i> Hapus</a>
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
                    <th>Cropped By</th>
                    <th>Perbaharui Label</th>
                    <th>Lihat Data</th>
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


