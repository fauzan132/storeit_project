@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data Tanaman Semua Pengguna</a></li>
        <li class="active">Reject Data</li></li>
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
              <h3 class="box-title">Data Tanaman User: {{ $data->name }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/user/update',$data['id']) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Tulis alasan anda :</label>
                    <div class="col-sm-10">
                        <textarea name="imagecomment" class="form-control"></textarea>
					<span class="focus-input100"></span>
                    </div>
                </div>
                <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                  <a href="{{ url('admin/user/index/') }}" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" class="btn btn-primary btn-flat" onclick="return confirm('Apakah anda yakin akan menolak data ini ?')"><i class="fa fa-save"></i> Reject</button>
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