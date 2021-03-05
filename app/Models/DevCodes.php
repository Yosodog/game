<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevCodes extends Model
{
    public $table = 'dev_codes';
    public $guarded = [];

    /**
     * If the code has already been used, then return a false. If it has not been used return true.
     *
     * @return bool
     */
    public function validateCode(): bool
    {
        if ($this->isUsed)
            return false;

        return true;
    }

    /**
     * Run when the code has been used.
     *
     * Will update the code to mark it as used and will set the used by value to the username of the user
     *
     * @param string $user
     */
    public function useCode(string $user)
    {
        $this->isUsed = true;
        $this->usedBy = $user;
        $this->save();
    }
}
