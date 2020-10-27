@extends('layouts.app')

@section('title', '| Ajouter Role')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Rôles</h5>
                    <span>Ajouter un rôle</span>
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
                        <a href="#">Rôles</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajouter un rôle</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <div class="row">
      <div class='col-lg-4 col-lg-offset-4'>
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"><i class='fa fa-key'></i> Ajouter un rôle</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::open(array('url' => 'roles')) }}
                  <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('name', 'Nom du rôle') }}
                        {{ Form::text('name', null, array('class' => 'form-control')) }}
                    </div>

                    <h5><b>Assigner une/des permission(s) au rôle</b></h5>

                    <div class='form-group'>
                        @foreach ($permissions as $permission)
                            {{ Form::checkbox('permissions[]',  $permission->id ) }}
                            {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>

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

@endsection
