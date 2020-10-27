@extends('layouts.app')

@section('title', '| Commandes')

@section('content')



  <div class="page-header noprint">
      <div class="row align-items-end">
          <div class="col-lg-8">
              <div class="page-header-title">
                  <i class="ik ik-file-text bg-blue"></i>
                  <div class="d-inline">
                      <h5>Commandes</h5>
                      <span>Détails d'une commande</span>
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
                      <li class="breadcrumb-item active" aria-current="page">Détails commande</li>
                  </ol>
              </nav>
          </div>
      </div>
  </div>

  <div class="card">
      <!--<div class="card-header"><h3 class="d-block w-100">DOMINION<small class="float-right">Date: {{$date->format('d/m/Y ')}}</small></h3></div>-->
      <div class="card-body">
          <br><br><br><br><br><br>
          <div class="row invoice-info">
               
              <div class="col-sm-6 invoice-col">
                  <!--De-->
                  <address>
                      Conakry Commune de Ratoma <br>
                      Taouyah / Carrefour Transit <br><strong>Tel : (+224) 621 11 11 80</strong> <br><!--Email: info@dominion.com-->
                  </address>
              </div>
              <!--<div class="col-sm-4 invoice-col">
                  A
                  <address>
                      <strong>{{ $order->client_name }} {{ $order->client_firstname }}</strong><br>Téléphone: {{ $order->client_phone }}<br>Email: {{ $order->client_email }}<br>{{ $order->client_address }}
                  </address>
              </div>-->
              <div class="col-sm-6 invoice-col">
                  <!--<b>Invoice #007612</b><br>
                  <br>-->
                  <!--<b>Code Commande:</b> {{ $order->order_code}}<br>-->
                  <p><b>Date: </b>{{$date->format('d/m/Y ')}}</p>
                  <p><b>RECU N° :</b> {{$order->id}} / {{ $order->created_at->format('m/Y ') }}</p>
                  
                  <!--<b>Date de dépôt:</b> {{$order->created_at->format('d/m/Y ')}} <br>-->
                  <!--<b>Account:</b> 968-34567-->
              </div>
          </div>

          <div class="row">
            <div class="col-6">
              <p><strong>Dépôt pour :</strong> {{ $order->action }}</p>
              <p><strong> Type de service :</strong> {{ $order->service_title }}</p>
              
              @if($order->meeting_place != '')
              <p><strong> Lieu de collecte :</strong> {{ $order->meeting_place }}</p>
              @endif
            </div>

            <br><br>
            <div class="col-6">
              @if($order->weight != '')
              <p><strong>Nombre de Kilo(s) : </strong>{{ $order->weight }}</p>
              @endif
              
              @if($order->place_delivery != '')
              <p><strong> Lieu de livraison :</strong> {{ $order->place_delivery }}</p>
              @endif
            </div>
            
            
            <div class="col-6">
                <p><strong>Nom : </strong>{{ $order->client_name }} {{ $order->client_firstname }}</p>
            </div>
            
            <div class="col-6">
                <p><strong>Tel :</strong> {{ $order->client_phone }}</p>
            </div>
            
          </div><br><br>

          <div class="row">
            @if(count($depositedarticles)>0)

              <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered nowrap">
                      <thead>
                          <tr>
                              <th>Qté</th>
                              <th>Désignation</th>
                              <th>Rangement</th>
                              <th>Etat</th>
                              <th>P.U</th>
                              <th>Total</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($depositedarticles as $depositedarticle)
                          <tr>
                              <td>{{ $depositedarticle->quantity }}</td>
                              <td>{{ $depositedarticle->article_title }}</td>
                              <td>{{ $depositedarticle->tidy }}</td>
                              <td>{{ $depositedarticle->etat }}</td>
                              <td>{{ $depositedarticle->unit_price }}</td>
                              <td>{{ $depositedarticle->amount }}</td>
                          </tr>
                        @endforeach
                        <tr>
                            <th colspan="5" style="text-align: right;">Net à payer :</th>
                            <td>{{ $order->order_amount }} F.CFA</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
  
          @endif

          </div><br>

          <div class="row">
              <!--<div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="../img/credit/visa.png" alt="Visa">
                  <img src="../img/credit/mastercard.png" alt="Mastercard">
                  <img src="../img/credit/american-express.png" alt="American Express">
                  <img src="../img/credit/paypal2.png" alt="Paypal">
                  
                  <div class="alert alert-secondary mt-20">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </div>
              </div>-->
              <!--<div class="col-6">
                   <div class="table-responsive">
                      <table class="table">
                         <tr>
                              <th style="width:50%">Total Net:</th>
                              <td>{{ $order->total_net }} F.CFA</td>
                          </tr>-->
                          <!--<tr>
                              <th>Tax (9.3%)</th>
                              <td>$10.34</td>
                          </tr>
                          @if($order->discount != '')
                          <tr>
                              <th>Remise :</th>
                              <td>{{ $order->discount }} %</td>
                          </tr>
                          @endif
                          <tr>
                            <th>Net à payer:</th>
                            <td>{{ $order->order_amount }} F.CFA</td>
                          </tr>
                      </table>
                  </div>
                 
              </div>-->
              
              <div class="col-12">
                  <p><center><strong>PAIEMENT MARCHAND : *144*6*……….*MONTANT*CODE SECRET# ok </strong></center></p>
              </div>
              
              <div class="col-12">
                   @if($order->delivery_date !='')
                  <p><strong>Retrait le : </strong> {{$order->delivery_date->format('d/m/Y ')}} </p>
                  @endif
             </div>
             
             <div class="col-6">
                 <p><strong>Avance : </strong> {{ $order->amount_paid }}</p>
             </div>
                 
             <div class="col-6">
                 <p><strong>Reste : </strong> {{ $order->left_pay }}</p>
                 
             </div>
              
              <div class="col-12">
                <p><b>NB:</b> Chers clients, le délai de livraison est de <b>trois (03)</b> jours. Toutes commandes non retirées après
                <b>quarante-cinq (45)</b> jours, la maison n'est plus responsable des dégâts sur les linges. En cas de perte du
                    reçu, la carte d'identité est exigée. Le Pressing n'accepte pas les retraits en détail. En cas de
                    détérioration les remboursements ne dépassent pas <b>trois (03)</b> fois le prix du lavage.
                    </p>
            </div>
          </div>
          <div class="row no-print noprint">
              <div class="col-12">
                  <!--<button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                  <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>-->

                  <a href="{{ route('dashboard') }}" class="btn btn-primary pull-right">
                  <i class="ik ik-bar-chart-2"></i> Dashboard</a>
              </div>
          </div>
      </div>
  </div>

  @endsection