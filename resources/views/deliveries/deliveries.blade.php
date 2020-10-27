@extends('layouts.app')

@section('title', '| Livraisons')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Livraisons</h5>
                    <span>Liste des livraisons en attente</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Liste des livraisons en attente</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm">
    <div class="modal-dialog">
        <form action="" id="deleteForm" method="post">
            <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmation de suppression</h4>
                  </div>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <p>Etes-vous sûr(e) de vouloir supprimer cette demande de commande?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Non, Fermer</button>
                    <button type="submit" name="" class="btn btn-xs btn-danger" data-dismiss="modal" onclick="formSubmit()">Oui, Supprimer</button>
                 </div>
            </div>
        </form>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    <!-- Main content -->
        <div class="row">
            <div class="col-md-12">
            @include('inc.messages')
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Liste des livraisons en attente</h3>
                        <a href="#" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Assigner une livraison</a>
                    </div>
                    <!-- /.card-header -->
                        <div class="card-body">
                        <table id="data_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="display: none;">ID</th>
                                        <th>Commande N°</th>
                                        <th >Client</th>
                                        <th>Date dépôt</th>
                                        <th>Livraison</th>
                                         <th>Statuts</th>
                                        <!--<th>Remise</th>-->
                                        <th>Opérations</th>
                                    </tr>
                                </thead>

                                <tbody>
                                        @foreach ($deliveries as $delivery)
                                        <tr>
                                            <td style="display: none;">{{ $delivery->id }}</td>
                                            <td >{{ $delivery->order_code }}</td>
                                            <td >{{ $delivery->client_name }} {{ $delivery->client_firstname }}</td>
                                            <td>{{ $delivery->order_date}}</td>
                                            <td>{{ $delivery->delivery_date}}</td>
                                            <td>
                                              @if ($delivery->status == 0)
                                              <label class="badge badge-warning">En attente</label>
                                              @else
                                              <label class="badge badge-success">Livré</label>
                                              @endif
                                            </td>
                                            <td>
                                              <a href="{{ route('deliveries.show', $delivery->id) }}" class=""><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
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


