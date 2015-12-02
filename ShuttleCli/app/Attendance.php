<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 02/12/15
 * Time: 17:43
 */

namespace ShuttleCli;


use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['trip', 'user'];
}