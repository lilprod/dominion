{{-- \resources\views\users\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Ajouter utilisateur')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Utilisateurs</h5>
                    <span>Ajouter utilisateur</span>
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
                        <a href="#">Utilisateurs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajouter utilisateur</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
      @include('inc.messages')
      <div class='col-md-8 col-md-offset-2'>
            <div class="card">
                <div class="card-header">
                  <h3><i class='fa fa-user-plus'></i> Ajouter utilisateur</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::open(array('url' => 'users', 'enctype' => 'multipart/form-data')) }}
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        {{ Form::label('name', 'Nom') }}
                        {{ Form::text('name', '', array('class' => 'form-control form-control-uppercase')) }}
                      </div>

                      <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', '', array('class' => 'form-control')) }}
                      </div>

                      <div class="form-group">
                            {{ Form::label('password', 'Mot de passe') }}<br>
                            {{ Form::password('password', array('class' => 'form-control')) }}
                      </div>

                      <div class="form-group">
                        {{ Form::label('address', 'Adresse') }}
                        {{ Form::text('address', '' , array('class' => 'form-control', 'id' => 'address')) }}
                      </div>

                    </div>

                    <div class="col-md-6">

                      <div class="form-group">
                        {{ Form::label('firstname', 'Prénoms') }}
                        {{ Form::text('firstname', '', array('class' => 'form-control form-control-capitalize', 'id' => 'firstname')) }}
                      </div>

                      <div class="form-group">
                        {{ Form::label('phone_number', 'Numero de téléphone') }}
                        {{ Form::text('phone_number', '', array('class' => 'form-control')) }}
                      </div>

                      <div class="form-group">
                            {{ Form::label('password', 'Confirmation du mot de passe') }}<br>
                            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                      </div>

                      <div class="form-group">
                          {{ Form::label('profile_picture', 'Image de profil') }}
                          {{ Form::file('profile_picture', array('class' => 'form-control')) }}
                      </div>
                    </div>
                  </div>
                 
                  <h5><b>Assigner Rôle</b></h5>
                    <div class='form-group'>
                        @foreach ($roles as $role)
                            {{ Form::checkbox('roles[]',  $role->id ) }}
                            {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                        @endforeach
                    </div>

                </div>
                <!-- /.box-body -->
              <div class="card-footer">
                {{ Form::submit('Ajouter', array('class' => 'btn btn-primary btn-block')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
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
