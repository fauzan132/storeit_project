@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Informasi Pengguna
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data User</a></li>
        <li class="active">Informasi Pengguna</li></li>
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
              <h3 class="box-title">Detail Informasi Pengguna</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>

                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="name" value="{{ $data['name'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" id="email" value="{{ $data['email'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">No. Telephone</label>

                  <div class="col-sm-10">
                    <input type="text" name="telp" class="form-control" id="telp" value="{{ $data['telp'] }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Role</label>

                  <div class="col-sm-10">
                    <input type="text" name="role" class="form-control" id="role" value="{{ $data['role'] }}" disabled>
                  </div>
                </div>

                <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                  <a href="{{ url('profile/edit', Auth::user()->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah Data Profile</a>
                  <a href="{{ url('profile/edit_login', Auth::user()->id) }}" class="btn btn-default"><i class="fa fa-edit"></i> Ubah Data Login</a>
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