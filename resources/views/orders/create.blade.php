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
                    <span>Etiqueter une commande</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Etiqueter une commandes</li>
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
                    <h3 class="card-title">Etiqueter commande</h3>
                    <a href="{{ route('pending-orders') }}#" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes à collecter</a>
                </div>
                <!-- /.card-header -->

            <form method="POST" action="{{ route('kilodetail') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

                    <div class="card-body">


                      <div class="col-sm-12">
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label>Type de service</label>
                                <input class="form-control" name="service_title" type="text" value="{{$order->service_title}}" required>
                          </div>

                          <div class="col-sm-6">
                            <label>Poids</label>
                                <input class="form-control" name="weight" type="text" value="{{$order->weight}}" required>
                          </div>
                        </div>
                      </div>

                        <table id="dynamic_field" class="table table-striped table-bordered">
                          <thead>
                              <tr>
                                  <th><label> Désignation</label></th>
                                  <th><label>Description</label></th>
                                  <th><label>Quantité</label></th>
                                  <th><label>Rangement</label></th>
                                  <th><label>Etat</label></th>
                                  <th><button class="btn btn-primary" title="Ajouter Article" id="add" type="button"><i class="fa fa-plus"></i></button> </th>
                              </tr>
                          </thead>

                          <tbody>

                            <tr>

                              <td>
                                <input type="hidden" name="order_id" value="{{$order->id}}">
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
                             
                              <td style="width: 15%">
                                @foreach ($etats as $etat)
                                  <input name="etats_0[]" type="checkbox" value="{{$etat->id}}">
                                  <label>{{$etat->title, ucfirst($etat->title)}}</label><br>
                                @endforeach
                              </td>
                              <td style="border: none;"></td>

                            </tr>
                          </tbody>
                      </table>

                      <div class="col-sm-12">

                          <div class="form-group row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="amount_paid">Montant payé</label>
                                <input class="form-control" id="amount_paid" name="amount_paid" type="number" value="{{$order->order_amount}}" required>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                                <label for="discount">Remise</label>
                                <input class="form-control" id="nbre" name="discount" type="number" value="{{$order->discount}}" min="0" max="100">
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

                  <input class="btn btn-flat btn-block btn-primary" type="submit" value="Valider Commander">

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
           $('#dynamic_field').append('<tr id="row'+i+'"><td><div class="form-group"><select class="form-control article" id="article_id[]" name="article_id[]" required>@foreach($articles as $article)<option value="{{$article->id}}">{{$article->title}}</option>@endforeach</select></div></td><td><div class="form-group"><input class="form-control" name="designation[]" type="text" value="" id="designation[]"></div></td><td><div class="form-group"><input class="form-control qty" name="quantity[]" type="number" value="" id="quantity" required min="0"></div></td><td><div class="form-group"><select class="form-control tidy" id="tidy" name="tidy[]" required><option value="Cintre">Cintre</option><option value="Plie">Vêtement Plié</option></select></div></td><td style="width: 15%"> @foreach ($etats as $etat)<input name="etats_'+i+'[]" type="checkbox" value="{{$etat->id}}"> <label>{{$etat->title, ucfirst($etat->title)}}</label><br> @endforeach</td><td><button type="button" name="remove" id="'+i+'" class="btn bg-red btn_remove">X</button></td></tr>'); 
              $('.article').trigger('change');
              i++;
      });  

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();
           total();
      }); 

      $('.article').trigger('change');

      $('tbody').delegate('.article','change',function (){
        var tr = $(this).parent().parent().parent();
          tr.find('.qty').focus();
          //total();
      });
 });  
 </script>

@endpush