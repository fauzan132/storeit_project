@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data User
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data User</a></li>
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
              <h3 class="box-title">Ubah Data User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('profile/update',$data['id']) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nama</label>

                  <div class="col-sm-10 validate-input" data-validate="Nama Required">
                    <input type="text" name="name" class="input100 form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Masukkan Nama" value="{{ old('name',$data->name) }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
						        <span class="focus-input100"></span>
                  </div>
                </div>

              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">No. Telephone</label>

                  <div class="col-sm-10 validate-input" data-validate="Must be Telephone Format">
                    <input type="text" name="telp" class="input100 form-control{{ $errors->has('telp') ? ' is-invalid' : '' }}" id="telp" placeholder="Masukkan No. Telp" value="{{ old('telp',$data->telp) }}" required autofocus>
                    @if ($errors->has('telp'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('telp') }}</strong>
                        </span>
                    @endif
						        <span class="focus-input100"></span>
                  </div>
                </div>

                <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                  <a href="{{ url('profile/index/') }}" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Batal</a>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
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