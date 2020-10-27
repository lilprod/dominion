@extends('layouts.app')

@section('title', '| Livraisons')

@section('content')

<style type="text/css">
    @media print{
      @page { margin: 0; }
      body{ margin: 1.6cm; }
    }
  </style> 

  <div class="page-header noprint">
      <div class="row align-items-end">
          <div class="col-lg-8">
              <div class="page-header-title">
                  <i class="ik ik-file-text bg-blue"></i>
                  <div class="d-inline">
                      <h5>Livraisons</h5>
                      <span>Détails d'une livraison</span>
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
                          <a href="#">Livraisons</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">Détails de livraison</li>
                  </ol>
              </nav>
          </div>
      </div>
  </div>

    <!--<div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        Pour imprimer cette page, veuillez cliquer sur le bouton d'impression en bas de la facture.
      </div>
    </div>-->

<!-- Main content -->
    <div class="card">
      <!--<div class="card-header"><h3 class="d-block w-100">DOMINION<small class="float-right">Date: {{$date->format('d/m/Y ')}}</small></h3></div>-->
      <div class="card-body">
          <br><br><br><br><br><br>
      <!-- info row -->
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
                <b>{{ $delivery->client_name }} {{ $delivery->client_firstname }}</b><br>Téléphone: {{ $delivery->client_phone }}<br>Email: {{ $delivery->client_email }}<br>{{ $delivery->client_address }}
            </address>
        </div>-->
        <div class="col-sm-6 invoice-col">
            <!--<b>Invoice #007612</b><br>
            <br>-->
            <p><b>Date: </b>{{$date->format('d/m/Y ')}}</p>
            <p><b>RECU N° :</b> {{$delivery->order_id}} / {{ $delivery->order_date->format('m/Y ') }}</p>
                  
            <!--<b>Code Commande:</b> {{ $delivery->order_code}}<br>
            <b>Date de dépôt:</b> {{$delivery->order_date->format('d/m/Y ')}} <br>-->
            <!--<b>Account:</b> 968-34567-->
        </div>
        <!-- /.col -->
      </div>
   

      <!--<div class="row">
        <div class="col-6">
          <p><b>RECU N° :</b> {{$delivery->order_id}} / {{ $delivery->order_date->format('m/Y ') }}</p>
          <p><b>Receptionniste :</b> {{ $delivery->server }}</p>
          <p><b>Date du dépôt  :</b> {{ $delivery->order_date->format('d/m/Y ') }}</p>
          <p><b>Dépôt pour :</b> {{ $delivery->action }}</p>
        </div>

        <div class="col-6">
          <p><b>Client :</b> {{ $delivery->client_name }}</p>
          <p><b>Date de retrait : </b> {{ $date->format('d/m/Y ') }}</p>
          <p><b>Code dépôt : </b>{{ $delivery->order_code }}</p>
        </div>

      </div>-->

      <div class="row">
        <div class="col-6">
          <p><b> Type de service :</b> {{ $delivery->service_title }}</p>
          @if($delivery->meeting_place != '')
          <p><b> Lieu de collecte :</b> {{ $delivery->meeting_place }}</p>
          @endif
        </div>

        
        <div class="col-6">
          @if($delivery->weight != '')
            <p><b>Nombre de Kilo(s) : </b>{{ $delivery->weight }}</p>
          @endif

          @if($delivery->place_delivery != '')
          <p><b> Lieu de livraison :</b> {{ $delivery->place_delivery }}</p>
          @endif
        </div>
      </div><br><br>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped table-bordered nowrap">
            <thead>
            <tr>
              <th>Qté</th>
                <th style="width:20%">Désignation</th>
                <th style="width:20%">Rangement</th>
                <th style="width:15%">Etat</th>
                <th>P.U</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($depositedarticles as $depositedarticle)
            <tr>
              <td>{{ $depositedarticle->quantity }}</td>
              <td style="width:20%">{{ $depositedarticle->article_title }}</td>
              <td style="width:20%">{{ $depositedarticle->tidy }}</td>
              <td style="width:15%">{{ $depositedarticle->etat }}</td>
              <td>{{ $depositedarticle->unit_price }}</td>
              <td>{{ $depositedarticle->amount }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="5" style="text-align: right;">Net à payer :</th>
                <td>{{ $delivery->order_amount }} F.CFA</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          <!--<p class="lead">Lu et approuvé</p>-->
          
        </div>
        <!-- /.col -->
        <div class="col-6">
          <!--<p class="lead"></p>-->

          <div class="table-responsive">
               <!-- <p><strong>Date de retrait : </strong> {{$date->format('d/m/Y ')}} </p>-->
              
            <table class="table">
                  @if($delivery->discount != '')
                  <tr>
                      <th>Remise :</th>
                      <td>{{ $delivery->discount }} %</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Montant payé:</th>
                    <td>{{ $delivery->order_amount }} F.CFA</td>
                  </tr>
              </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
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
  <!-- /.content -->

@endsection
