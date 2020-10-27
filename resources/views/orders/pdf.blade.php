<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name', 'PRESSING')}} | Facture Dépôt</title>
  <!-- Tell the browser to be responsive to screen width -->
  <!-- Latest compiled and minified CSS -->
 
  
</body>
</head>
<body class="">

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Dépôt
          <small>{{ $deposit->deposit_code }}</small>
        </h1>
        <ol class="breadcrumb">
          <li class="active">Nouveau Dépôt</li>
        </ol>
    </section>

<!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> JOSUE GRAPHIC SARL U
            <small class="pull-right">Date: {{ $date }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row" align="center">
        <div class="col-lg-4">
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
        <div class="col-lg-4 ">
          A
          <address>
            <strong>{{ $deposit->client_name }}</strong><br>
            {{ $deposit->client_address }}<br>
            Tél: {{ $deposit->client_phone }}<br>
            Email: {{ $deposit->client_email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-lg-4">
          <b>Dépôt {{ $deposit->deposit_code }}</b><br>
          <br>
          <b>Date du Dépôt:{{ $date }}</b> 
          <br><br>
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
              <th>Désignation</th>
              <th>Description</th>
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
          <p class="lead">Date de Retrait : {{ $deposit->date_retrait }}</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total Net :</th>
                <td>{{ $deposit->total_net }} F.CFA</td>
              </tr>
              <tr>
                <th>Total TTC :</th>
                <td>{{ $deposit->deposit_amount }} F.CFA</td>
              </tr>
              <tr>
                <th>Remise :</th>
                <td>{{ $deposit->discount }} F.CFA</td>
              </tr>
              <tr>
                <th>Taxe :</th>
                <td>{{ $deposit->taxe }} F.CFA</td>
              </tr>
              <tr>
                <th>Montant Payé :</th>
                <td>{{ $deposit->amount_paid }} F.CFA</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-12">

          <h3>CONDITIONS</h3>
          <p>
            Un délai de 30 jours maximum est accordé pour le retrait des effets. Passé ce delai le Pressing n'est plus responsable de vêtements confiés.<br>
            Certains vêtements très délicats demandent des traitements spéciaux. En cas de dommage aux vêtements l'Etablissement paiera au maximum 5 fois le tarif du nettoyage de la pièce. Nous déclinons toutes responsabilités pour : les boutons, les boucles fermeture-éclair ainsi que les vices cachés.  
          </p>

        </div>
      </div>

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

</html>
