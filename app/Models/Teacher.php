<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;


class Teacher extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // Indicar o nome da tabela
    protected $table = 'teachers';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = ['first_name', 'last_name', 'signature'];


    // Criar relacionamento de um para muitos
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
