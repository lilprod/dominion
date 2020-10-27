@extends('layouts.app')

@section('title', '| Collecteurs')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Collecteurs</h5>
                    <span>Liste des collecteurs</span>
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
                        <a href="#">Collecteurs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des collecteurs</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer ce collecteur?</p>
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
                        <h3 class="card-title">Administration des collecteurs</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes</a>
                        <a href="{{ route('deliveries.index') }}" class="btn btn-default pull-right"><i class="fa fa-suitcase"></i> Retraits</a>
                        
                    </div>
                    <!-- /.box-header -->
                        <div class="card-body">
                            <table id="data_table" class="table">
                                <thead>
                                    <tr>
                                        <th>Nom et Prénoms</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <!--<th>Date/Heure d'Ajout</th>-->
                                        <th width="">View</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($collectors as $collector)
                                    <tr>

                                        <td>{{ $collector->name }} {{ $collector->firstname }}</td>
                                        <td>{{ $collector->email }}</td>
                                        <td>{{ $collector->phone_number }}</td>
                                        <!--<td>{{ $collector->created_at->format('F d, Y h:ia') }}</td>-->

                                        <td>
                                            <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $collector->averageRating }}" data-size="xs" disabled="">
                                        </td>
                                        <td>
                                        <a href="{{ route('collectors.edit', $collector->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                                        <a href="{{ route('collectors.show', $collector->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>

                                        @can('Admin Permissions')
                                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $collector->id}})" data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <div class="card-footer clearfix">
                          <a href="{{ route('collectors.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>  Ajouter un collecteur</a>
                        </div>
                </div>
            </div>
        </div>
    <!-- /.content -->

@endsection

@push('collector')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("collectors.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush