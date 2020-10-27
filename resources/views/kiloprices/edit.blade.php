{{-- \resources\views\deliveryhours\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Editer Prix du kilo')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Prix du kilo</h5>
                    <span>Editer le prix du kilo</span>
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
                        <a href="#">Prix du kilo</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editer le prix du kilo</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <div class="row">
      <div class='col-lg-8 col-lg-offset-2'>
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"><i class='fa fa-plus-square'></i> Editer le prix du kilo</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($kiloprice, array('route' => array('kiloprices.update', $kiloprice->id) , 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}{{-- Form model binding to automatically populate our fields with user data --}}
                <div class="card-body">

                  <div class="col-sm-12">
                        <div class="form-group">
                          {{ Form::label('title', 'Libellé') }}
                          {{ Form::text('title', null , array('class' => 'form-control')) }}
                        </div>
                    </div>

                  <div class="col-sm-12">
                    <div class="form-group row">
                        <div class="col-sm-4">
                          <div class="form-group">
                              {{ Form::label('lavage_price', 'Prix du kilo du lavage simple') }}
                              {{ Form::text('lavage_price', null, array('class' => 'form-control')) }}
                            </div>
                        </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              {{ Form::label('repassage_price', 'Prix du kilo du repassage') }}
                              {{ Form::text('repassage_price', null, array('class' => 'form-control')) }}
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              {{ Form::label('express_price', 'Prix du kilo Nettoyage Express') }}
                              {{ Form::text('express_price', null, array('class' => 'form-control')) }}
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
                        </div>
                      </div>

                  </div>
                <!-- /.box-body -->

              <div class="card-footer">
                {{ Form::submit('Editer', array('class' => 'btn btn-primary btn-block')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
    </div>
    <!-- /.content -->

@endsection
