<?php

namespace App\Http\Controllers;

use App\Opayment;
use Illuminate\Http\Request;
Use Charts;
use Carbon\Carbon;
use App\User;
use DB;


class ChartController extends Controller
{
    public function makeChart()
 {
  $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May','June','July','Aug','Sept','Oct','Nov','Dec');
  
  $viewer = Opayment::select(DB::raw("SUM(amount) as count"))
  ->orderBy("created_at")
  ->groupBy(DB::raw("month(created_at)"))
  ->get()->toArray();
$viewer = array_column($viewer, 'count');

$data  = $viewer ;

  return view('chart',['Months' => $month, 'Data' => $data]);
 }
}
