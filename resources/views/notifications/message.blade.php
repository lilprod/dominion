{{-- \resources\views\collectors\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Envoyer message')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Messages</h5>
                    <span>Envoi de message</span>
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
                        <a href="#">Messages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Envoi de message</li>
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
                  <h3 class="card-title"><i class='fa fa-envelope'></i> Envoi de message à un Client</h3>
                </div>

                {{ Form::open(array('url' => 'message', 'enctype' => 'multipart/form-data')) }}

                <div class="card-body">

                    {{ Form::hidden('client_id', '$id', array('class' => 'form-control')) }}

                    <div class="col-sm-8">
                        
                        <div class="form-group">
                          {{ Form::label('client_name', 'Nom du client') }}
                          {{ Form::text('client_name', $name, array('class' => 'form-control', 'disabled')) }}
                        </div>
                    </div>

                    <div class="col-sm-8">
                        
                        <div class="form-group">
                          {{ Form::label('title', 'Sujet du message') }}
                          {{ Form::text('title', 'Notification sur votre Commande', array('class' => 'form-control')) }}
                        </div>
                    </div>
                    
                    <div class="col-sm-8">
                        
                        <div class="form-group">
                          {{ Form::label('phone_number', 'Numéro de Téléphone') }}
                          {{ Form::text('phone_number', $client->phone_number, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-sm-8">
                        
                        <div class="form-group">
                          {{ Form::label('message', 'Message') }}
                          {{ Form::textarea('message', '', array('class' => 'form-control')) }}
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                {{ Form::submit('Envoyer message', array('class' => 'btn btn-block btn-primary')) }}
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
    </div>
    <!-- /.content -->

@endsection