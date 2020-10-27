@extends('layouts.app')

@section('title', '| Commandes')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Commandes</h5>
                    <span>Nouvelle commande</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Nouvelle commande</li>
                </ol>
            </nav>
        </div>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
      @include('inc.messages')
      <div class="card">
          <div class="card-header with-border">
              <h3 class="card-title">Nouvelle commande</h3>
              <a href="{{ route('pending-orders') }}#" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes à collecter</a>
          </div>
          <!-- /.card-header -->

      <form method="POST" action="{{ route('recordorder') }}" enctype="multipart/form-data">
      {{ csrf_field() }}

              <div class="card-body">

                <div class="col-sm-12">

                  <div class="form-group row">

                    <input type="hidden" name="client_id" value="{{$id}}">

                    <div class="col-sm-6">
                      <label>Type de service</label>
                        <select class="form-control" id="service_id" name="service_id" required>
                          @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->title}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6">
                      <label> Dépôt à faire</label>
                      <select class="form-control action" id="action" name="action" required>
                          <option value="nettoyage_price">Nettoyage et Repassage</option>
                          <option value="lavage_price">Nettoyage Express</option>
                          <option value="repassage_price">Repassage</option>
                      </select>
                   </div>
                   
                  </div>

                </div>

                  <table id="dynamic_field" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><label>Désignation</label></th>
                            <th><label>Description</label></th>
                            <th><label>Quantité</label></th>
                            <th><label>Rangement</label></th>
                            <th><label>Prix Unitaire</label></th>
                            <th><label>Montant</label></th>
                            <th><label>Etat</label></th>
                            <th><button class="btn btn-primary" title="Ajouter Article" id="add" type="button"><i class="fa fa-plus"></i></button> </th>
                        </tr>
                    </thead>

                    <tbody>

                      <tr>

                        <td>
                          <div class="form-group">
                            <select class="form-control article" id="article_id[]" name="article_id[]" required>
                              @foreach($articles as $article)
                                <option value="{{$article->id}}">{{$article->title}}</option>
                              @endforeach
                            </select>
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <input class="form-control" name="designation[]" type="text" value="" id="designation[]">
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <input class="form-control qty" name="quantity[]" type="number" value="" id="quantity" required>
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <select class="form-control tidy" id="tidy" name="tidy[]" required>
                                <option value="Plier">Plier</option>
                                <option value="Cintrer">Cintrer</option>
                            </select>
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <input class="form-control price" name="price[]" type="number" value="" id="price[]" required>
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <input class="form-control amount" name="amount[]" type="number" value="" id="amount[]">
                          </div>
                        </td>
                       
                        <td style="width: 15%">
                          @foreach ($etats as $etat)
                            <input name="etats_0[]" type="checkbox" value="{{$etat->id}}">
                            <label>{{$etat->title, ucfirst($etat->title)}}</label><br>
                          @endforeach
                        </td>
                        <td style="border: none;"></td>

                      </tr>
                    </tbody>

                    <tfoot>
                      <td style="border: none;"></td>
                      <td style="border: none;"></td>
                      <td style="border: none;"></td>
                      <td style="border: none;"></td>
                      <td style="border: none;"></td>
                      <td style="border: none;"></td>
                      <td><b>Total</b></td>
                      <td><b class="total"></b></td>

                    </tfoot>

                </table>

                <div class="col-sm-12">

                    <div class="form-group row">

                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="amount_paid">Montant payé</label>
                          <input class="form-control" id="amount_paid" name="amount_paid" type="number" value="" required>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="discount">Remise</label>
                          <input class="form-control" id="nbre" name="discount" type="number" value="" min="0" max="100">
                      </div>
                    </div>

                   <div class="col-sm-4" style="display: none;">
                      <div class="form-group">
                        <label for="date_retrait">Date de Retrait</label>
                        <input class="form-control" id="date_retrait" name="date_retrait" type="date" value="">
                      </div>
                    </div>

                  </div>
                </div>


          </div>

          <div class="card-footer">

            <input class="btn btn-flat btn-block btn-primary" type="submit" value="Valider Commande">

          </div>

          </form>

          </div>
      </div>
  </div>


    @endsection

@push('create')

<script type="text/javascript">

$(document).ready(function(){  
      var i=1; 
      $('#add').click(function(){ 
           $('#dynamic_field').append('<tr id="row'+i+'"><td><div class="form-group"><select class="form-control article" id="article_id[]" name="article_id[]" required>@foreach($articles as $article)<option value="{{$article->id}}">{{$article->title}}</option>@endforeach</select></div></td><td><div class="form-group"><input class="form-control" name="designation[]" type="text" value="" id="designation[]"></div></td><td><div class="form-group"><input class="form-control qty" name="quantity[]" type="number" value="" id="quantity" required min="0"></div></td><td><div class="form-group"><select class="form-control tidy" id="tidy" name="tidy[]" required><option value="Plier">Plier</option><option value="Cintrer">Cintrer</option></select></div></td><td><div class="form-group"><input class="form-control price" name="price[]" type="number" value="" id="price[]" required></div></td><td><div class="form-group"><input class="form-control amount" name="amount[]" type="number" value="" id="amount[]"></div></td><td style="width: 15%"> @foreach ($etats as $etat)<input name="etats_'+i+'[]" type="checkbox" value="{{$etat->id}}"> <label>{{$etat->title, ucfirst($etat->title)}}</label><br> @endforeach</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
              $('.article').trigger('change');
              i++;
      });  

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();
           total();
      }); 

      $('tbody').delegate('.article','change',function (){
        var tr = $(this).parent().parent().parent();
        var id = tr.find('.article').val();
        var e = $('#action').val();
        var dataId={'id':id, 'unit':e};

        $.ajax({
          type : 'GET',
          url : '{!!URL::route('findPrice')!!}',
          dataType: 'json',
          data : dataId,
          success:function(data){
            //console.log(data)
            tr.find('.price').val(data);
          }
        });
      });

      $('.article').trigger('change');

      $('tbody').delegate('.article','change',function (){
        var tr = $(this).parent().parent().parent();
          tr.find('.qty').focus();
          total();
      });

      $('tbody').delegate('.qty,.price','keyup',function (){
        var tr = $(this).parent().parent().parent();
          var qty= tr.find('.qty').val();
          var price = tr.find('.price').val();
          //console.log(price);
          var amount= (qty * price);
          tr.find('.amount').val(amount);
          total();
      });
 }); 

 function total() 
  {
    var total = 0;
    $('.amount').each(function(i,e){
      var amount = $(this).val()-0;
      total +=amount;
    })
    $('.total').html(total);
  }; 
 </script>

@endpush