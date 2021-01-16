@extends('layouts.layout')

@section('content')
<section class="content-header">
      <h1>
      Data Tanaman
      </h1>
<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-image"></i> Data Tanaman</a></li>
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
              <h3 class="box-title">Tambah Data Tanaman</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('tanaman-data/simpan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Plant Type</label>
                    <div class="col-sm-10">
                      <select id="planttype" name="planttype" class="form-control">
                        <option value="">Pilih Plant Type</option>
                        @foreach($planttype as $row)
                          <option value="{{ $row->id}}">{{ $row->nama_plant_type }}</option>
                        @endforeach
                      </select>
                      <input type="text" name="other_plant" class="form-control" placeholder="Plant Type ..." style="display:none" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Plant Organ</label>
                    <div class="col-sm-10">
                      <select id="plantorgan" name="plantorgan" class="form-control">
                        <option value="">Pilih Plant Organ</option>
                        <option value="Fruit">Fruit</option>
                        <option value="Flower">Flower</option>
                        <option value="Leaf">Leaf</option>
                        <option value="Stem">Stem</option>
                        <option value="Root">Root</option>
                        <option value="Other">Other</option>
                      </select>
                     </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">General Ident</label>
                    <div class="col-sm-10">
                      <select id="generalident" name="generalident" class="form-control">
                        <option value="">Pilih General Ident</option>
                      </select>
                      <input type="text" name="other_general" class="form-control" placeholder="General Ident ..." style="display:none" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Symptom Name</label>
                    <div class="col-sm-10">
                      <select id="symptomname" name="symptomname" class="form-control">
                        <option value="">Pilih Symptom Name</option>
                      </select>
                      <input type="text" name="other_symptom" class="form-control" placeholder="Symptom Name ..." style="display:none" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Image URL</label>
                    <div class="col-sm-10">
                      <input type="file" name="file" class="form-control" id="file" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Image Comment</label>
                    <div class="col-sm-10">
                      <input  type="text" name="imagecomment" class="form-control" id="imagecomment" placeholder="Image Comment ...">
                    </div>
                  </div>
                  <input type="hidden" name="tmp_plant" class="form-control" id="tmp_plant">
                  <input type="hidden" name="tmp_general" class="form-control" id="tmp_general">
                  <input type="hidden" name="tmp_symptom" class="form-control" id="tmp_symptom">

                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                      <a href="{{ url('tanaman-data/index/') }}" class="btn btn-default btn-flat"><i class="fa fa-close"></i> Batal</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script><script>
    $(document).ready(function () {
        $("#planttype").change(function () {
            var id_plant_type = $(this).val();
            axios.get('/dropdown/general-ident/' + id_plant_type).then(resp => {
                var tmp_data = JSON.stringify(resp.data);
                var result = tmp_data.toString();
                $("select#generalident").html(result);
                var _options = ""
                var tmp_data = JSON.parse(result)
                _options += ('<option value=""> Pilih General Ident </option>');
                $.each(tmp_data, function (i, value) {
                    _options += ('<option value="' + value.id + '">' + value
                        .nama_general_ident + '</option>');
                });
                $('#generalident').append(_options);
            });
        });
    });
    $(document).ready(function () {
        $("#generalident").change(function () {
            var id_general_ident = $(this).val();
            axios.get('/dropdown/symptom-name/' + id_general_ident).then(resp => {
                var tmp_data = JSON.stringify(resp.data);
                var result = tmp_data.toString();
                $("select#symptomname").html(result);
                var _options = ""
                var tmp_data = JSON.parse(result)
                _options += ('<option value=""> Pilih Symptom Name </option>');
                $.each(tmp_data, function (i, value) {
                    _options += ('<option value="' + value.id + '">' + value
                        .nama_symptom_name + '</option>');
                });
                $('#symptomname').append(_options);
            });
        });
    });

</script>

<script>
    $("#planttype").change(function () {
        var planttype = $(this).val();
        document.getElementById('tmp_plant').value = planttype;
    });
    $("#generalident").change(function () {
        var generalident = $(this).val();
        document.getElementById('tmp_general').value = generalident;
    });
    $("#symptomname").change(function () {
        var symptomname = $(this).val();
        document.getElementById('tmp_symptom').value = symptomname;
    });
</script>

<script>
jQuery(document).ready(function() {
    jQuery("#planttype").change(function() {
        if (jQuery(this).val() === '03'){ 
            jQuery('input[name=other_plant]').show();   
        } else {
            jQuery('input[name=other_plant]').hide(); 
        }
    });
    
});

jQuery(document).ready(function() {
    jQuery("#generalident").change(function() {
        if (jQuery(this).val() === '0105' || jQuery(this).val() === '0205' || jQuery(this).val() === '0305'){ 
            jQuery('input[name=other_general]').show();   
        } else {
            jQuery('input[name=other_general]').hide(); 
        }
    });
});

jQuery(document).ready(function() {
    jQuery("#symptomname").change(function() {
        if (jQuery(this).val() === '0101006' || jQuery(this).val() === '0102006' || jQuery(this).val() === '0105001' || 
            jQuery(this).val() === '0201006' || jQuery(this).val() === '0202006' || jQuery(this).val() === '0205001' || 
            jQuery(this).val() === '0301008' || jQuery(this).val() === '0302008' || jQuery(this).val() === '0305001'){ 
            jQuery('input[name=other_symptom]').show();   
        } else {
            jQuery('input[name=other_symptom]').hide(); 
        }
    });
});
</script>

@endsection