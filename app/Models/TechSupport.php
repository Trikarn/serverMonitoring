<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'status',
        'text',
        'author',
    ];

    protected $table = 'tech_support';

    public function supports(array $data = [])
    {
        $supports = DB::table($this->table);

        if(array_key_exists('userId',$data)) {
            $supports = $supports->where('author',$data['userId']);
        }

        return $supports->get();
    }

    public function deleteTelegram($id,$userType)
    {
        $result = DB::table($this->table)->where('id',$id);
        if($userType != 'admin') $result = $result->where('owner',Auth()->id());
        return $result->delete();
    }
}
