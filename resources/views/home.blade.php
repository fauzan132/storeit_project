@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                    @if(Auth::user()->role == 'Admin')
                        <div class="panel-body">
                            Ini Halaman Admin!
                        </div>
                    @elseif(Auth::user()->role == 'Public')
                        <div class="panel-body">
                            Ini Halaman Public!
                        </div>
                    @elseif(Auth::user()->role == 'Expert ITB')
                        <div class="panel-body">
                            Ini Halaman Expert ITB!
                        </div>
                    @elseif(Auth::user()->role == 'Expert EDWINDO')
                        <div class="panel-body">
                            Ini Halaman Expert EDWINDO!
                        </div>
                    @elseif(Auth::user()->role == 'Expert BALITSA')
                        <div class="panel-body">
                            Ini Halaman Expert BALITSA!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
