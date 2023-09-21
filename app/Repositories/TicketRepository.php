<?php

namespace App\Repositories;

use App\Interfaces\TicketInterface;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketRepository implements TicketInterface 
{
    protected $ticket;
   
    function __construct(Ticket $ticket) {
        $this->ticket = $ticket;
    }

    /**
     * 
     * 
     */
    public function getTicket($coloction = [])
    {
        $offset = isset($coloction["offset"]) ? $coloction["offset"] : 0;
        $limit = isset($coloction["limit"]) ? $coloction["limit"] : 20;
        $order_date = isset($coloction["date"]) && Str::lower($coloction["date"]) == "asc" ? "asc" : "desc";
        $ticket_list = $this->ticket->orderBy('created_at', $order_date);

        if(isset($coloction["status"])){
            $status = Str::lower($coloction["status"]) == "active" ? "Active" : "Resolved";
            $ticket_list->where('status', $status);
         }
         
        $ticket_list->skip($offset)->take($limit);
        return $ticket_list->get();
    }

   

}