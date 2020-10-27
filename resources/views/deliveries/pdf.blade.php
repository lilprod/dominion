<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name', 'PRESSING')}} | Facture Retrait</title>
  <!-- Tell the browser to be responsive to screen width -->
  <!-- Latest compiled and minified CSS -->
  
</head>
<body class="">

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Retrait
          <small>{{ $delivery->delivery_code }}</small>
        </h1>
        <ol class="breadcrumb">
          <li class="active">Nouveau Retrait</li>
        </ol>
    </section>

<!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> JOSUE GRAPHIC SARL U
            <small class="pull-right">Date: {{ $date->format('d F, Y') }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info" align="center">
        <div class="col-sm-4 invoice-col">
          De
          <address>
            <strong>JOSUE GRAPHIC <small>SARL U</small></strong><br>
            <strong>Département : Habillement, Pressing, Prêt-à-Porter, Location de Voitures, Representation et Négoce </strong><br>
            Nyékonakpoè, dans le von de l'ancien Night Club 907
            à coté de l'Ecole Primaire la Victoire<br>
            Tél: (00228) 92 50 44 01 / 91 32 17 17<br>
            Lomé - TOGO
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          A
          <address>
            <strong>{{ $delivery->client_name }}</strong><br>
            {{ $delivery->client_address }}<br>
            Phone: {{ $delivery->client_phone }}<br>
            Email: {{ $delivery->client_email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Dépôt {{ $delivery->delivery_code }}</b><br>
          <br><br>
          <b>Date du Dépôt:</b> {{ $date->format('d F, Y') }}<br><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qté</th>
              <th>Article</th>
              <th>Désignation</th>
              <th>Prix Unitaire</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($depositedarticles as $depositedarticle)
            <tr>
              <td>{{ $depositedarticle->quantity }}</td>
              <td>{{ $depositedarticle->article_title }}</td>
              <td>{{ $depositedarticle->designation }}</td>
              <td>{{ $depositedarticle->unit_price }}</td>
              <td>{{ $depositedarticle->amount }}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Date du Retrait : {{ $delivery->date_retrait }}</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Total TTC:</th>
                <td>{{ $delivery->deposit_amount }} F.CFA</td>
              </tr>
              <tr>
                <th>Remise :</th>
                <td>{{ $delivery->discount }} F.CFA</td>
              </tr>
              <tr>
                <th>Montant Payé :</th>
                <td>{{ $delivery->amount_paid }} F.CFA</td>
              </tr>
              <tr>
                <th>Reste à Payer:</th>
                <td>{{ $delivery->left_pay }} F.CFA</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p>
            <strong>Nom et Signature de la Receptionniste</strong>
          </p>
        </div>

      </div>
    </section>
    <!-- /.content -->


    <footer class="main-footer center">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong>Copyright &copy; 2019 <a href="#">Developpé par</a> <a href="#">SPARK CORPORATION</a>.</strong> All rights
        reserved.
        </div>
        <!-- /.container -->
      </footer>

</body>
</html>
