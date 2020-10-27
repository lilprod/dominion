{{-- \resources\views\stats\search.blade.php --}}
@extends('layouts.app')

@section('title', '| Reporting journalier de collecte par Collecteur')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Reportings</h5>
                    <span>Reporting journalier des Collecteurs</span>
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
                        <a href="#">Reportings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Reporting journalier</li>
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
            <h3 class="card-title">Reporting journalier des Collecteurs</h3>
          </div>

	            <div class="card-body">
	              <div class="row">
                  
	            </div>
            <!-- /.box-body -->

        <div class="table-responsive">
          <h5 align="center"><b>Nombre de collecte(s) :</b> <span id="total_records"></span></h5>
          <table class="table mb-0">
            <thead>
                    <tr>
                       <th>Code</th>
                       <th>Service</th>
                       <th>Prix</th>
                       <th>Actions</th>
                    </tr>
                   </thead>
                   <tbody class="tbody">

                   </tbody>
                   <tfoot>
                      <td align="center" colspan="3"><h5><b>TOTAL</b></h5></td>
                      <td><h5><b><span id="total_amount"></span> F.CFA</b></h5></td>
                    </tfoot>
          </table>
        </div>

        </div>
    </div>
</div>
</div>

@endsection

@push('alldaycollects')
<script type="text/javascript">

// jQuery wait till the page is fullt loaded
  $(document).ready(function (){
    


   function fetch_order_data(query = '')
   {
    $.ajax({
     url:"{{ route('search_allDayCollects') }}",
     method:'GET',
     dataType:'json',
     success:function(data)
     {
      $('tbody').html(data.table_data);
      $('#total_records').text(data.total_data);
      $('#total_amount').text(data.total_amount);
     }
    })
   }
  

   /*$(document).on('change', '#collector_id', function(){
    var query1 = $(this).val();
    console.log(query1);
    fetch_order_data(query1);  
   });*/

  });
</script>
@endpush
