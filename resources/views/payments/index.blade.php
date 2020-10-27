@extends('layouts.app')

@section('title', '| Paiements')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Paiements</h5>
                    <span>Liste des paiemnts</span>
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
                        <a href="#">Paiements</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des paiements</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

    <!-- Main content -->

    <div class="row">
    <div class="col-md-12">
      @include('inc.messages')
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Paiements</h3>
                <a href="{{ route('services.create') }}" class="btn btn-default pull-right"><i class='fa fa-plus-square'></i>  Ajouter un service</a>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th>Commande N°</th>
                            <th>Descripitons</th>
                            <th>Mode de paiments</th>
                            <th>Montants</th>
                            <th>Infos Client</th>
                            <th>Date/Heure d'Ajout</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>

                            <td>{{ $payment->order_code }}</td>
                            <td>{{ $payment->description }}</td>
                            <td>{{ $payment->paymentmode_title }}</td>
                            <td>{{ $payment->order_amount }}</td>
                            <td>
                                <p>{{ $payment->client_name }} {{ $payment->client_firstname }}</p>
                                <p>{{ $payment->client_phone }}</p>
                            </td>
                            <td>{{ $payment->created_at->format('F d, Y h:ia') }}</td>
                            <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="" style="margin-right: 3px;"><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>
                     
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="card-footer clearfix">
              <a href="{{ url()->previous() }}" class="btn btn-primary"><i class='fa fa-arrow-left'></i>  Retour</a>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

@endsection
