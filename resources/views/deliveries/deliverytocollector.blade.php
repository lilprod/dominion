{{-- \resources\views\deliveries\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Affecter collecteur')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Livraisons</h5>
                    <span>Affecter un livreur</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Affecter un livreur</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <div class="row">
      @include('inc.messages')
      <div class="col-lg-8 col-lg-offset-2">
            <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title"><i class='fa fa-cart-arrow-down'></i> Affecter un livreur à la livraison</h3>
                </div>

                {{ Form::open(array('url' => 'deliveries', 'enctype' => 'multipart/form-data')) }}

                <div class="card-body">
                    {{ Form::hidden('order_id', $order->id, array('class' => 'form-control')) }}

                    <div class="col-sm-8">
                        
                        <div class="form-group">
                          {{ Form::label('order_code', 'N° commnde') }}
                          {{ Form::text('order_code', $order->order_code, array('class' => 'form-control', 'disabled')) }}
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                          {{ Form::label('place_delivery', 'Lieu de livraison') }}
                          {{ Form::text('place_delivery', $order->place_delivery, ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                          {{ Form::label('collector_id', 'Nom du collector') }}
                          {!! Form::select('collector_id', $collectors, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                {{ Form::submit('Affecter livreur', array('class' => 'btn btn-block btn-primary')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
    </div>
    <!-- /.content -->

@endsection