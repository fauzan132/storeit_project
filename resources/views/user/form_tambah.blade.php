@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data User
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data User</a></li>
        <li class="active">Tambah Data</li></li>
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
              <h3 class="box-title">Tambah Data User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/user/simpan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>

                  <div class="col-sm-10 validate-input" data-validate = "Confirm Password is required">
                    <input type="text" name="name" class="input100 form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Masukkan Nama" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
						        <span class="focus-input100"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input type="text" name="email" class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  id="email" placeholder="Masukkan Email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
						        <span class="focus-input100"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">No. Telephone</label>

                  <div class="col-sm-10 validate-input" data-validate="Must be Telephone Format">
                    <input type="text" name="telp" class="input100 form-control{{ $errors->has('telp') ? ' is-invalid' : '' }}" id="telp" placeholder="Masukkan No. Telp" value="{{ old('telp') }}" required autofocus>
                    @if ($errors->has('telp'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('telp') }}</strong>
                        </span>
                    @endif
						        <span class="focus-input100"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10 validate-input" data-validate = "Password is required">
                    <input type="password" name="password" class="input100 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Masukkan Password" value="{{ old('password') }}" required autofocus>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <span class="focus-input100"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Konfirmasi Password</label>

                  <div class="col-sm-10 validate-input" data-validate = "Password confirmation is not same">
                    <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" placeholder="Masukkan Konfirmasi Password" value="{{ old('password_confirmation') }}" required autofocus>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <span class="focus-input100"></span>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Role</label>
                      <div class="col-sm-10">
                      <select name="role" class="form-control" required>
                        <option value="">Pilih Role User</option>
                        <option value="Admin">Admin</option>
                        <option value="Public">Public</option>
                        <option value="Expert ITB">Expert ITB</option>
                        <option value="Expert EWINDO">Expert EWINDO</option>
                        <option value="Expert BALITSA">Expert BALITSA</option>
                        <option value="Cropper">Cropper</option>
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