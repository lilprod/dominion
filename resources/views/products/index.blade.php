@extends('layouts.app')

@section('title', '| Produits')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Produits</h5>
                    <span>Liste des produits</span>
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
                        <a href="#">Produits</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des produits</li>
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
                    <p>Etes-vous sûr(e) de vouloir supprimer ce produit?</p>
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
                <h3 class="card-title">Produits</h3>
                <a href="{{ route('products.create') }}" class="btn btn-default pull-right"><i class='fa fa-plus-square'></i>  Ajouter un produit</a>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th>Libellés</th>
                            <th>Descripitons</th>
                            <th>Date/Heure d'ajout</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                        <tr>

                            <td>{{ $product->title }}</td>
                            <td>{{ $product->description }}</td>

                            <td>{{ $product->created_at->format('F d, Y h:ia') }}</td>
                            <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-xs" style="margin-right: 3px;"><i class="fa fa-edit"></i> Editer</a>

                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $product->id}})" 
                            data-target="#confirm" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Supprimer</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
              <a href="{{ route('products.create') }}" class="btn btn-primary"><i class='fa fa-plus-square'></i>  Ajouter un produit</a>
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
         var url = '{{ route("products.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
</script>
@endpush

