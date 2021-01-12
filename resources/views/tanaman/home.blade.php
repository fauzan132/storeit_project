@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
        Dashboard
        <small>Selamat Datang</small>
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Welcome</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        <div class="callout callout-info">
            <h4>Selamat Datang</h4>

            <p>Selamat Datang dihalaman panel {{ Auth::user->role }}!, Silahkan pilih menu Data Tanaman untuk mengelola data tanaman.</p>
        </div>
        
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
</div>
@endsection
