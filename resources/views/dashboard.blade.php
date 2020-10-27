@extends('layouts.app')

@section('content')

<div class="row clearfix">
    
        <div class="card">
            <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            Vous êtes connecté!
            </div>
        </div>
  
      <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="widget">
              <div class="widget-body">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="state">
                          <h6>Commandes</h6>
                          <h2>{{$nbre_order}}</h2>
                      </div>
                      <div class="icon">
                          <i class="ik ik-message-square"></i>
                      </div>
                  </div>
                  <!--<small class="text-small mt-10 d-block">6% higher than last month</small>-->
              </div>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{$nbre_order}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$nbre_order}}%;"></div>
              </div>
              <div class="widget-footer">
                <a href="{{ route('orders.index') }}" class="text-small mt-10 d-block">Voir Plus <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>
      </div>
      
      <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="widget">
              <div class="widget-body">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="state">
                          <h6>Livraisons</h6>
                          <h2>{{$nbre_delivery}}</h2>
                      </div>
                      <div class="icon">
                          <i class="ik ik-award"></i>
                      </div>
                  </div>
                  <!--<small class="text-small mt-10 d-block">61% higher than last month</small>-->
              </div>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{$nbre_delivery}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$nbre_delivery}}%;"></div>
              </div>
              <div class="widget-footer">
                <a href="{{ route('deliveries.index') }}" class="text-small mt-10 d-block">Voir Plus <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>
      </div>
      
      <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="widget">
              <div class="widget-body">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="state">
                          <h6>Clients</h6>
                          <h2>{{$nbre_customer}}</h2>
                      </div>
                      <div class="icon">
                          <i class="ik ik-users"></i>
                      </div>
                  </div>
                  <!---<small class="text-small mt-10 d-block">Total Events</small>-->
              </div>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{$nbre_customer}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$nbre_customer}}%;"></div>
              </div>
              <div class="widget-footer">
                <a href="{{ route('customers.index') }}" class="text-small mt-10 d-block">Voir Plus <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>

      </div>
      
      <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="widget">
              <div class="widget-body">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="state">
                          <h6>Collecteurs</h6>
                          <h2>{{$nbre_collector}}</h2>
                      </div>
                      <div class="icon">
                          <i class="ik ik-user"></i>
                      </div>
                  </div>
                  <!--<small class="text-small mt-10 d-block">Total Comments</small>-->
              </div>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$nbre_collector}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$nbre_collector}}%;"></div>
              </div>
              <div class="widget-footer">
                <a href="{{ route('collectors.index') }}" class="text-small mt-10 d-block">Voir Plus <i class="fa fa-arrow-circle-right"></i></a>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class='fa fa-search'></i> Recherche de clients </h3>
            </div>
        
            <div class="card-body">
              <h5 align="center"><b>Nombre de Client(s) :</b> <span id="total_records"></span></h5>
        
                  <div class="row">
                     <div class='col-lg-4 col-md-6 col-sm-12'></div> 
                     
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                      <div class="form-group">
                          <input type="text" name="search" id="search" class="form-control" placeholder="Recherche" />
                      </div>
                    </div>
                    
                     <div class='col-lg-4 col-md-6 col-sm-12'></div>
                  </div>
        
                <div class="dt-responsive">
                  <table id="" class="table">
                      <thead>
                          <tr>
                            <th>Nom</th>
                             <th>Prénoms</th>
                             <th>Email</th>
                             <th>Téléphone</th>
                             <th>Adresse</th>
                             <th>Action</th>
                        </tr>
                       </thead>
                       <tbody id="tbody">
        
                       </tbody>
                    </table>
                </div>
        
          </div>
        </div>
    
      <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des nouvelles commandes</h3>
            <!--<a href="{{ route('orders.index') }}" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes</a>-->
        </div>
        
          <div class="card-body">
              
            <div class="dt-responsive">
              <table id="advanced_table" class="table">
                  <thead>
                      <tr>
                          <th style="display: none;">ID</th>
                          <th>Commande N°</th>
                          <th >Client</th>
                          <th>Date dépôt</th>
                          <!--<th style="width: 15%">Date retrait</th>-->
                          <th>Montant</th>
                           <th>Statuts</th>
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
                                <td>{{ $order->order_amount }}</td>
                                <td>
                                  @if ($order->status == 0)
                                  <label class="badge badge-success">Nouveau</label>
                                  @else
                                  <label class="badge badge-success">Payé</label>
                                  @endif
                                </td>
                                <td>
    
                                  <!--<a href="" class="btn btn-success btn-xs"><i class="fa fa-suitcase"></i> Retrait</a>-->
    
                                  <a href="{{ route('orders.show', $order->id) }}" class=""><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>
                                  @can('Admin Permissions')
                                  <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $order->id}})" data-target="#confirm" class=""><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                  @endcan
    
                                </td>
                            </tr>
                            @endforeach     
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  
</div>
@endsection

@push('dashboard')
<script>

 $(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('customer_search.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('#tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  console.log(query);
  /*if(query===''){
    $('tbody').html("");
    $('#total_records').text("");
  }else{
    fetch_customer_data(query);

  }*/
  fetch_customer_data(query);  
 });
});

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
