@extends('layouts.app')

@section('title', '| Dépôts')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Commandes</h5>
                    <span>Demandes de commandes</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Demandes de commandes</li>
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
                        <h3 class="card-title">Liste des demandes</h3>
                        <!--<a href="#" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Affecter une commande</a>-->
                    </div>
                    <!-- /.box-header -->
                        <div class="card-body">
                        <table id="data_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="display: none;">ID</th>
                                        <th>Commande N°</th>
                                        <th>Infos du Client</th>
                                        <th>Date de demande</th>
                                        <!--<th style="width: 15%">Date retrait</th>-->
                                        <!--<th>Remise</th>-->
                                        <th>Opérations</th>
                                    </tr>
                                </thead>

                                <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td style="display: none;">{{ $order->id }}</td>
                                            <td >{{ $order->order_code }}</td>
                                            <td>
                                              <p><b>Nom du client :</b> {{ $order->client_name }} {{ $order->client_firstname }}</p>
                                              <p><b>Téléphone :</b> {{ $order->client_phone }} </p>
                                              <p><b>Adresse :</b> {{ $order->client_address }} </p>
                                              </td>
                                            <td>{{ $order->created_at}}</td>
                                            <!--<td style="width: 15%">{{ $order->date_retrait }}</td>-->
                                            <td>

                                              <!--<a href="" class="btn btn-success btn-xs"><i class="fa fa-suitcase"></i> Retrait</a>-->

                                              <a href="{{ route('orders.show', $order->id) }}" class="" title="Voir"><i class="ik ik-eye f-16 mr-15 text-blue"></i></</a>

                                              <a href="{{ route('assigncollector.create', $order->id) }}" class="" title="Affecter un collecteur"><i class="ik ik-share f-16 mr-15 text-yellow"></i></a>

                                              @can('Admin Permissions')
                                              <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $order->id}})" data-target="#confirm" class="" title="Supprimer"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                              @endcan

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

@push('order')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("orders.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush
