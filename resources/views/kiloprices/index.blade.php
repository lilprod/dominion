@extends('layouts.app')

@section('title', '| Prix du kilo')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Prix du kilo</h5>
                    <span>Liste des prix du kilo</span>
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
                        <a href="#">Prix du kilo</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Prix du kilo</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer ce prix du kilo?</p>
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
                <h3 class="card-title">Prix du kilo</h3>
                <a href="{{ route('kiloprices.create') }}" class="btn btn-default pull-right"><i class='fa fa-plus-square'></i>  Ajouter un prix de kilo</a>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>

                            <th>Libellé</th>
                            <th>Lavage simple</th>
                            <th>Nettoyage Express</th>
                            <th>Repassage</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($kiloprices as $kiloprice)
                        <tr>

                            <td>{{ $kiloprice->title }}</td>
                            <td>{{ $kiloprice->lavage_price }}</td>
                            <td>{{$kiloprice->express_price }}</td>
                            <td>{{ $kiloprice->repassage_price }}
                            </td>
                            <!--<td>{{ $kiloprice->created_at->format('F d, Y h:ia') }}</td>-->
                            <td>
                            <a href="{{ route('kiloprices.edit', $kiloprice->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>

                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $kiloprice->id}})" 
                            data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
              <a href="{{ route('kiloprices.create') }}" class="btn btn-primary"><i class='fa fa-plus-square'></i>  Ajouter Prix du Kilo</a>
            </div>
        </div>
    </div>
</div>

    <!-- /.content -->

@endsection
@push('kiloprice')
<script>
function deleteData(id)
     {
         var id = id;
         var url = '{{ route("kiloprices.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush

