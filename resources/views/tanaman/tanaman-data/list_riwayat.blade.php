@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Riwayat Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data Tanaman</a></li>
        <li class="active">Riwayat Data</li></li>
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
              <h3 class="box-title">Riwayat Data Tanaman</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Subject</th>
                    <th>Tanggal</th>
                    <th>Oleh</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
            @foreach($data as $row => $value)
                <?php $no++ ;?>
                <tr>
                <td>{{ $no }}</td>
                    <td>{{ $value->subject }}</td>
                    <td>{{ $value->date }}</td>
                    <td>{{ $value->name }} - {{ $value->role }}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Subject</th>
                    <th>Tanggal</th>
                    <th>Oleh</th>
                </tr>
                </tfoot>
              </table>
                
              <a href="{{ url('tanaman-data/detail', $id) }}" class="btn btn-primary btn-flat"><i class="fa fa-arrow-circle-left" title="Kembali"></i> Kembali</a>
              
              <div class="box-footer">
        
          </div>
        </div>
          <!-- /.box -->
        
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
</section>
@endsection