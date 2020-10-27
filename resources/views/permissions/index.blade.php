@extends('layouts.app')

@section('title', '| Permissions')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Permissions</h5>
                    <span>Liste des permissions</span>
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
                        <a href="#">Permissions</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des permissions</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Main content -->

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
                    <p>Etes-vous sûr(e) de vouloir supprimer cette permission?</p>
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
    
    <div class="row">
            <div class="col-lg-12">
              @include('inc.messages')
                <div class="card">
                <div class="card-header with-border">
                  <h3 class="card-title">Permissions</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Utilisateurs</a>
                    <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Rôles</a>
                </div>

                <!-- /.box-header -->
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>Permissions</th>
                                <th>Opérations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td> 
                                <td>
                                <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                                <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $permission->id}})" data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                  <a href="{{ URL::to('permissions/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter Permission</a>
                </div>

            </div>
            </div>
        </div>
    <!-- /.content -->

@endsection

@push('permission')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("permissions.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush
