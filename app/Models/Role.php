<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Permission\Models\Role as SpatieRole;

use App\Models\User;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Traits\RoleFilterable;

class Role extends SpatieRole
{

    // este metodo verifica si el rol actual esta asociado o no con algun usuario
    public function canDelete()
    {
        return $this->users->count() == 0;
    }
}
