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