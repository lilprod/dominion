@extends('layouts.app')

@section('title', '| Codes promos')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Codes promos</h5>
                    <span>Liste des codes promos</span>
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
                        <a href="#">Codes promos</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des codes promos</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer ce code promo?</p>
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
                <h3 class="card-title">Codes promos</h3>
                <a href="{{ route('codepromos.create') }}" class="btn btn-defaut pull-right"> <i class='fa fa-plus-square'></i>  Ajouter un code promo</a>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th>Libellés</th>
                            <th>Pourcentages</th>
                            <th>Périodes</th>
                            <th>Quotas</th>
                            <th>Restants</th>
                            <th>Date/Heure d'ajout</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($codepromos as $codepromo)
                        <tr>
                            <td>{{ $codepromo->title }}</td>
                            <td>{{ $codepromo->pourcentage }}</td>
                            <td>{{ $codepromo->begin_date }} - {{ $codepromo->end_date }}</td>
                            <td>{{ $codepromo->quota }}</td>
                            <td>{{ $codepromo->leftover }}</td>
                            <td>{{ $codepromo->created_at->format('F d, Y h:ia') }}</td>
                            <td>
                            <a href="{{ route('codepromos.edit', $codepromo->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $codepromo->id}})" 
                            data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
              <a href="{{ route('codepromos.create') }}" class="btn btn-primary"><i class='fa fa-plus-square'></i>  Ajouter code promo</a>
            </div>
        </div>
    </div>
</div>

<!-- /.content -->

@endsection
@push('codepromo')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("codepromos.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush

