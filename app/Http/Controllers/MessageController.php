<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Auth;
use App\Events\MessageSentEvent;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::with('user')->orderBy('created_at')->get();

        return response()->json($messages, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = Auth::user();
        //
        // $message = $user->messages()->create([
        //     'message' => $request->input('message'),
        //     'receiver_id' => $request->receiver_id
        // ]);

        $message = Message::create($request->all());
        $response = [
          'message'   => 'message sent',
          'data'      => $message
        ];

        $user = User::find($request->user_id);

        broadcast(new MessageSentEvent($message, $user))->toOthers();

        return response()->json($response, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $message = Message::with('user')->where(['user_id' => auth()->id(), 'receiver_id' => $user->id])->orWhere(function($query) use($user){
          $query->where(['user_id' => $user->id, 'receiver_id' => auth()->id()]);
        })->get();

        return response()->json($message, Response::HTTP_CREATED);
        // return $message;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
