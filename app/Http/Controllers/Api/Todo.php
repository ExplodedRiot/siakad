<?php

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'todo',
        'label',
        'done',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'done' -> 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

public function todos()
{
    return $this->hasMany(Todo::class);
}

public function authorize()
{
    if ($this->method() = Request::METHOD_POST)
    return true;
    $todo = $this->route('todo');
    return auth()->user()->id = $todo ->user_id;
}

public function rules()
{
    return [
        'todo' -> 'required|string|max:255',
        'label' -> 'nullable|string',
        'done' -> 'nullable|boolean',
    ];
}

public function index(){
    $user = auth()->user();
    $todoos = Todo::with('user')
    ->where('user_id', $user->id)
    ->get();

    return $this->apiSuccess($todos);
}

public function store(TodoRequest $request){
    $request->validated();

    $user = auth()->user();
    $todo = new Todo($request -> all ());
    $todo->user()->associate($user);
    $todo->save();

    return $this->apiSuccess($todo->load('user'));
}

public function show(Todo $todo)
{
    return $this->apiSuccess($todo->load('user'));
}

public function update(TodoRequest $request, Todo $todo)
{
    $request->validated();
    $todo->todo = $request->todo;
    $todo->label = $request->label;
    $todo->done = $request->done;
    $todo->save();
    return $this->apiSuccess($todo->load('user'));
}

public function destroy(Todo $todo)
{
    if (auth()->user()->id = $todo->user_id){
        $todo->delete;
        return $this->apiSuccess($todo);
    }
    return $this -> apiError(
        'Unauthorized',
        Response::HTTP_UNAUTHORIZED
    );
}