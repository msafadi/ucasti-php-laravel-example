<?php

namespace App\Http\Controllers\Auth;

use App\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('auth.api-token.index', [
            'tokens' => $user->apiTokens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('auth.api-token.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $token = $user->apiTokens()->create([
            'name' => $request->post('name'),
            'token' => Str::random(70),
        ]);


        /*$user = Auth::user();
        $user->api_token = Str::random(80);
        $user->save();*/

        return redirect()->route('api-token.list')
                         ->with('message', 'Token created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user = Auth::user();
        $token = $user->apiTokens()->findOrFail($id);

        /*$token = ApiToken::findOrFail($id);
        if ($token->user_id != $user->id) {
            abort(403);
        }*/

        return view('auth.api-token.edit', [
            'token' => $token,
        ]);
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
        $user = Auth::user();
        $token = $user->apiTokens()->findOrFail($id);
        $token->name = $request->post('name');
        $token->save();

        /*$user = Auth::user();
        $user->api_token = Str::random(80);
        $user->save();*/

        return redirect()->route('api-token.list')
                         ->with('message', 'Token updated!');
    }

    public function regenerate(Request $request, $id)
    {
        $user = Auth::user();
        $token = $user->apiTokens()->findOrFail($id);

        $token->token = Str::random(70);
        $token->save();

        return redirect()->route('api-token.list')
                         ->with('message', 'Token key updated!');
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
        $user = Auth::user();
        $token = $user->apiTokens()->findOrFail($id);
        $token->delete();

        /*$user = Auth::user();
        $user->api_token = null;
        $user->save();*/

        return redirect()->route('api-token.list')
                         ->with('message', 'Token Deleted!');
    }
}
