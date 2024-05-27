<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Module extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // Definir a tabela
    protected $table = 'modules';

    // Definir os campos que serão adicionados
    protected $fillable = ['course_id', 'name', 'hour', 'description'];

    // Criar relacionamento de um para muitos
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Criar relacionamento de um para muitos
    public function classe(): HasMany
    {
        return $this->hasMany(Classe::class);
    }
}
