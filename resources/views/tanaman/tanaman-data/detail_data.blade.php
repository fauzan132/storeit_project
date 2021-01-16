@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data Tanaman</a></li>
        <li class="active">Detail Data</li></li>
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
            <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Data Tanaman</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Plant Image</label>

                  <div class="col-sm-10">
                    <!-- <input type="text" name="imageurl" class="form-control" value="{{ $data['ImageURL'] }}"> -->
                    <a href="{{ URL::asset("images/{$data['ImageURL']}") }}" data-toggle="lightbox" data-gallery="image-gallery" data-title="{{ $data['plantType'] }}" style="width:500px">
                    <img src="{{ URL::asset("images/{$data['ImageURL']}") }}" class="img-fluid" width="600px">
                    </a>
                    <input type="hidden" name="tmp_image" value="{{ $data['ImageURL'] }}">
                    <input type="hidden" name="user_id" value="{{ $data['userID'] }}">
                    <!-- <input type="file" name="file" class="form-control" id="file"> -->
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Hasil Crop</label>

                  <div class="col-sm-10">
                    <!-- data Gambar hasil crop belum dimuncul kan -->
                    @if($data4 == "Data belum pernah dicrop")
                      <label for="inputEmail3" class="control-label" style="color:red;">{{ $data4 }}</label>
                    @else
                      <a href="{{ URL::asset("upload/{$data4['ImageURL']}") }}" data-toggle="lightbox" data-gallery="image-gallery" data-title="{{ $data['plantType'] }}" style="width:256px">
                      <img src="{{ URL::asset("upload/{$data4['ImageURL']}") }}" class="img-fluid" width="256px"></a>
                    @endif
                    
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Plant Type</label>

                  <div class="col-sm-10">
                    <input type="text" name="planttype" class="form-control" id="planttype" value="{{ $data['plantType'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Plant Organ</label>

                  <div class="col-sm-10">
                    <input type="text" name="plantorgan" class="form-control" id="plantorgan" value="{{ $data['plantOrgan'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">General Ident</label>

                  <div class="col-sm-10">
                    <input type="text" name="generalident" class="form-control" id="generalident" value="{{ $data['generalIdent'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Symptom Name</label>

                  <div class="col-sm-10">
                    <input type="text" name="symptomName" class="form-control" id="symptomName" value="{{ $data['symptomName'] }}" disabled>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Image Comment</label>

                  <div class="col-sm-10">
                    <input  type="text" name="imagecomment" class="form-control" id="imagecomment" placeholder="Image Coment ..." value="{{ $data['ImageComment'] }}" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Terakhir Diperbaharui Oleh</label>

                  <div class="col-sm-10">
                    <input type="text" name="lastupdateby" class="form-control" id="lastupdateby"  value="{{ $data2->name }} - {{ $data2->role }}" disabled>
                  </div>
                </div>

                <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                  <a href="{{ url('tanaman-data/index/') }}" class="btn btn-primary btn-flat"><i class="fa fa-arrow-circle-left" title="Kembali"></i> Kembali</a>
                  <a href="{{ url('tanaman-data/edit', $data->imageID) }}" class="btn bg-orange btn-flat"><i class="fa fa-edit" title="Ubah Data ini"></i> Ubah Data</a>
                  <a href="{{ url('tanaman-data/riwayat', $data->imageID) }}" class="btn bg-green btn-flat"><i class="fa fa-edit" title="Lihat Riwayat Data ini"></i> Riwayat Data</a>
                  </div>
                </div>
              </div>
              <div class="box-footer">
              
              </div>
            </form>
          </div>
        </div>
          <!-- /.box -->
        
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
</section>
@endsection