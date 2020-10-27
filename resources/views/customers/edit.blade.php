{{-- \resources\views\customers\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Editer Client')

@section('content')

<!-- Content Header (Page header) -->
    <div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Clients</h5>
                    <span>Editer Client</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Editer Client</li>
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
                  <h3 class="card-title"><i class='fa fa-user-plus'></i> Editer {{$customer->name}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($customer, array('route' => array('customers.update', $customer->id) , 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}{{-- Form model binding to automatically populate our fields with user data --}}
                <div class="card-body">

                  <div class="form-group row">

                    <div class="col-md-6">
                        <div class="form-group">
                          {{ Form::label('name', 'Nom') }}
                          {{ Form::text('name', null, array('class' => 'form-control form-control-uppercase', 'id' => 'name')) }}
                        </div>
                      </div>

                      <div class="col-sm-6">
                          <div class="form-group">
                              {{ Form::label('firstname', 'Prénoms') }}
                              {{ Form::text('firstname', null, array('class' => 'form-control form-control-capitalize' , 'id' => 'firstname')) }}
                          </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', null, array('class' => 'form-control' )) }}
                        </div>
                      </div>

                      <div class="col-md-6">
                              <div class="form-group">
                                {{ Form::label('phone_number', 'Numéro de Téléphone') }}
                                {{ Form::text('phone_number', null, array('class' => 'form-control')) }}
                            </div>
                        </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('address', 'Adresse') }}
                            {{ Form::text('address', null, array('class' => 'form-control', 'id' => 'address')) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          {{ Form::label('profile_picture', 'Image de Profil') }}
                          {{ Form::file('profile_picture') }}
                      </div>
                   </div>

                  </div>

                </div>
                <!-- /.card-body -->

              <div class="card-footer">
                {{ Form::submit('Editer Client', array('class' => 'btn btn-block btn-primary')) }}
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
