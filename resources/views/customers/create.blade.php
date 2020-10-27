{{-- \resources\views\customers\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Ajouter Client')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Clients</h5>
                    <span>Ajouter client</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Clients</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajouter client</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Main content -->
 <div class="row">
      <div class="col-sm-12">
      @include('inc.messages')
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"><i class='fa fa-user-plus'></i> Ajouter Client</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {{ Form::open(array('url' => 'customers', 'enctype' => 'multipart/form-data')) }}
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="form-group">
                          {{ Form::label('name', 'Nom') }}
                          {{ Form::text('name', '', array('class' => 'form-control form-control-uppercase', 'id' => 'name')) }}
                        </div>
                      </div>

                      <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('firstname', 'Prénoms') }}
                                {{ Form::text('firstname', '', array('class' => 'form-control form-control-capitalize', 'id' => 'firstname')) }}
                            </div>
                        </div>


                      <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', '', array('class' => 'form-control')) }}
                        </div>
                      </div>

                      <div class="col-sm-6">
                              <div class="form-group">
                                {{ Form::label('phone_number', 'Numéro de Téléphone') }}
                                {{ Form::text('phone_number', '', array('class' => 'form-control')) }}
                            </div>
                          </div>

                        <!--<div class="form-group">
                            {{ Form::label('password', 'Mot de Passe') }}<br>
                            {{ Form::password('password', array('class' => 'form-control')) }}
                        </div>-->
                        <div class="col-sm-6">
                          <div class="form-group">
                              {{ Form::label('address', 'Adresse') }}
                              {{ Form::text('address', '', array('class' => 'form-control' , 'id' => 'address')) }}
                          </div>
                        </div>
                            <!--<div class="form-group">
                              {{ Form::label('password', 'Confirmation de Mot de Passe') }}<br>
                              {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                            </div>-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('profile_picture', 'Image de Profil') }}
                                {{ Form::file('profile_picture') }}
                            </div>
                        </div>
                  </div>
                </div>
                <!-- /.card-body -->

              <div class="card-footer">
                {{ Form::submit('Ajouter Client', array('class' => 'btn btn-block btn-primary')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.card -->
    
    </div>
  </div>
    <!-- /.content -->
  <script>
    function changeToUpperCase(t){
      var eleVal = document.getElementById(t.name);
      eleVal.value= eleVal.value.toUpperCase();
      
    }
  </script>
  <script>
    $('#firstname').on('keypress', function() { 
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
          $this.val( value.charAt(0).toUpperCase() );
        }  
    });

    $('#address').on('keypress', function() { 
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
          $this.val( value.charAt(0).toUpperCase() );
        }  
    });

</script>

@endsection
