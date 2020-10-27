@extends('layouts.app')

@section('title', '| Retraits du jour')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Commandes</h5>
                    <span>Retraits du jour</span>
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
                        <a href="#">Commandes</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Retraits du jour</li>
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
                        <h3 class="card-title">Résultats des retraits du jour</h3>
                        
                    </div>
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data_table" class="table">
                                <thead>
                                    <tr>

                                        <th>Code dépôt</th>
                                        <th>Date du dépôt</th>
                                        <th>Montant</th>
                                        <th>Nom & Prénom(s) du client</th>
                                        <th>Téléphone</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if(count($orders) > 0)
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y ')}}</td>
                                            <td>{{ $order->order_amount }}</td>
                                            <td>{{ $order->client_name }} {{ $order->client_firstname }}</td>
                                            <td>{{ $order->client_phone}}</td>
                                            
                                           <td>
                                               
                                               <a href="{{ route('message.create', $order->client_id) }}" class="" title="envoyer Message"><i class="ik ik-send f-16 mr-15 text-black"></i></</a>
                                               
                                              <a href="{{ route('orders.show', $order->id) }}" class="" title="Voir"><i class="ik ik-eye f-16 mr-15 text-blue"></i></</a>

                                              <a href="{{ route('assigncollector.create', $order->id) }}" class="" title="Affecter un collecteur"><i class="ik ik-share f-16 mr-15 text-yellow"></i></a>

                                              @can('Admin Permissions')
                                              <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $order->id}})" data-target="#confirm" class="" title="Supprimer"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                              @endcan

                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="ik ik-x"></i>
                                            </button>
                                            <span>
                                                <b><center>  Aucun retrait prévu pour aujourd'hui! </center> </b> </span>
                                        </div>
                                    @endif
                                </tbody>

                            </table>
                        </div>

                        <div class="card-footer">
                          <a href="{{ url()->previous() }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Retour </a>
                        </div>
                </div>
            </div>
        </div>
    <!-- /.content -->

@endsection
