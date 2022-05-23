<?php

namespace App\Http\Controllers\API;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    public function get_transactions_today(Request $request)
    {

        $tickets = new Ticket();
        $tickets->finalOrderStore($request);
        
    }
}
