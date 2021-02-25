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
      Data Statistik / Laporan
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Data Statistik / Laporan</li>
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
              <h3 class="box-title">Statistik / Laporan Data Tanaman</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <h4>Filter Data :</h4>
             <!-- form start -->
             <form class="form-horizontal" method="GET" action="{{ url('tanaman-data/cari-statistik') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                  <div class="col-sm-3">
                  <label for="inputEmail3">Pilih User : </label>
                    <select class="form-control" id="pengguna" name="pengguna">
                      @if(Auth::user()->role == 'Admin')
                        <option>- Pilih -</option>
                        @foreach($user as $row)
                          <option value="{{ $row->id}}"> {{ $row->role }} - {{ $row->name }}</option>
                        @endforeach
                      @else
                          <option value="{{ Auth::user()->id}}"> {{ Auth::user()->role }} - {{ Auth::user()->name }}</option>
                      @endif
                    </select>  
                </div>
                <div class="col-sm-3"> 
                    <label for="inputEmail3">Bulan Proses : </label>
                    <input type="month" class="form-control" id="tgl" name="tgl">
                </div>
                
                  </div>
                  <div class="col-sm-2">
                    <br>
                      <button type="submit" class="btn bg-purple btn-flat"><i class="fa fa-eye"></i> Tampilkan</button>
                    </div>
                    <div class="col-sm-2">
                    <br>
                      <a href="{{ url('tanaman-data/statistik') }}" class="btn bg-green btn-flat" title="Reset Pencarian"><i class="fa fa-check"></i> Reset</a>
                    </div>
                </div>
            </form>
            <br>
            <div style="overflow-x:auto;">
              <div>
                <center>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang diupload: <b>{{ $data }}</b> </a>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang telah dicrop: <b>{{ $data1 }}</b> </a>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang telah diverified:  <b>{{ $data2 }}</b></a>
                </center>
              </div>
              <br>
              <div>
                <center>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang belum dicrop: <b>{{ $data3 }}</b></a>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang belum diverified: <b>{{ $data4 }}</b></a>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total Jumlah Raw Data yang yang ditolak: <b>{{ $data5 }}</b></a>
                </center>
              </div>
              <br>
              <div>
                <center>
                <a class="btn bg-green btn-flat" title="Reset Pencarian">Total melakukan proses Crop Sebanyak: <b>{{ $data6 }}</b></a>
                </center>
              </div>
              <br>
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


