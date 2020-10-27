{{-- \resources\views\articles\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Ajouter Etat')

@section('content')

<!-- Content Header (Page header) -->

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Etats des colis</h5>
                    <span>Nouvel état</span>
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
                        <a href="#">Etats des colis</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Nouvel état</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
    @include('inc.messages')
    <div class='col-lg-8 col-lg-offset-2'>
        <div class="card">
            <div class="card-header with-border">
              <h3 class="card-title"><i class='fa fa-plus-square'></i> Ajouter Etat</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('url' => 'status', 'enctype' => 'multipart/form-data')) }}
            <div class="card-body">
              
                <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('title', 'Libellé') }}
                      {{ Form::text('title', '', array('class' => 'form-control')) }}
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        {{ Form::label('description', 'Description') }}
                        {{ Form::textarea('description', '', array('class' => 'form-control')) }}
                    </div>
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
