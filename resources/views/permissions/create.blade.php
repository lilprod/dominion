@extends('layouts.app')

@section('title', '| Create Permission')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Permissions</h5>
                    <span>Ajouter une permission</span>
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
                        <a href="#">Permissions</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajouter une permission</li>
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
                  <h3 class="card-title"><i class='fa fa-key'></i> Ajouter une permission</h3>
                </div>
            <!-- /.card-header -->
            <!-- form start -->
                {{ Form::open(array('url' => 'permissions')) }}
                    <div class="card-body">
                        <div class="form-group">
                        {{ Form::label('name', 'Nom de la permission') }}
                        {{ Form::text('name', '', array('class' => 'form-control')) }}
                            </div><br>
                            @if(!$roles->isEmpty())
                                <h6>Assigner un rôle à la permission</h6>

                                @foreach ($roles as $role) 
                                    {{ Form::checkbox('roles[]',  $role->id ) }}
                                    {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                                @endforeach
                            @endif
                    </div>
                <!-- /.card-body -->
                  <div class="card-footer">
                    {{ Form::submit('Ajouter', array('class' => 'btn btn-primary btn-block')) }}
                  </div>
                {{ Form::close() }}
            </div>
          <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->
@endsection
