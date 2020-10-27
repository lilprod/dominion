{{-- \resources\views\articles\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Editer Article')

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class='fa fa-plus-square'></i> Editer Article
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class='fa fa-plus-square'></i> Editer Article</li>
      </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class='fa fa-plus-square'></i> Editer Article</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($article, array('route' => array('articles.update', $article->id) , 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}{{-- Form model binding to automatically populate our fields with user data --}}
                <div class="box-body">

                    <div class="col-xs-6">
                        <div class="form-group">
                          {{ Form::label('title', 'Libellé') }}
                          {{ Form::text('title', null , array('class' => 'form-control')) }}
                        </div>
                    </div>
        
                      <div class="col-xs-4">
                        <div class="form-group">
                            {{ Form::label('nettoyage_price', 'Prix Netoyage à sec') }}
                            {{ Form::text('nettoyage_price', null, array('class' => 'form-control')) }}
                          </div>
                      </div>

                        <div class="col-xs-4">
                          <div class="form-group">
                            {{ Form::label('repassage_price', 'Prix Repassage') }}
                            {{ Form::text('repassage_price', null, array('class' => 'form-control')) }}
                          </div>
                        </div>

                        <div class="col-xs-4">
                          <div class="form-group">
                            {{ Form::label('lavage_price', 'Prix Nettoyage Express') }}
                            {{ Form::text('lavage_price', null, array('class' => 'form-control')) }}
                          </div>
                        </div>

                        <div class="col-xs-6">
                          <div class="form-group">
                              {{ Form::label('description', 'Description') }}
                              {{ Form::textarea('description', null, array('class' => 'form-control')) }}
                          </div>
                        </div>

                  </div>
                <!-- /.box-body -->

              <div class="box-footer">
                {{ Form::submit('Editer', array('class' => 'btn bg-olive')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
    </section>
    <!-- /.content -->

@endsection
