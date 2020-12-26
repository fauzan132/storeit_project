@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data Tanaman</a></li>
        <li class="active">Ubah Data</li></li>
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
              <h3 class="box-title">Ubah Data Tanaman</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('public-data/update',$data['imageID']) }}" enctype="multipart/form-data">
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Plant Type</label>

                  <div class="col-sm-10">
                    <input type="text" name="planttype" class="form-control" id="planttype" value="{{ $data['plantType'] }}" placeholder="Plant Type ...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Plant Organ</label>

                  <div class="col-sm-10">
                    <input type="text" name="plantorgan" class="form-control" id="plantorgan" value="{{ $data['plantOrgan'] }}" placeholder="Plant Organ ...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">General Ident</label>

                  <div class="col-sm-10">
                    <input type="text" name="generalident" class="form-control" id="generalident" value="{{ $data['generalIdent'] }}" placeholder="General Ident ...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Symptom Name</label>

                  <div class="col-sm-10">
                    <input type="text" name="symptomName" class="form-control" id="symptomName" value="{{ $data['symptomName'] }}" placeholder="Symptom Name ...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Status</label>

                  <div class="col-sm-10">
                    <input type="text" name="status" class="form-control" id="status"  value="{{ $data['status'] }}" placeholder="Status ....">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Image Comment</label>

                  <div class="col-sm-10">
                    <input  type="text" name="imagecomment" class="form-control" id="imagecomment" placeholder="Image Coment ..." value="{{ $data['ImageComment'] }}">
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
                  <a href="{{ url('public-data/index/') }}" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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