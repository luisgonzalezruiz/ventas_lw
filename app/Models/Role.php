<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\User;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Traits\RoleFilterable;

class Role extends SpatieRole
{
    public function canDelete() 
    {
        return $this->users->count() == 0;
    }
}
