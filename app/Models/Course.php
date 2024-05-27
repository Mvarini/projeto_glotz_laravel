<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Course extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // Indicar o nome da tabela
    protected $table = 'courses';

    // Indicar quais colunas são preenchidas manualmente
    protected $fillable = ['teacher_id', 'name', 'hour', 'cover', 'price', 'description'];

    // Criar relacionamento de um para muitos
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    // Criar relacionamento de um para muitos
    public function module(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
