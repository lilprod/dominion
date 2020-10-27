<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Collector;
use App\User;
use Carbon\Carbon;
use App\CheckedArticle;
use App\DepositedArticle;


class ReportingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function search(Request $request){
        // check if ajax request is coming or not
        if($request->ajax()) {
            $query = $request->get('collector');
            // select country name from database
            $data = DB::table('collectors')
                            ->where('name', 'like', $query.'%')
                            ->orWhere('firstname', 'like', $query.'%')
                            ->get();
            // declare an empty array for output
            $output = '';
            // if searched countries count is larager than zero
            if (count($data) > 0) {
                // concatenate output to the array
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                // loop through the result array
                foreach ($data as $row){
                    // concatenate output to the array
                    $output .= '<li class="list-group-item" data-id="'.$row->id.'">'.$row->name.' '.$row->firstname.'</li>';
                }
                // end of output
                $output .= '</ul>';
            }
            else {
                // if there's no matching results according to the input
                $output .= '<li class="list-group-item">'.'Pas de collecteur trouvé'.'</li>';
            }
            // return output result array
            return $output;
        }
    }



    public function search_singleDayCollect(Request $request){
    	
    if($request->ajax())
     {
      $output = '';
      $total_amount = 0;
      $query = $request->get('query');
      $now = Carbon::today()->toDateString();

      if($query != '')
      {
       $data = DB::table('orders')
                ->where('collector_id', '=', $query)
                ->whereDate('date_collect', '=', $now)
                ->get();
      }
      /* else
      {
       $data = DB::table('orders')
         ->orderBy('id', 'desc')
         ->limit(10)
         ->get();  

         $data = [];

        
      } */ 
      foreach($data as $row1){
         $total_amount += $row1->order_amount;
       }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->order_code.'</td>
         <td>'.$row->service_title.'</td>
         <td>'.$row->order_amount.'</td>
         <td><a href="'.route('orders.show', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Voir Plus</a></td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="3">Aucune collete trouvée pour ce collecteur</td>
        <td><a href="'.route('pending-orders').'" class="btn btn-primary btn-xs"><i class="fa fa-smile-o"></i> Commandes à collecter</a></td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row,
       'total_amount'  => $total_amount,
      );

      echo json_encode($data);
     }
    }

    public function search_globalByCollector(Request $request){

    if($request->ajax()){

    	$output = '';
      	$total_amount = 0;
      	$query = $request->get('query');

            if($request->from_date != '' && $request->to_date != ''  && $request->query != '')
            {
                $data = DB::table('orders')
                			->where('collector_id', '=', $query)
                            ->whereBetween('date_collect', array($request->from_date, $request->to_date))
                            ->get();
            }
            foreach($data as $row1){
	         	$total_amount += $row1->order_amount;
	       	}

           $total_row = $data->count();
		      if($total_row > 0)
		      {
		       foreach($data as $row)
		       {
		        $output .= '
		        <tr>
		         <td>'.$row->order_code.'</td>
		         <td>'.$row->service_title.'</td>
		         <td>'.$row->order_amount.'</td>
		         <td><a href="'.route('orders.show', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Voir Plus</a></td>
		        </tr>
		        ';
		       }
		      }
		      else
		      {
		       $output = '
		       <tr>
		        <td align="center" colspan="3">Aucune collete trouvée pour ce collecteur</td>
		        <td><a href="'.route('pending-orders').'" class="btn btn-primary btn-xs"><i class="fa fa-smile-o"></i> Commandes à collecter</a></td>
		       </tr>
		       ';
		      }
		      $data = array(
		       'table_data'  => $output,
		       'total_data'  => $total_row,
		       'total_amount'  => $total_amount,
		      );

            echo json_encode($data);
        }
    }

    public function singleCollectbyDay()
    {
        return view('reportings.singlecollectbyday');
    }

    public function allCollectbyDay()
    {
        return view('reportings.allcollectsbyday');
    }

    public function singleCollects()
    {
        return view('reportings.singlecollects');
    }

    public function allCollects()
    {
        return view('reportings.allcollects');
    }

    public function search_allDayCollects(Request $request)
    {

    if($request->ajax())
     {
      $output = '';
      $total_amount = 0;
      $now = Carbon::today()->toDateString();

      if($query != '')
      {
       $data = DB::table('orders')
                ->whereDate('date_collect', '=', $now)
                ->get();
      }
      
      foreach($data as $row1){
         $total_amount += $row1->order_amount;
       }

      $total_row = $data->count();

      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->order_code.'</td>
         <td>'.$row->service_title.'</td>
         <td>'.$row->order_amount.'</td>
         <td><a href="'.route('orders.show', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Voir Plus</a></td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="3">Aucune collete trouvée pour ce collecteur</td>
        <td><a href="'.route('pending-orders').'" class="btn btn-primary btn-xs"><i class="fa fa-smile-o"></i> Commandes à collecter</a></td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row,
       'total_amount'  => $total_amount,
      );

      echo json_encode($data);
     }
    }


    public function search_globalCollectors(Request $request)
    {
    	if($request->ajax()){

    	$output = '';
      	$total_amount = 0;

            if($request->from_date != '' && $request->to_date != '')
            {
                $data = DB::table('orders')
                            ->whereBetween('date_collect', array($request->from_date, $request->to_date))
                            ->get();
            }
            foreach($data as $row1){
	         	$total_amount += $row1->order_amount;
	       	}

           $total_row = $data->count();
		      if($total_row > 0)
		      {
		       foreach($data as $row)
		       {
		        $output .= '
		        <tr>
		         <td>'.$row->order_code.'</td>
		         <td>'.$row->service_title.'</td>
		         <td>'.$row->order_amount.'</td>
		         <td><a href="'.route('orders.show', $row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Voir Plus</a></td>
		        </tr>
		        ';
		       }
		      }
		      else
		      {
		       $output = '
		       <tr>
		        <td align="center" colspan="3">Aucune collete trouvée pour ce collecteur</td>
		        <td><a href="'.route('pending-orders').'" class="btn btn-primary btn-xs"><i class="fa fa-smile-o"></i> Commandes à collecter</a></td>
		       </tr>
		       ';
		      }
		      $data = array(
		       'table_data'  => $output,
		       'total_data'  => $total_row,
		       'total_amount'  => $total_amount,
		      );

            echo json_encode($data);
        }
    }
   
}
