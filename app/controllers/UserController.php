<?php

class UserController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $userData = Input::only(
            'name',
            'surname',
            'email',
            'password',
            'user_level'
        );

        $userData = array_map("htmlentities", $userData);

        $validator = Validator::make($userData, [
            'name' => 'required|alphanum',
            'surname' => 'required|alphanum',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|alphanum|min:5',
            'user_level' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::route('viewAdmin')
                ->with('flash_error', $validator->messages());
        }
        else {
            $userData['password'] = Hash::make($userData['password']);
            $user = User::create($userData);
            return Redirect::route('viewAdmin')
                ->with('success', 'New user: '. $userData["name"] .' created.');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // return null if none is found
        return User::find($id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function login() {
        $userData = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        $validator = Validator::make($userData, 
            [
                'email' => 'required|email',
                'password' => 'required|alphanum|min:5',
            ]
        );

        if ($validator->fails()) {
            return Redirect::route('login')
                ->with(Response::json($validator->messages(), 400));

        } else {
            if(Auth::attempt($userData)) {
                return Redirect::route('home');
            } else {
                return Redirect::route('login')
                    ->with('flash_error', 'Your username/password combination has been rejected.');
            }
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::route('login');
    }

    public function getProfile($id) {

        $user = User::find($id);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'level' => $user->user_level
        ];

        $publicNotes = $notes = Note::where('is_public', '=', true)
                        ->where('user_id', '=', $id)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

        return View::make('viewProfile', compact('userData', 'publicNotes'));
    }

    public function showAdmin() {
        if(User::Find(Auth::user()->id)->user_level == 'ADMIN'){
            return View::make('admin');
        } else {
            return Redirect::route('home')
                            ->with('flash_error', 'You are not authorised to access that area.');;
        }
    }
}