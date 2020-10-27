{{-- \resources\views\deliveries\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Nouveau retrait')

@section('content')

<!-- Content Header (Page header) -->

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Livraisons</h5>
                    <span>Nouvelle livraison</span>
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
                        <a href="#">Livraisons</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Nouveau livraison</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <div class="row">
        <div class="col-md-12">
        @include('inc.messages')
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"> Nouveau retrait</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  {{ Form::open(array('url' => 'savedelivery', 'enctype' => 'multipart/form-data')) }}
                    <div class="card-body">
                            {{ Form::hidden('order_id', $order->id, array('class' => 'form-control')) }}
                          
                          <div class="col-sm-12">

                            <div class="form-group row">

                              <div class="col-sm-6">
                                  <div class="form-group">
                                    {{ Form::label('date_depot', 'Date du depot') }}
                                    {{ Form::date('date_depot', $date, array('class' => 'form-control')) }}
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="form-group">
                                      {{ Form::label('quantity', 'Nombre d\'article(s)') }}
                                      {{ Form::number('quantity', $order->quantity, array('class' => 'form-control')) }}
                                  </div>
                              </div>

                              <div class="col-sm-6">
                                  <div class="form-group">
                                    {{ Form::label('order_amount', 'Montant du depot') }}
                                    {{ Form::number('order_amount', $order->order_amount, array('class' => 'form-control')) }}
                                  </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                          {{ Form::label('left_pay', 'Reste') }}
                                          {{ Form::number('left_pay', $order->left_pay, array('class' => 'form-control')) }}
                                      </div>
                                 </div>
                                 
                                <div class="col-sm-6">
                                     <div class="form-group">
                                        {{ Form::label('amount_paid', 'Montant verse') }}
                                        {{ Form::number('amount_paid', 0, array('class' => 'form-control','required' => 'required')) }}
                                    </div>
                                </div>

                            </div>
                          </div>
                    <!-- /.box-body -->
                  </div>

                  <div class="card-footer">
                    {{ Form::submit('Valider retrait', array('class' => 'btn btn-flat btn-block btn-primary')) }}
                  </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
    </div>
    <!-- /.content -->
@endsection
