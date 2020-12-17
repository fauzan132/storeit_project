@extends('layouts.layout')

@section('content')
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Tanaman</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <a href="{{ url('admin-data/create') }}"><button type="button" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Tambah Data</button></a><br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>General Ident</th>
                    <th>Status</th>
                    <th>Current Date</th>
                    <th>Image URL</th>
                    <th>Image Comment</th>
                    <th>Ubah Data</th>
                    <th>Hapus Data</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
            @foreach($data as $row => $value)
                <?php $no++ ;?>
                <tr>
                <td>{{ $no }}</td>
                    <td>{{ $value->plantType }}</td>
                    <td>{{ $value->plantOrgan }}</td>
                    <td>{{ $value->generalIdent }}</td>
                    <td>{{ $value->status }}</td>
                    <td>{{ $value->currentDate }}</td>
                    <td>{{ $value->ImageURL }}</td>
                    <td>{{ $value->ImageComment }}</td>
                    <td>
                        <a href="{{ url('admin-data/edit', $value->imageID) }}" title="Ubah Data ini">Ubah</a>
                    </td>
                    <td>
                        <a href="{{ url('admin-data/hapus', $value->imageID) }}" title="Hapus Data ini">Hapus</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Plant Type</th>
                    <th>Plant Organ</th>
                    <th>General Ident</th>
                    <th>Status</th>
                    <th>Current Date</th>
                    <th>Image URL</th>
                    <th>Image Comment</th>
                    <th>Ubah Data</th>
                    <th>Hapus Data</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
      
@endsection


