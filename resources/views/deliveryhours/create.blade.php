{{-- \resources\views\deliveryhours\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Ajouter Heure de retrait')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Délais de retrait</h5>
                    <span>Configurer le délai de retrait</span>
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
                        <a href="#">Délais de retrait</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Configurer le délai de retrait</li>
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
                        <h3 class="card-title"><i class='fa fa-plus-square'></i> Ajouter délai de retrait</h3>
                      </div>
                      <!-- /.box-header -->
                      <!-- form start -->
                      {{ Form::open(array('url' => 'deliveryhours', 'enctype' => 'multipart/form-data')) }}
                      <div class="box-body">
                        

                            <div class="form-group row">
                              <div class="col-sm-4">
                                <div class="form-group">
                                  {{ Form::label('lavage_hour', 'Heure de Nettoyage et Repassage') }}
                                  {{ Form::text('lavage_hour', '', array('class' => 'form-control')) }}
                                </div>
                              </div>

                            <div class="col-sm-4">
                              <div class="form-group">
                                {{ Form::label('repassage_hour', 'Heure de repassage') }}
                                {{ Form::text('repassage_hour', '', array('class' => 'form-control')) }}
                              </div>
                            </div>

                              <div class="col-sm-4">
                                <div class="form-group">
                                  {{ Form::label('express_hour', 'Heure du Nettoyage Express') }}
                                  {{ Form::text('express_hour', '', array('class' => 'form-control')) }}
                                </div>
                              </div>
                          </div>
                          
                      </div>
                      <!-- /.box-body -->

                    <div class="card-footer clearfix">
                      {{ Form::submit('Ajouter', array('class' => 'btn btn-primary btn-block')) }}
                    </div>
                  {{ Form::close() }}
                </div>
                <!-- /.box -->
            </div>
          </div>
          <!-- /.content -->

@endsection
