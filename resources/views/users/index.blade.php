@extends('layouts.app')

@section('title', '| Utilisateurs')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Utilisateurs</h5>
                    <span>Liste des utilisateurs</span>
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
                        <a href="#">Utilisateurs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des utilisateurs</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer cet utilisateur?</p>
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
                <div class="card-header"><h3 class="box-title">Administration des utilisateurs</h3>
                        <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Rôles</a>
                        <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a>
                </div>
                     
                    <!-- /.box-header -->
                    <div class="card-body">
                        <div class="dt-responsive">
                                <table id="data_table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Nom et Prénom(s)</th>
                                            <th>Email</th>
                                            <th>Date/Heure d'ajout</th>
                                            <th>Rôles</th>
                                            <th>Opérations</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>

                                            <td>{{ $user->name }} {{ $user->firstname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                            <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                                            <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $user->id}})" data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                          <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter utilisateur</a>
                        </div>
                </div>
            </div>
        </div>
    <!-- /.content -->

@endsection

@push('user')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("users.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush
