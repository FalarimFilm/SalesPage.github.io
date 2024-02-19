<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends SearchableController
{
    private string $title = 'USER';
    private $roles = ['USER', 'ADMIN', 'SALER'];

    function getQuery() : Builder|Relation
    {
        return User::orderBy('email');

    }

    function list(Request $request)
    {
        /*$this->authorize('view', User::class);*/
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);

        return view('user.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'users' => $query->paginate(5),
        ]);
    }

    function filterByTerm(Builder|Relation $query, ?string $term) : Builder|Relation
    {
        if(!empty($term))
        {
            foreach(\preg_split('/\s+/', \trim($term)) as $word)
            {
                $query->where(function(Builder|Relation $innerQuery) use ($word)
                {
                    $innerQuery
                    ->where('email', 'LIKE', "%{$word}%")
                    ->orWhere('name', 'LIKE', "%{$word}%")
                    ->orWhere('role', 'LIKE', "%{$word}%");
                });
            }
        }

        return $query;

    }

    function show($email)
    {
        /*$this->authorize('view', User::class);*/
        $user = $this->find($email);

        return view('user.view', [
            'title' => "{$this->title} : View",
            'user' => $user,
        ]);
    }

    function createForm()
    {

        /*$this->authorize('create', User::class);*/

        return view('user.sing-up', [
            'title' => "{$this->title} : Create",
            'roles' => $this->roles,
        ]);
    }

    function create(Request $request)
    {
        /*$this->authorize('update', User::class);*/
$user = new User();
        $data = $request->getParsedBody();
        $user->name=$data['name'];
        $user->email=$data['email'];
        $user->password = Hash::make($data['password']);
        $user->role=$data['role'];
        $user->save();

        Cart::create([
            'total_price' => 0,
            'user_id' => $user->id
        ]);

        return redirect()->route('homePage')
            ->with('status', "User {$user->email} was created.");

        try{
        } catch(QueryException $excp){
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
                ]);
        }

    }

    function updateForm($email)
    {
        $user = $this->find($email);
       /* $this->authorize('update', User::class);*/

        return view('user.update-form', [
            'title' => "{$this->title} : Update",
            'user' => $user,
            'roles' => $this->roles,
        ]);
    }
    function update(Request $request, $email)
    {
        /*$this->authorize('update', User::class);*/

        try{
        $user = $this->find($email);
        $data = $request->getParsedBody();
        if(!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('user-view' ,['user' => $user->email])
            ->with('status', "User {$user->email} was updated.");
        } catch(QueryException $excp){
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
                ]);
        }
    }

    function delete($email)
    {
        /*$this->authorize('delete', User::class);*/
        try{
        $user = $this->find($email);
        $user->delete();

        return redirect()->route('user-list')
            ->with('status', "User {$user->email} was deleted.");
        } catch(QueryException $excp){
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
                ]);
        }
    }

    function find(string $email)
    {
        return $this->getQuery()->where('email', $email)->firstOrFail();

    }

    public function __construct() {
        $this->middleware('auth')->except('createForm');
    }

    function cratecart()
    {

    }

}
