{{-- \resources\views\stats\search.blade.php --}}
@extends('layouts.app')

@section('title', '| Recherche sur Dépôt par client')

@section('content')

<!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Reportings</h5>
                    <span>Reporting par période du Collecteur</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Reporting par période</li>
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
              <h3 class="card-title">Reporting par période du Collecteur</h3>
            </div>

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

                <div class="row">
                        <div class="col-lg-6">
                         <div class="input-group input-daterange">
                             De <input type="date" name="from_date" id="from_date" class="form-control" />
                             <div class="input-group-addon">A</div>
                             <input type="date"  name="to_date" id="to_date" class="form-control" />
                         </div>
                        </div>

                        <div class="col-lg-4">
                         <button type="button" name="filter" id="filter" class="btn btn-info">Filtrer</button>
                         <button type="button" name="refresh" id="refresh" class="btn btn-warning">Actualiser</button>
                        </div>
                  </div>

                  <br>
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
            <!-- /.card-body -->
          </div>
      </section>

@endsection

@push('periodsinglecollector')
<script type="text/javascript">

// jQuery wait till the page is fullt loaded
$(document).ready(function () {
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
    //console.log($('#collector_id').val());
    $('#collector').val(value);
    // after click is done, search results segment is made empty
    $('#collector_list').html("");
  });
 
 var date = new Date();
 document.getElementById('to_date').valueAsDate = date;

 var _token = $('input[name="_token"]').val();

 fetch_data();

 function fetch_data(from_date = '', to_date = '', query = '')
 {
  $.ajax({
   url:"{{ route('search_globalByCollector') }}",
   method:"POST",
   data:{from_date:from_date, to_date:to_date, query:query, _token:_token},
   dataType:"json",
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
    $('#total_amount').text(data.total_amount);
   }
  })
 }


 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  var  query = $('#collector_id').val();
  if(from_date != '' &&  to_date != '' &&  query != '')
  {
   fetch_data(from_date, to_date, query);
  }
  else
  {
   alert('Les deux dates et le nom du collecteur sont obligatoires!');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#collector').val('');
  $('#collector_id').val('');
  fetch_data();
 });
});
</script>
@endpush
