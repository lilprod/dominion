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
                    <span>Vérifier une commande</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Vérifier une commandes</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="row">
            <div class="col-md-12">
            @include('inc.messages')
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Vérifier commande</h3>
                    <a href="{{ route('pending-orders') }}#" class="btn btn-default pull-right"><i class="fa fa-cart-arrow-down"></i> Commandes à collecter</a>
                </div>
                <!-- /.card-header -->

            <form method="POST" action="{{ route('orders.update', $order->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

                    <div class="card-body">


                        <table id="dynamic_field" class="table table-striped table-bordered">
                          <thead>
                              <tr>
                                  <th><label> Désignation</label></th>
                                  <th><label>Description</label></th>
                                  <th><label>Quantité</label></th>
                                  <th><label>Rangement</label></th>
                                  <th><label>Prix Unitaire</label></th>
                                  <th><label>Montant</label></th>
                                  <th><label>Etat</label></th>
                                  <th><button class="btn bg-olive" title="Ajouter Article" id="add" type="button"><i class="fa fa-plus"></i></button> </th>
                              </tr>
                          </thead>

                          <tbody>

                            <tr>

                              <td>
                                <input type="hidden" name="client_id" value="{{$id}}">
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
                                      <option value="Cintre">Cintre</option>
                                      <option value="Plié(e)">Plié(e)</option>
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
                            <td><b>Total</b></td>
                            <td><b class="total"></b></td>

                          </tfoot>

                          

                      </table>
                        <input class="form-check-input" type="radio" {{  $department->status == 1 ? 'checked' : '' }} name="status" id="product_active" value="1">
                    <label class="form-check-label" for="product_active">
                    Actif
                    </label>

                    </div>

                    <div class="card-footer">
                  
                  <input class="btn btn-flat btn-block btn-primary" type="submit" value="Valider Commander">



                  <div class="col-lg-4">
                      <div class="form-group">
                          <label for="amount_paid">Avance</label>
                          <input class="form-control" id="amount_paid" name="amount_paid" type="number" value="" required>
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                          <label for="discount">Remise</label>
                          <input class="form-control" id="nbre" name="discount" type="number" value="" min="0" max="100">
                      </div>
                    </div>

                   <div class="col-lg-4" style="display: none;">
                      <div class="form-group">
                        <label for="date_retrait">Date de Retrait</label>
                        <input class="form-control" id="date_retrait" name="date_retrait" type="date" value="">
                      </div>
                    </div>
                </div>

                </form>

                    <div class="card-footer">
                      <a href="{{ url()->previous() }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Retour </a>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.conte


    @endsection

@push('verif')

@endpush