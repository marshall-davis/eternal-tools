<?php
/**
 * Date: 2018-03-28
 * Time: 02:08
 */

namespace App\Http\Controllers;


use App\Github\Client;
use App\Github\Issue;
use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    public function create(Request $request, Client $github)
    {
        /** @var array $responseData */
        $responseData = [];

        // TODO Input validation.
        /** @var Issue $issue */
        $issue = $github->createIssue(
            $request->input('title'),
            $request->input('body'),
            collect($request->input('labels'))
        );

        if ($issue) {
            /** @var Ticket $ticket */
            $ticket = Ticket::create([
                'github_id' => $issue->getNumber(),
                'email'     => $request->input('email'),
            ]);
            // TODO Build these from the response? Possibly have them maintained via the Github API.
//            $ticket->labels()->saveMany(Label::find($request->input('labels')));

            $responseData = [
                'ticket'     => $ticket->id,
                'subscribed' => $ticket->email ? true : false,
            ];
            $responseStatus = Response::HTTP_CREATED;
        } else {
            $responseStatus = Response::HTTP_BAD_REQUEST;
        }

        return response()->json(
            $responseData,
            $responseStatus
        );
    }
}
