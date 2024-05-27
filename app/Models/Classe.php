<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Classe extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // Definir a tabela
    protected $table = 'classes';

    // Definir os campos que são preenchidos
    protected $fillable = ['module_id', 'name', 'video', 'view', 'order_classe', 'pdf'];

    // Criar relacionamento de um para muitos
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
