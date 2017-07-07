<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = "email_templates";

    protected $fillable = ["type", "subject", "body"];

    public function isOrganization() {
       return $this->type == "organization";
    }

    public function isExternal() {
       return $this->type == "external";
    }
}
