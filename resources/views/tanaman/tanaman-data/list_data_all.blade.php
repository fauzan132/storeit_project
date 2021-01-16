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
              <h3 class="box-title">List Data Tanaman Semua Pengguna</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <a href="{{ url('tanaman-data/create') }}"><button type="button" class="btn btn-primary btn-flat btn-md"><i class="fa fa-plus"></i> Tambah Data</button></a><br><br>
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                  <div class="col-sm-3">
                    <label for="inputEmail3">Tampilkan Berdasarkan : </label>
                      <select class="form-control">
                        <option>- Pilih -</option>
                        <option>Plant Type</option>
                        <option>Plant Organ</option>
                        <option>Symptom Identification</option>
                      </select>
                  </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-10">
                  <button type="submit" class="btn bg-purple btn-flat"><i class="fa fa-eye"></i> Tampilkan</button>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Owner</th>
                    <th>Plant Type</th>
                    <th>Waktu Upload</th>
                    <th>Status</th>
                    <th>Crop Data</th>     
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
                    <td>{{ $value->name }} - {{ $value->role }}</td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->status }}</td>
                    <td>
                        <a href="{{ url('tanaman-data/crop/awal_all', $value->imageID) }}" class="btn bg-olive btn-flat" title="Lihat Hasil Crop Data ini"><i class="fa fa-eye"></i> Lihat Data Crop</a><br><br>
                        <a href="{{ url('tanaman-data/cropping_all', $value->imageID) }}" class="btn btn-primary btn-flat" title="Crop Data ini"><i class="fa fa-crop"></i> Crop Gambar</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/detail_all', $value->imageID) }}" class="btn bg-orange btn-flat" title="Lihat Data ini"><i class="fa fa-eye"></i> Lihat</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/hapus', $value->imageID) }}" class="btn bg-maroon btn-flat" onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" title="Hapus Data ini"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Owner</th>
                    <th>Plant Type</th>
                    <th>Waktu Upload</th>
                    <th>Status</th>
                    <th>Crop Data</th>
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


