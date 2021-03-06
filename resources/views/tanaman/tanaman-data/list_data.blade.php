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
            <br>
            @if(session('success'))
                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">x</button>
              {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">x</button>
              {{ session('error') }}
                </div>
            @endif
            <br>
            <a href="{{ url('tanaman-data/create') }}"><button type="button" class="btn btn-primary btn-flat btn-md"><i class="fa fa-plus"></i> Tambah Data</button></a><br><br>
            <h4>Filter Data :</h4>
             <!-- form start -->
             <form class="form-horizontal" method="GET" action="{{ url('tanaman-data/cari') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                  <div class="col-sm-3">
                  <label for="inputEmail3">Pilih Plant Type : </label>
                    <select class="form-control" id="planttype" name="planttype">
                      <option>- Pilih -</option>
                      <option>Chilli</option>
                      <option>Tomato</option>
                      <option>Other</option>
                    </select>
                    <br>
                    <label for="inputEmail3">Pilih Status : </label>
                    <select class="form-control" id="status" name="status">
                      <option>- Pilih -</option>
                      <option>Uncropped & Unverified</option>
                      <option>Uncropped & Verified</option>
                      <option>Cropped & Unverified</option>
                      <option>Cropped & Verified</option>
                      <option>Reject</option>
                    </select>
                </div>
                <div class="col-sm-3">
                  <label for="inputEmail3">Pilih Plant Organ : </label>
                    <select class="form-control" id="plantorgan" name="plantorgan">
                      <option>- Pilih -</option>
                      <option>Fruit</option>
                      <option>Flower</option>
                      <option>Leaf</option>
                      <option>Stem</option>
                      <option>Root</option>
                      <option>Other</option>
                    </select>
                </div>
                <div class="col-sm-3">
                  <label for="inputEmail3">Pilih Symptom Identification : </label>
                  @if(Auth::user()->role == "Admin" || Auth::user()->role == "Expert ITB" || Auth::user()->role == "Cropper")
                    <select class="form-control" id="generalident" name="generalident">
                      <option>- Pilih -</option>
                      <option>Pest</option>
                      <option>Disease</option>
                      <option>Nutrient</option>
                      <option>Healthy</option>
                      <option>Other</option>
                    </select>
                  @elseif(Auth::user()->role == "Expert EWINDO")
                    <select class="form-control" id="generalident" name="generalident">
                      <option>Disease</option>
                    </select>
                  @elseif(Auth::user()->role == "Expert BALITSA")
                    <select class="form-control" id="generalident" name="generalident">
                      <option>Pest</option>
                    </select>
                  @endif
                </div>
                <div class="col-sm-3">
                  <label for="inputEmail3">Pilih Symptom Name : </label>
                    <select class="form-control" id="symptomname" name="symptomname">
                      <option>- Pilih -</option>
                      <option>Aphid</option>
                      <option>Lalat buah</option>
                      <option>Ulat grayak</option>
                      <option>Tungau</option>
                      <option>Thrips</option>
                      <option>Whitefly</option>
                      <option>Ulat buah</option>
                      <option>Antraknose</option>
                      <option>Bacterial spot</option>
                      <option>Bacterial wilt</option>
                      <option>Phytophthora blight</option>
                      <option>Yellow leaf curl virus</option>
                      <option>Late blight</option>
                      <option>Early blight</option>
                      <option>Undernutrition</option>
                      <option>Overnutrition</option>
                      <option>Healthy</option>
                      <option>Other</option>                      
                    </select>
                  </div>
                    <div class="col-sm-2">
                    <br>
                      <button type="submit" class="btn bg-purple btn-flat"><i class="fa fa-eye"></i> Tampilkan</button>
                    </div>
                    <div class="col-sm-2">
                    <br>
                      <a href="{{ url('tanaman-data/index') }}" class="btn bg-green btn-flat" title="Reset Pencarian"><i class="fa fa-check"></i> Reset</a>
                    </div>
                </div>
            </form>
            <div style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>Symptom Identification</th>
                    <th>Symptom Name</th>
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
                    <td><a href="{{ $value->ImageURL }}" data-toggle="lightbox" data-gallery="image-gallery" data-title="Flower">
          <img src="{{ $value->ImageURL }}" width="150px" class="img-fluid">
        </a></td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->generalIdent }}</td>
                    <td>{{ $value->symptomName }}</td>
                    <td>
                        <a href="{{ url('tanaman-data/crop/awal', $value->imageID) }}" class="btn bg-olive btn-flat" title="Lihat Data Crop"><i class="fa fa-eye"></i> Lihat Data Crop</a><br><br>
                        <a href="{{ url('tanaman-data/cropping', $value->imageID) }}" class="btn btn-primary btn-flat" title="Crop Gambar ini"><i class="fa fa-crop"></i> Crop Gambar</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/detail', $value->imageID) }}" class="btn bg-orange btn-flat" title="Lihat Data ini"><i class="fa fa-eye"></i> Lihat</a>
                    </td>
                    <td>
                        <a href="{{ url('tanaman-data/hapus', $value->imageID) }}" class="btn bg-maroon btn-flat"  onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" title="Hapus Data ini"><i class="fa fa-trash"></i> Hapus</a>
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
                    <th>Symptom Identification</th>
                    <th>Symptom Name</th>
                    <th>Crop Data</th>     
                    <th>Lihat Metadata</th>
                    <th>Hapus Data</th>
                </tr>
                </tfoot>
              </table>
              </div>
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


