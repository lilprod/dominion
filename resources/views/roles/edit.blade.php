@extends('layouts.app')

@section('title', '| Editer Role')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Rôles</h5>
                    <span>Editer un rôle</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Editer un rôle</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<!-- Main content -->
<div class="row">
    <div class='col-lg-4 col-lg-offset-4'>
        <div class="box box-primary">
            <div class="card-header with-border">
              <h3 class="card-title"><i class='fa fa-key'></i> Editer rôle: {{$role->name}}</h3>
            </div>
      
            {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
            <div class="card-body">
                <div class="form-group">
                    {{ Form::label('name', 'Nom du Role') }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                </div>

                <h5><b>Assign Permissions</b></h5>
                @foreach ($permissions as $permission)

                    {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                    {{Form::label($permission->name, ucfirst($permission->name)) }}<br>

                @endforeach
                <br>
            </div>

            <div class="card-footer">
                {{ Form::submit('Editer', array('class' => 'btn btn-primary btn-block')) }}
            </div>
            {{ Form::close() }}    
        </div>
    </div>
</div>
@endsection
