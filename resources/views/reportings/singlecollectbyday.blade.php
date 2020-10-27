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
                    <span>Reporting journalier du Collecteur</span>
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
            <h3 class="card-title">Reporting Journalier par Collecteur</h3>
          </div>

            <form role="form" method="POST" action="">
            	@csrf
	            <div class="card-body">
	              <div class="row">
                  <div class="col-lg-3"></div>

                    <div class="col-lg-6">
                      <h5 class="text-center">Recherche de collecteur</h5><hr>
                        <input type="hidden" name="collector_id" id="collector_id"  class="form-control">
                        <div class="form-group">
                            <!--<label>Nom du client</label>-->
                            <input type="text" name="collector" id="collector" placeholder="Entrer le nom du collecteur" class="form-control">
                        </div>
                        <div id="collector_list"></div>                    
                    </div>

                    <div class="col-lg-3"></div>
	              </div>
	            </div>
            <!-- /.box-body -->
        	</form>

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

@endsection

@push('getcollector')
<script type="text/javascript">

// jQuery wait till the page is fullt loaded
  $(document).ready(function (){
      // keyup function looks at the keys typed on the search box
      $('#collector').on('keyup',function() {
          // the text typed in the input field is assigned to a variable 
          var query = $(this).val();
          // call to an ajax function
          if(query ==''){

            $('#collector_list').html("");
            $('#collector_id').val() = '';
          }else{

              $.ajax({
                // assign a controller function to perform search action - route name is search
                url:"{{ route('getCollector') }}",
                // since we are getting data methos is assigned as GET
                type:"GET",
                // data are sent the server
                data:{'collector':query},
                // if search is succcessfully done, this callback function is called
                success:function (data) {
                    // print the search results in the div called country_list(id)
                    $('#collector_list').html(data);
                }
            })
            // end of ajax call
          }
      });


// initiate a click function on each search result
$(document).on('click', 'li', function(){
    // declare the value in the input field to a variable
    var value = $(this).text();
    // assign the value to the search box
    $('#collector_id').val($(this).attr('data-id'))
    var  query1 = $('#collector_id').val();
    //console.log($('#collector_id').val());
    $('#collector').val(value);
    // after click is done, search results segment is made empty
    $('#collector_list').html("");
    fetch_order_data(query1); 
  });

   //fetch_order_data();

   function fetch_order_data(query = '')
   {
    $.ajax({
     url:"{{ route('search_singleDayCollect') }}",
     method:'GET',
     data:{query:query},
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
