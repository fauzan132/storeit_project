@extends('layouts.layout')

@section('content')
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        @if(Auth::user()->role == 'Admin')
        <div class="callout callout-info">
            <h4>Selamat Datang</h4>

            <p>Ini Halaman Admin!</p>
        </div>
        @elseif(Auth::user()->role == 'Public')
        <div class="callout callout-info">
        <h4>Selamat Datang</h4>

        <p> Ini Halaman Public!</p>
        </div>
        @elseif(Auth::user()->role == 'Expert ITB')
        <div class="callout callout-info">
        <h4>Selamat Datang</h4>

        <p> Ini Halaman Expert ITB!</p>
        </div>
        @elseif(Auth::user()->role == 'Expert EDWINDO')
        <div class="callout callout-info">
        <h4>Selamat Datang</h4>

        <p> Ini Halaman Expert EDWINDO!</p>
        </div>
        @elseif(Auth::user()->role == 'Expert BALITSA')
        <div class="callout callout-info">
        <h4>Selamat Datang</h4>

        <p> Ini Halaman Expert BALITSA!</p>
        </div>
        @elseif(Auth::user()->role == 'Cropper')
        <div class="callout callout-info">
        <h4>Selamat Datang</h4>

        <p> Ini Halaman Cropper</p>
        </div>           
        @endif
            
        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->
@endsection
