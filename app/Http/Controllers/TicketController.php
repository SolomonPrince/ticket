<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Interfaces\TicketInterface;
use Exception;
use App\Models\Ticket;
use App\Jobs\SendEmailJob;

class TicketController extends ParentController
{
    private TicketInterface $ticket_repo;
    
    public function __construct(TicketInterface $ticket_repo){
        $this->ticket_repo = $ticket_repo;
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function getTickets(Request $request)
    {
        try {
            $tickets = $this->ticket_repo->getTicket($request->all());
        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($tickets, 'Successfully', 200);
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function update(TicketUpdateRequest $request, $id)
    {
        try{
            if(auth("sanctum")->check()){
                $ticket = Ticket::find($id);
                if($ticket->status == "Resolved"){
                    return $this->sendError("Ticket already closed", 409);
                }
                if($request->status == "Active"){
                    dispatch(new SendEmailJob($ticket->email, $request->email_comment));
                }else{
                    $ticket->update(['comment' => $request->comment, 
                                    'status' => 'Resolved', 
                                    'responsible_id' => auth("sanctum")->user()->id]);  
                }
            }else{
                return $this->sendError("User not authentication", 401);
            }
        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($ticket, 'Ticket successfully updated', 200);
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function create(TicketRequest $request)
    {
        try {
            $data = $request->only('name', 'email', 'message');
            if(auth("sanctum")->check()){
                $user = auth("sanctum")->user();
                $data["name"] = isset($data["name"]) ? $data["name"] : $user->name;
                $data["email"] = isset($data["email"]) ? $data["email"] : $user->email;
                $data["user_id"] = $user->id;
            }

            $ticket = Ticket::create($data);
        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($ticket, 'Ticket successfully created', 201);

    }

    /**
     * 
     * 
     * 
     * 
     */
    public function delete($id)
    {
        try{
            if(auth("sanctum")->check()){
                $ticket = Ticket::where(['id' => $id, 'responsible_id' => auth("sanctum")->user()->id])->first();
                if($ticket){
                    $ticket->delete();
                }else{
                    return $this->sendError("User not have delete permission for this ticket", 403);
                }
            }else{
                return $this->sendError("User not authentication", 401);
            }
        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($ticket, 'Ticket successfully deleted', 200);
    }
}
