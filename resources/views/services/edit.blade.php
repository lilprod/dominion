{{-- \resources\views\articles\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Editer Article')

@section('content')
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Services</h5>
                    <span>Editer un service</span>
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
                        <a href="#">Services</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editer un service</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <civ class="row">
      <div class='col-md-8 col-md-offset-2'>
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"><i class='fa fa-plus-square'></i> Editer un service</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($service, array('route' => array('services.update', $service->id) , 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}{{-- Form model binding to automatically populate our fields with user data --}}
                <div class="card-body">

                    <div class="col-sm-12">
                        <div class="form-group">
                          {{ Form::label('title', 'Libellé') }}
                          {{ Form::text('title', null , array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                          {{ Form::label('description', 'Description') }}
                          {{ Form::textarea('description', null, array('class' => 'form-control')) }}
                      </div>
                    </div>

                  </div>
                <!-- /.card-body -->

              <div class="card-footer">
                {{ Form::submit('Editer', array('class' => 'btn btn-primary btn-block')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->
@endsection
