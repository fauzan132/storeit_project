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
              <h3 class="box-title">Ubah Data User: {{ $data->name }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/user/update',$data['id']) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
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
                    <label for="inputPassword3" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="role" required>
                            <option value="">Pilih Role User</option>
                            <option value="Admin" <?php if($data['role']== "Admin"){ echo"selected"; } ?>>Admin</option>
                            <option value="Public" <?php if($data['role']== "Public"){ echo"selected"; } ?>>Public</option>
                            <option value="Expert ITB" <?php if($data['role']== "Expert ITB"){ echo"selected"; } ?>>Expert ITB</option>
                            <option value="Expert EWINDO" <?php if($data['role']== "Expert EWINDO"){ echo"selected"; } ?>>Expert EWINDO</option>
                            <option value="Expert BALITSA" <?php if($data['role']== "Expert BALITSA"){ echo"selected"; } ?>>Expert BALITSA</option>
                            <option value="Cropper" <?php if($data['role']== "Cropper"){ echo"selected"; } ?>>Cropper</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                  <a href="{{ url('admin/user/index/') }}" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Batal</a>
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