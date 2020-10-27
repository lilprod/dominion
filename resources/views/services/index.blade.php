@extends('layouts.app')

@section('title', '| Articles')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Services</h5>
                    <span>Liste des services</span>
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
                        <a href="#">Services</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des services</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer ce service?</p>
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
                <h3 class="card-title">Serices</h3>
                <a href="{{ route('services.create') }}" class="btn btn-default pull-right"><i class='fa fa-plus-square'></i>  Ajouter un service</a>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th>Libellés</th>
                            <th>Descripitons</th>
                            <th>Date/Heure d'Ajout</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($services as $service)
                        <tr>

                            <td>{{ $service->title }}</td>
                            <td>{{ $service->description }}</td>

                            <td>{{ $service->created_at->format('F d, Y h:ia') }}</td>
                            <td>
                            <a href="{{ route('services.edit', $service->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $service->id}})" 
                            data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
              <a href="{{ route('services.create') }}" class="btn btn-primary"><i class='fa fa-plus-square'></i>  Ajouter un service</a>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

@endsection
@push('service')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("services.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush

