@extends('layouts.app')

@section('title', '| Clients')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Clients</h5>
                    <span>Liste des clients</span>
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
                        <a href="#">Clients</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des clients</li>
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
                    <h5 class="modal-title">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        
                  </div>
                  <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <p>Etes-vous sûr(e) de vouloir supprimer ce client?</p>
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
                        <h3 class="card-title">Administration des clients</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes</a>
                        <a href="#" class="btn btn-default pull-right"><i class="fa fa-suitcase"></i> Retraits</a>
                    </div>
                    <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data_table" class="table">
                                <thead>
                                    <tr>
                                        <th style="display: none;">ID</th>
                                        <th>Date d'ajout</th>
                                        <th>Nom et Prénoms</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th width="">View</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td style="display: none;">{{ $customer->id }}</td>
                                        <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $customer->name }} {{ $customer->firstname }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone_number }}</td>
                                        <td>
                                            <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $customer->averageRating }}" data-size="xs" disabled="">
                                        </td>

                                        
                                        <td>

                                        <a href="{{ route('customers.edit', $customer->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                                        <a href="{{ route('customers.show', $customer->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>

                                        @can('Admin Permissions')
                                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $customer->id}})" data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <!--<div class="card-footer clearfix">
                          <a href="{{ route('customers.create') }}" class="btn bg-olive"><i class="fa fa-plus"></i>  Ajouter Client</a>
                        </div>-->
                </div>
            </div>
        </div>
    <!-- /.content -->

@endsection

@push('customer')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("customers.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>

<script type="text/javascript">

    $("#input-id").rating();

</script>
@endpush