@extends('layouts.app')

@section('title', '| Editer Permission')

@section('content')
<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Permissions</h5>
                    <span>Editer une permission</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Editer une permission</li>
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
              <h3 class="card-title"><i class='fa fa-key'></i> Editer {{$permission->name}}</h3>
            </div>

            {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with permission data --}}

            <div class="card-body">

                <div class="form-group">
                    {{ Form::label('name', 'Nom de la permission') }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                </div>

           </div>

           <div class="card-footer">
                {{ Form::submit('Editer', array('class' => 'btn btn-primary btn-block')) }}
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>
@endsection
